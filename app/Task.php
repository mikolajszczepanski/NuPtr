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
            Task::resolveTaskDependencies($task,$categories);
        }
        
        return $tasks;
    }
    
    
    static public function resolveTaskDependencies(&$task, $categories = null) {
        if(!$categories){
            $categories = Category::all();
        }
        $task->category_name = $categories[$task->category_id - 1]->name;
        $task->files = TaskFile::where('task_id',$task->id)
                        ->where('deleted',false)
                        ->get();

        $task->solutions = Solution::getTaskSolutionsDependencies($task->id);

    }

}
