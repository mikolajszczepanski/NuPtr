<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Task;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nowDateMinusWeek = date('d-m-Y', strtotime("-1 week")).' 00:00:00';
        $tasks = Task::where('deleted',false)
                ->where('created_at','>=',$nowDateMinusWeek)
                ->orderBy('created_at','desc')
                ->paginate(15);
         
        Task::resolveTasksDependencies($tasks);
        
        return view('home/index',['tasks' => $tasks]);
    }
    
    public function contact()
    {
        return view('home/contact');
    }
}
