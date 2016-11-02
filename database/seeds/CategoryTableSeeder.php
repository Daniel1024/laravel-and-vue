<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Laravel']);
        Category::create(['name' => 'Elixir']);
        Category::create(['name' => 'Homestead']);
        Category::create(['name' => 'Sass']);
        Category::create(['name' => 'Less']);
        Category::create(['name' => 'Stylus']);
        Category::create(['name' => 'JavaScript']);
        Category::create(['name' => 'Python']);
    }
}
