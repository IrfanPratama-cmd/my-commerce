<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-brand' , ['only' => ['index','show']]);
        $this->middleware('can:create-brand', ['only' => ['create','store']]);
        $this->middleware('can:update-brand', ['only' => ['edit','update']]);
        $this->middleware('can:delete-brand', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        $page = "Master Data Brand";

        if ($request->ajax()) {
            $data = Brand::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBrand">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBrand">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('brand.index', compact('page'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            "brand_code" => "required",
            "brand_name" => "required"
        ]);
        Brand::updateOrCreate(['id' => $request->id],
                ['brand_code' => $request->brand_code, 'brand_name' => $request->brand_name]);

        return response()->json(['success'=>'Brand saved successfully.']);

    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    public function destroy($id)
    {
        $check = Product::where('brand_id', $id)->count();
        if($check != 0){
            return response()->json(['error'=>'Brand has been used.']);
        }else {
            Brand::find($id)->delete();
            return response()->json(['response'=>'Brand deleted successfully.']);
        }
    }
}
