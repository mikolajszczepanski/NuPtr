<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use Lang;
use DB;
use Auth;
use App;
use Log;
use Cache;
use App\Task;
use App\TaskFile;
use App\Alert;
use App\Category;
use App\Solution;
use App\SolutionFile;
use App\User;
use App\Statistic;

class TaskController extends Controller
{

    public function index(Request $request = null,$alias = null,$paginate = 15){
        $time_start = microtime(true);
          
        $tasks = Task::where('deleted',false);
        
        if(!empty($alias) && strlen($alias) >= 1 && strlen($alias) <= 20){
            $categories = Category::getAllFromCache();
            $found_category = null;
            foreach($categories as $category){
                if($category->alias == $alias){
                    $found_category = $category;
                    break;
                }
            }
            if($found_category){
                $tasks = $tasks->where('category_id',$found_category->id);
            }
        }
        
        if(!$alias){
            $alias = '';
        }
        $current_page = !empty($request->input('page')) ? (int) $request->input('page') : 1;
        
        $cache_name = __METHOD__.'_alias='.$alias.'paginate='.$paginate.'page='.$current_page;
        $tasks = Cache::remember(
                $cache_name,
                Config::get('constants.CACHE_TIME_HOUR'), 
                function()
                use ($tasks,$paginate,$cache_name)
        {
            if(App::environment('local')) {
                Log::debug('Cache: '.$cache_name);
            }
            return $tasks->orderBy('created_at','desc')
                   ->paginate($paginate);
        });
         
        Task::resolveTasksDependencies($tasks);
        
        $time_end = microtime(true);  
        return view('task/index',['tasks' => $tasks,
                                  'alias' => $alias,
                                  'debug_time_of_execution' => ($time_end - $time_start)]);
    }
    
    
    public function search(Request $request = null,$paginate = 15){
        
        $string = $request->input('s');
        $tasks = Task::where('deleted',false);
        if(!empty($string)){
            
            if(is_numeric($string)){
                $tasks = $tasks->where('id',$string);
            }
            else{
                $tasks = $tasks->where(function($query) use ($string){
                   $query->where('author','LIKE','%'.$string.'%')
                           ->orWhere('name','LIKE','%'.$string.'%')
                           ->orWhere('description','LIKE','%'.$string.'%');
                });
            }
            
            
            $tasks = $tasks->orderBy('created_at','desc')
                       ->paginate($paginate);
         
            Task::resolveTasksDependencies($tasks);
        }
        else{
            $tasks = null;
        }

        return view('task/search',['tasks' => $tasks,
                                  'search' => $string,
                                  'alias' => null]);
        
    }
    
    


    public function getCreateView($task_id = null){
        
        $categories = Category::all();
        
        
        return view('task/create',
                [
                    'categories' => $categories,
                    'task' => null
                ]);
    }
    
    public function getEditView($task_id = null){
        $categories = Category::all();
        
        $task = null;
        if(!empty($task_id)&&  is_numeric($task_id)){
            $task = Task::where('id',$task_id)
                    ->where('user_id',Auth::user()->id)
                    ->where('deleted',false)
                    ->first();
        }
        if(!$task){
            abort(404);
        }
         
        $task->files = TaskFile::where('deleted',false)
                ->where('task_id',$task_id)
                ->where('user_id',Auth::user()->id)
                ->get();

        return view('task/create',
                [
                    'categories' => $categories,
                    'task' => $task
                ]);
    }
    
    public function viewTask($id = null){
        return redirect(action('TaskController@search').'?s='.$id);
    }
    
    public function viewTaskFile($id = null){
        
        $taskFile = TaskFile::where('id',$id)
                ->where('deleted',false)
                ->first();
        
        if(!$taskFile){
            abort(404);
        }
        $task = Task::where('id',$taskFile->task_id)
                ->first();
        
        if(!$task){
            abort(404);
        }
        
        $category = Category::where('id',$task->category_id)
                ->first();
        
        
        if(!$category){
            abort(500);
        }
        
        return view('task/file',['taskFile' => $taskFile,
                                 'task' => $task,
                                 'alias' => $category->alias,
                                 'script' => $category->script]);
        
    }
    
    
    public function createOrEdit(Request $request){
        

        $this->validate($request, [
            'name' => 'required|max:60|min:4',
            'author' => 'required|max:60|min:4',
            'description' => 'max:500',
            'category_id' => 'required|numeric',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.data' => 'required|min:2|max:1000000',
        ],['files' => 'test']);
        $category = Category::where('id',$request->input('category_id'))->first();
        if(!$category){
            App::abort(406);
        }
        $task_id = $request->input('task_id');
        
        $task = null;
        if(!empty($task_id) && is_numeric($task_id)){
            $task = Task::where('id',$task_id)
                    ->where('user_id',$request->user()->id)
                    ->where('deleted',false)
                    ->first();
            if(!$task){
                abort(406);
            }
            DB::table('task_files')
                    ->where('task_id',$task_id)
                    ->where('user_id',$request->user()->id)
                    ->update(array('deleted' => true));
        }
        else{
            $task_id = null;
            $task = new Task;
            Statistic::AddTask();
        }
        
        $task->name = $request->input('name');
        $task->author = $request->input('author');
        $task->description = $request->input('description');
        $task->category_id = $request->input('category_id');
        $task->user_id = $request->user()->id;
        $filesArray = $request->input('files');
        
        $pass = $task->save();
        $this->clearCache($task);
        
        if(is_array($filesArray)){
            
            foreach($filesArray as $file){

                $taskFile = new TaskFile;

                $taskFile->name = $file['name'];
                $taskFile->data = $file['data'];
                $taskFile->user_id = $request->user()->id;
                $taskFile->task_id = $task->id;

                if(!$taskFile->save()){
                    $pass = false;
                }
            }
            
        }
        
               
        if($pass){
            Alert::setSuccessAlert(Lang::get('app.task_saved'));
        }
        else{
            Log::alert(__METHOD__.'('.__FILE__.')', array(
                                  'task_id' => $task->id,
                                  'user_id' => Auth::user()->id,
            ));
             
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        
            
        return redirect()->action('HomeController@index');
    }
    
    public function getDeleteView($task_id = null){
        
        if(empty($task_id) || !is_numeric($task_id)){
            abort(406);
        }
        
        $task = Task::where('id',$task_id)
                ->where('deleted',false)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        if(!$task){
            abort(404);
        }
            
        return view('task/delete',['task' => $task]);
    }
    
    public function delete(Request $request){
        $this->validate($request, [
            'task_id' => 'required|numeric',
        ]);
        $task_id = $request->input('task_id');
        $task = Task::where('id',$task_id)
                ->where('deleted',false)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        if(!$task){
            abort(404);
        }
        
        $task->deleted = true;
        
        $pass = $task->save();
        
        $this->clearCache($task);
        
        if($pass){
            Alert::setSuccessAlert(Lang::get('app.deleted_task'));
        }
        else{
            
            Log::alert(__METHOD__.'('.__FILE__.')', array(
                                  'task_id' => $task->id,
                                  'user_id' => Auth::user()->id,
            ));
            
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        
        Statistic::SubTask();    
        return redirect()->action('UserController@tasks');
        
    }
    
    private function clearCache($task){
        $cache_name = 'App\Task::resolveTaskDependencies_task_id='.$task->id;
        Cache::forget($cache_name);  
        if(App::environment('local')) {
            Log::debug('Clear: '.$cache_name);
        }
    }
}
