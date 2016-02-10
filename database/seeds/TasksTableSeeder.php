<?php

use Illuminate\Database\Seeder;
use App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for($i = 0; $i < 10; $i++){ 
        $j = rand(0,1000);
        Task::create(['author' => 'Testowy Autor '.$j, 'name' => 'Testowe Zadanie '.$j]); 
       }
    }
}
