<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $product = Product::with(['asset' => function($query) {
            $query->where('is_primary', 1);
        }])->get();
        $category = Category::all();
        $brand = Brand::leftJoin('products', 'brands.id', '=', 'products.brand_id')
        ->select('brands.id', 'brands.brand_name', DB::raw('COUNT(products.id) as product_count'))
        ->groupBy('brands.id', 'brands.brand_name')->get();

        // return response()->json($product);

        return view('ecommerce.layout.main',compact('product', 'category', 'brand'));
    }

    public function showProduct($id){
        $category = Category::all();
        $product = Product::find($id);
        $asset = ProductAsset::where('product_id', $id)->get();
        return view('ecommerce.detail.main', compact('category', 'product', 'asset'));
    }
}
