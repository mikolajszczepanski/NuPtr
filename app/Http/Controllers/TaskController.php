<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Lang;
use DB;
use Auth;
use App;
use Log;
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

    public function index($alias = null,$paginate = 15){
        
        $tasks = Task::where('deleted',false);
        
        if(!empty($alias) && strlen($alias) >= 1 && strlen($alias) <= 20){
            $category = Category::where('alias',$alias)->first();
            if($category){
                $tasks = $tasks->where('category_id',$category->id);
            }
        }
        
        $tasks = $tasks->orderBy('created_at','desc')
                       ->paginate($paginate);
         
        Task::resolveTasksDependencies($tasks);
        
          
        return view('task/index',['tasks' => $tasks,
                                  'alias' => $alias]);
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
        
        Task::resolveTaskDependencies($task, $categories);

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
}
