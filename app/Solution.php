<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\SolutionFile;

class Solution extends Model
{
    protected $table = 'solutions';
    
    
    public static function getTaskSolutionsDependencies($task_id){
        $solutions = DB::table('solutions')
                ->join('users', 'solutions.user_id', '=', 'users.id')
                ->where('solutions.task_id', $task_id)
                ->where('solutions.deleted',false)
                ->select(array('users.id',
                    'solutions.id',
                    'users.name AS user_name',
                    'solutions.created_at'))
                ->get();

        Solution::resolveSolutionsFiles($solutions);

        return $solutions;
    }
    
    public static function getSolutionDependencies($solution_id){
        $solutions = DB::table('solutions')
                ->join('users', 'solutions.user_id', '=', 'users.id')
                ->where('solutions.id', $solution_id)
                ->where('solutions.deleted',false)
                ->select(array('users.id',
                    'solutions.id',
                    'users.name AS user_name',
                    'solutions.created_at'))
                ->get();
        
        Solution::resolveSolutionsFiles($solutions);

        return $solutions;
    }
    
    
    public static function resolveSolutionsFiles(&$solutions){
        foreach ($solutions as $solution) {
            Solution::resolveSolutionFiles($solution);
        }
    }
    
    public static function resolveSolutionFiles(&$solution){
        $solution->files = SolutionFile::where('solution_id', $solution->id)
                    ->where('deleted',false)
                    ->get();
    }
    
}
