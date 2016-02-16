<?php

namespace App;

use Log;
use DB;
use App\Task;
use App\User;
use App\Solution;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    
    protected $table = 'statistics';
    
    
    public static function AddTask(){
        Statistic::AddValueToStatistic(1,'tasks');
    }
    
    public static function SubTask(){
        Statistic::AddValueToStatistic(-1,'tasks');
    }
    
    public static function AddSolution(){
        Statistic::AddValueToStatistic(1,'solutions');
    }
    
    public static function SubSolution(){
        Statistic::AddValueToStatistic(-1,'solutions');
    }
    
    public static function AddUser(){
        Statistic::AddValueToStatistic(1,'users');
    }
    
    public static function SubUser(){
        Statistic::AddValueToStatistic(-1,'users');
    }
    
    private static function AddValueToStatistic($value,$statistic_name){
        $statistic = Statistic::where('name',$statistic_name)
                ->first();
        if(!$statistic){
            Log::critical(array(
                'method' => __METHOD__, 
                'value' => $value, 
                'name' => $statistic_name
                    ));
            return;
        }
        $statistic->value = $statistic->value + $value;
        $statistic->save();
    }
}
