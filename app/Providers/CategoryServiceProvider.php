<?php

namespace App\Providers;

use DB;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('categories')){
            $minutesToRemember = Config::get('constants._HOUR_IN_MINUTES_');
            $categories = DB::table('categories')->get();
            view()->share('categories', $categories);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
