<?php

namespace App;

use Log;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $table = 'categories';
    
    static public function getAllFromCache() {
        $categories = Cache::rememberForever('categories', function() {
                    return Category::all();
                });
        return $categories;
    }

}
