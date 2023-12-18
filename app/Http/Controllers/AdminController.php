<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
   public function admin(){
        $product = Product::count();
        $category = Category::count();
        $brand = Brand::count();
        $user = User::count();

        return view('main', compact('product', 'category', 'user', 'brand'));
   }
}
