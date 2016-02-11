<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['alias' => 'cpp', 'name' => 'C++']); 
        Category::create(['alias' => 'c', 'name' => 'C']); 
        Category::create(['alias' => 'java', 'name' => 'Java']); 
    }
}
