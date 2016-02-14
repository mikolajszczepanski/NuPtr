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
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('solution_id')->unsigned();
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->boolean('deleted')->default(0);
            $table->timestamps();
        });
        
        Schema::create('task_files',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',60);
            $table->text('data');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->boolean('deleted')->default(0);
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
