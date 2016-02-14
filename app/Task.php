<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TaskFile;
use App\SolutionFile;
use App\Category;
use DB;

class Task extends Model
{
    protected $table = 'tasks';
    
    static public function resolveTasksDependencies(&$tasks = null){
        
        $categories = Category::all();
               
        foreach($tasks as $task){
            $task->category_name = $categories[$task->category_id - 1]->name;
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
        
        return $tasks;
    }
}
