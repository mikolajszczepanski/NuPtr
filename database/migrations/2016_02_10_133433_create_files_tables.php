<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solution_files',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',60);
            $table->text('data');
            $table->bigInteger('user_id');
            $table->bigInteger('solution_id');
            $table->timestamps();
        });
        
        Schema::create('task_files',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',60);
            $table->text('data');
            $table->bigInteger('user_id');
            $table->bigInteger('task_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solution_files');
        Schema::drop('task_files');
    }
}
