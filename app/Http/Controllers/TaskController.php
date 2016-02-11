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

class TaskController extends Controller
{

    public function index($paginate = 15){
        
        $tasks = Task::orderBy('created_at','desc')->paginate($paginate);
        
        foreach($tasks as $task){
            $task->files = TaskFile::where('task_id','=',$task->id)->get();
                        
            $solutions = DB::table('solutions')
                    ->join('users','solutions.user_id','=','users.id')
                    ->where('solutions.task_id',$task->id)
                    ->select(array('users.id',
                                   'solutions.id',
                                   'users.name AS user_name',
                                   'solutions.created_at'))
                    ->get();
            
            foreach($solutions as $solution){
                $solution->files = SolutionFile::where('solution_id',$solution->id)->get();
            }
            $task->solutions = $solutions;
        }
          
        return view('task/index',['tasks' => $tasks]);
    }
    
    public function getCreateView(){
        
        $categories = Category::all();
        
        return view('task/create',['categories' => $categories]);
    }
    
    public function viewTask($id = null){
        
    }
    
    public function viewTaskFile($id = null){
        
        $taskFile = TaskFile::where('id',$id)->first();
        
        if(!$taskFile){
            App::abort(404);
        }
        
        return view('task/file',['taskFile' => $taskFile]);
        
    }
    
    
    public function create(Request $request){
        

        $this->validate($request, [
            'name' => 'required|max:60|min:4',
            'author' => 'required|max:60|min:4',
            'description' => 'max:500',
            'category_id' => 'required|numeric',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.content' => 'required|min:2|max:1000000',
        ]);
        $category = Category::where('id',$request->input('category_id'))->first();
        if(!$category){
            App::abort(406);
        }
        
        $task = new Task;
        
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
