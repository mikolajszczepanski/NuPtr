<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;
use App\Task;
use App\TaskFile;
use App\Alert;
use Session;

class TaskController extends Controller
{

    public function index($paginate = 15){
        
        $tasks = Task::orderBy('created_at','desc')->paginate($paginate);
        
        foreach($tasks as $task){
            $task->files = TaskFile::where('task_id','=',$task->id)->get();
        }
        return view('task/index',['tasks' => $tasks]);
    }
    
    public function getCreateView(){

        return view('task/create');
    }
    
    public function viewTask($id = null){
        
    }
    
    public function viewTaskFile($id = null){
        
        $taskFile = TaskFile::where('id',$id)->first();
        
        if(!$taskFile){
            App::abort(404);
        }
        
        return view('task/taskfile',['taskFile' => $taskFile]);
        
    }
    
    
    public function create(Request $request){
        

        $this->validate($request, [
            'name' => 'required|max:60|min:4',
            'author' => 'required|max:60|min:4',
            'description' => 'max:500',
            'category' => 'max:20',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.content' => 'required|min:2|max:1000000',
        ]);
        
        
        $task = new Task;
        
        $task->name = $request->input('name');
        $task->author = $request->input('author');
        $task->description = $request->input('description');
        $task->category = $request->input('category');
        $task->user_id = $request->user()->id;
        $filesArray = $request->input('files');

        $pass = $task->save();
      
        if(is_array($filesArray)){
            
            foreach($filesArray as $file){

                $taskFile = new TaskFile;

                $taskFile->name = $file['name'];
                $taskFile->data = $file['content'];
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
}
