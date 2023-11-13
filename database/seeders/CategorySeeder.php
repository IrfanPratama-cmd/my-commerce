<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['category_code' => 'HP','category_name' => 'Handphone']);
        Category::create(['category_code' => 'TB','category_name' => 'Tablet']);
        Category::create(['category_code' => 'LP','category_name' => 'Laptop']);
    }
}
