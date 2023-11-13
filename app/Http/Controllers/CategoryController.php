<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-category' , ['only' => ['index','show']]);
        $this->middleware('can:create-category', ['only' => ['create','store']]);
        $this->middleware('can:update-category', ['only' => ['edit','update']]);
        $this->middleware('can:delete-category', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        $page = "Master Data Category";

        if ($request->ajax()) {
            $data = Category::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('category.index', compact('page'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            "category_code" => "required",
            "category_name" => "required"
        ]);
        Category::updateOrCreate(['id' => $request->id],
                ['category_code' => $request->category_code, 'category_name' => $request->category_name]);

        return response()->json(['success'=>'Category saved successfully.']);

    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function destroy($id)
    {
        $check = Product::where('category_id', $id)->count();
        if($check != 0){
            return response()->json(['error'=>'Category has been used.']);
        }else {
            Category::find($id)->delete();
            return response()->json(['response'=>'Category deleted successfully.']);
        }
    }
}
