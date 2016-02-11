<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Solution;
use App\Task;
use App\SolutionFile;
use App\Alert;

class SolutionController extends Controller
{
    public function getCreateView($id = null){
        
        return view('solution/create',['id' => $id]);
    }
    
    public function create(Request $request){
        
        $this->validate($request, [
            'task_id' => 'required|numeric',
            'files' => 'required|array',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.content' => 'required|min:2|max:1000000',
        ]);
        
        $task_id = $request->input('task_id');
        $user_id = $request->user()->id;
        $filesArray = $request->input('files');
        
        $task = Task::where('id',$task_id)->first();
        if(!$task){
            abort(406);
        }
        
        $solution = new Solution();
        $solution->user_id = $user_id;
        $solution->task_id = $task_id;
        
        $pass = $solution->save();
        
        if(is_array($filesArray)){
            
            foreach($filesArray as $file){

                $solutionFile = new SolutionFile;

                $solutionFile->name = $file['name'];
                $solutionFile->data = $file['content'];
                $solutionFile->user_id = $request->user()->id;
                $solutionFile->solution_id = $solution->id;

                if(!$solutionFile->save()){
                    $pass = false;
                }
            }
            
        }
        
        if($pass){
            Alert::setSuccessAlert('Your solution has saved.');
        }
        else{
            Alert::setErrorAlert('Something bad happend. Your solution can be incompile or can\'t be save.');
        }
        
            
        return redirect()->action('HomeController@index');
        
    }
    
    
    public function viewSolutionFile($id = null){
        
        $solutionFile = SolutionFile::where('id',$id)->first();
        
        if(!$solutionFile){
            App::abort(404);
        }
        
        return view('solution/file',['solutionFile' => $solutionFile]);
        
    }
}
