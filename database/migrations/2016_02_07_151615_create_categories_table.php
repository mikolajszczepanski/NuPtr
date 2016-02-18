<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('categories',function(Blueprint $table){
            $table->increments('id');
            $table->string('alias',20);
            $table->string('name',60);
            $table->string('script',25);
            $table->timestamps();
        });
        
        DB::table('categories')->insert(array(
            'alias' => 'cpp',
            'name' => 'C++',
            'script' => 'shBrushCpp.js'
            ));
        
        DB::table('categories')->insert(array(
            'alias' => 'c',
            'name' => 'C',
            'script' => 'shBrushCpp.js'
            ));
        
        DB::table('categories')->insert(array(
            'alias' => 'java',
            'name' => 'Java',
            'script' => 'shBrushJava.js'
            ));
        DB::table('categories')->insert(array(
            'alias' => 'py',
            'name' => 'Python',
            'script' => 'shBrushPython.js'
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
