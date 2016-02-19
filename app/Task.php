<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;
use App\TaskFile;
use App\SolutionFile;
use App\Category;
use Cache;
use DB;
use Config;
use Log;


class Task extends Model
{
    protected $table = 'tasks';
    
    static public function resolveTasksDependencies(&$tasks = null){
             
        $categories = Category::getAllFromCache();

        foreach($tasks as $task){
            Task::resolveTaskDependencies($task,$categories);
        }
        
        return $tasks;
    }
    
    
    static public function resolveTaskDependencies(&$task, $categories = null) {
        if(!$categories){
            $categories = Category::getAllFromCache();
        }
        $task->category_name = $categories[$task->category_id - 1]->name;
        $cache_name = __METHOD__.'_task_id='.$task->id;
        $task->files = Cache::remember(
                $cache_name,
                Config::get('constants.CACHE_TIME_DAY'), 
                function()
                use ($task,$cache_name)
        {
            if(App::environment('local')) {
                Log::debug('Cache: '.$cache_name);
            }
            return TaskFile::where('task_id',$task->id)
                        ->where('deleted',false)
                        ->select('id','name','user_id','task_id','created_at','updated_at')
                        ->get();
        });

        $task->solutions = Solution::getTaskSolutionsDependencies($task->id);

    }

}
