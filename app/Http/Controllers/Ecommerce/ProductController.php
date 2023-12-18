<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index(){
        // $product = Product::with('asset')->paginate(12);
        $category = Category::all();

        $product = QueryBuilder::for(Product::class)
        ->allowedFilters(['product_code', 'product_name', 'id', 'category_id', 'category.category_name', 'brand_id', 'brand.brand_name'])
        ->allowedSorts(['product_name', 'price']) // Kolom yang diizinkan untuk diurutkan
        ->defaultSort('-created_at') // Pengurutan default
        ->with(['category', 'brand', 'asset'=> function($query){
            $query->where('is_primary', 1);
        }])->paginate(12);

        // return response()->json($product);
        return view('ecommerce.product.index', compact('product', 'category'));
    }
}
