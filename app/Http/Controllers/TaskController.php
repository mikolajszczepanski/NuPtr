<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;
use App\Task;
use App\TaskFile;
use App\Alert;
use App\Category;
use App\Solution;
use App\SolutionFile;
use App\User;
use DB;
use Auth;

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
        
    }
    
    public function viewTaskFile($id = null){
        
        $taskFile = TaskFile::where('id',$id)
                ->where('deleted',false)
                ->first();
        
        if(!$taskFile){
            abort(404);
        }
        
        return view('task/file',['taskFile' => $taskFile]);
        
    }
    
    
    public function createOrEdit(Request $request){
        

        $this->validate($request, [
            'name' => 'required|max:60|min:4',
            'author' => 'required|max:60|min:4',
            'description' => 'max:500',
            'category_id' => 'required|numeric',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.data' => 'required|min:2|max:1000000',
        ]);
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
            Alert::setSuccessAlert('Your task has saved.');
        }
        else{
            Alert::setErrorAlert('Something bad happend. Your task can be incompile or can\'t be save.');
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
            Alert::setSuccessAlert('Your task has been deleted.');
        }
        else{
            Alert::setErrorAlert('Unknown error.');
        }
        
            
        return redirect()->action('HomeController@index');
        
    }
}
