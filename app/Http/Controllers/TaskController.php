<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;

class TaskController extends Controller
{

    public function index(){
        
        $tasks = Task::paginate(15);
        
        return view('task/index',['tasks' => $tasks]);
    }
    
    public function getCreateView(){

        return view('task/create');
    }
    
    
    public function create(Request $request){
        
        $this->validate($request, [
            'name' => 'required|max:60|min:4',
            'author' => 'required|max:60|min:4',
            'description' => 'max:500',
            'category' => 'required|max:20|min:1',
            'files.*.name' => 'required|min:4|max:60',
            'files.*.content' => 'required|min:4|max:1000000',
        ]);
        
        $name = $request->input('name');
        $author = $request->input('author');
        $description = $request->input('description');
        $category = $request->input('category');
        $filesArray = $request->input('files');
        
        var_dump($filesArray);
        
        return;
    }
}
