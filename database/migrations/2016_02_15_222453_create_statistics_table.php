<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;
use App\Statistic;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('statistics',function(Blueprint $table){
            $table->increments('id');
            $table->string('name')->unique();
            $table->bigInteger('value');
            $table->timestamps();
        });
        
        /**
         * Order is important. Don't make changes!
         */
        DB::table('statistics')->insert(array(
            'name' => 'users',
            'value' => 0
            ));
        DB::table('statistics')->insert(array(
            'name' => 'tasks',
            'value' => 0
            ));
        DB::table('statistics')->insert(array(
            'name' => 'solutions',
            'value' => 0
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statistics');
    }
}
