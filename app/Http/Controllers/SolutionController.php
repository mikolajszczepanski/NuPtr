<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SolutionController extends Controller
{
    public function getCreateView($id = null){
        
        return view('solution/create',['id' => $id]);
    }
    
    public function create(Request $request){
        
        $this->validate($request, [
            'id' => 'required|numeric',
            'author' => 'required|max:60|min:4',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.content' => 'required|min:2|max:1000000',
        ]);
        
    }
}
