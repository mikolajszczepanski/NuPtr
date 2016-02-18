<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_messages_categories',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        
        DB::table('contact_messages_categories')->insert(array(
            'name' => 'suggestion',
        ));
        
        DB::table('contact_messages_categories')->insert(array(
            'name' => 'bug_report',
        ));
        
        DB::table('contact_messages_categories')->insert(array(
            'name' => 'other',
        ));
        
        Schema::create('contact_messages',function(Blueprint $table){
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('contact_messages_categories');
            $table->string('email',40)->nullable();
            $table->text('text');
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
        Schema::drop('contact_messages');
        Schema::drop('contact_messages_categories');
    }
}
