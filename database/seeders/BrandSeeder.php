<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create(['brand_code' => 'SM','brand_name' => 'Samsung']);
        Brand::create(['brand_code' => 'XM','brand_name' => 'Xiaomi']);
        Brand::create(['brand_code' => 'AS','brand_name' => 'Asus']);
        Brand::create(['brand_code' => 'IP','brand_name' => 'Iphone']);
    }
}
