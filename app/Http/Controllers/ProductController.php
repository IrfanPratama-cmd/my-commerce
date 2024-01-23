<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-product' , ['only' => ['index','show']]);
        $this->middleware('can:create-product', ['only' => ['create','store']]);
        $this->middleware('can:update-product', ['only' => ['edit','update']]);
        $this->middleware('can:delete-product', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        $page = "Master Data Product";
        $category = Category::all();
        $brand = Brand::all();

        if ($request->ajax()) {
            $data = Product::with('category', 'brand')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="/products/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                            return $btn;
                    })
                    ->addColumn('formatted_price', function ($data) {
                        return number_format($data->price); // Adjust the formatting as per your currency requirements
                    })
                    ->rawColumns(['formatted_price'])
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('product.index', compact('page', 'category', 'brand'));
    }

    public function create(){
        $page = "Create Data Product";
        $category = Category::all();
        $brand = Brand::all();
        return view('product.create',compact('category','brand', 'page'));
    }

    public function uploads(Request $request)
    {
        $path = 'product-asset/';

        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
         $this->validate($request, [
            "product_code" => "required",
            "product_name" => "required",
            "category_id" => "required",
            "brand_id" => "required",
            "stock" => "required",
            "price" => "required",
            "asset" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product =   Product::create(
                [
                    'product_code' => $request->product_code,
                    'product_name' => $request->product_name,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'stock' => $request->stock,
                    'price' => $request->price,
                    'description' => $request->description
                ]);

         $time = time();

         if ($files = $request->file('asset')) {

            //delete old file
            File::delete('product/'.$request->asset);
            ProductAsset::where('product_id', $request->id)->delete();


            //insert new file
            $destinationPath = 'product-asset/'; // upload path
            $filename = $request->product_name. '.' . $time . '.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $filename);
            // $size = $request->file('asset')->getSize();
            $url = $destinationPath . $filename;

            ProductAsset::create([
                'product_id' => $product->id,
                'file_name' => $filename,
                'file_size' => "10",
                'file_url' => $url,
                'is_primary' => true
            ]);
         }

         $path = 'product-asset/';

         foreach($request->input('document', []) as $file) {
            ProductAsset::create([
                'product_id' => $product->id,
                'file_name' => $file,
                'file_size' => "12",
                'file_url' => $path . $file,
                'is_primary' => false
            ]);
         }

        // return response()->json(['success'=>'Product saved successfully.']);

        return redirect()->route('products.index')
                        ->with('success','Product created successfully');

    }

    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::all();
        $brand = Brand::all();
        $asset = ProductAsset::where(["product_id" => $id, "is_primary" => 1])->first();
        $images = ProductAsset::where(["product_id" => $id, "is_primary" => 0])->get();
        $page = "Create Data Product";

        // dd($asset);
        return view('product.edit', compact('page', 'product', 'category', 'brand', 'asset', 'images'));
    }

    public function update($id, Request $request){
        $rules = [
            "product_code" => "required",
            "product_name" => "required",
            "category_id" => "required",
            "brand_id" => "required",
            "stock" => "required",
            "price" => "required",
        ];

        $validatedData = $request->validate($rules);

        Product::where('id', $id)->update($validatedData);

         if ($files = $request->file('asset')) {

            //delete old file
            File::delete('product/'.$request->asset);
            ProductAsset::where('product_id', $request->id)->delete();


            //insert new file
            $destinationPath = 'product/'; // upload path
            $filename = $request->product_name . '.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $filename);
            // $size = $request->file('asset')->getSize();
            $url = $destinationPath . $filename;

            ProductAsset::create([
                'product_id' => $id,
                'file_name' => $filename,
                'file_url' => $url
            ]);
         }

        // return response()->json(['success'=>'Product saved successfully.']);

        return redirect()->route('products.index')
                        ->with('success','Update product successfully');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['response'=>'Product deleted successfully.']);
    }
}
