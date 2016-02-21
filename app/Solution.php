<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App;
use Config;
use Cache;
use DB;
use Log;
use App\SolutionFile;

class Solution extends Model
{
    protected $table = 'solutions';
    
    
    public static function getTaskSolutionsDependencies($task_id){
        $cache_name = __METHOD__.'_task_id='.$task_id;
        $solutions = Cache::rememberForever(
                $cache_name,
                function()
                use ($task_id,$cache_name)
        {
            if(App::environment('local')) {
                Log::debug('Cache: '.$cache_name);
            }
            return DB::table('solutions')
                    ->join('users', 'solutions.user_id', '=', 'users.id')
                    ->where('solutions.task_id', $task_id)
                    ->where('solutions.deleted',false)
                    ->select(array('users.id',
                        'solutions.id',
                        'users.name AS user_name',
                        'solutions.created_at'))
                    ->get();
        });

        Solution::resolveSolutionsFiles($solutions);

        return $solutions;
    }
    
    public static function getSolutionDependencies($solution_id){
        $cache_name = __METHOD__.'_solution_id='.$solution_id;
        $solutions = Cache::rememberForever(
                $cache_name,
                function()
                use ($solution_id,$cache_name)
        {
            if(App::environment('local')) {
                Log::debug('Cache: '.$cache_name);
            }
            return DB::table('solutions')
                    ->join('users', 'solutions.user_id', '=', 'users.id')
                    ->where('solutions.id', $solution_id)
                    ->where('solutions.deleted',false)
                    ->select(array('users.id',
                        'solutions.id',
                        'users.name AS user_name',
                        'solutions.created_at'))
                    ->get();
        });
        
        Solution::resolveSolutionsFiles($solutions);

        return $solutions;
    }
    
    
    public static function resolveSolutionsFiles(&$solutions){
        foreach ($solutions as $solution) {
            Solution::resolveSolutionFiles($solution);
        }
    }
    
    public static function resolveSolutionFiles(&$solution){
        $cache_name = __METHOD__.'_solution_id='.$solution->id;
        $solution->files = Cache::rememberForever(
                $cache_name,
                function()
                use ($solution,$cache_name)
        {
            if(App::environment('local')) {
                Log::debug('Cache: '.$cache_name);
            }
            return SolutionFile::where('solution_id', $solution->id)
                    ->where('deleted',false)
                    ->select('id','name','user_id','solution_id','created_at','updated_at')
                    ->get();
        });
    }
    
}
