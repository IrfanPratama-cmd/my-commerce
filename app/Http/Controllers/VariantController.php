<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VariantController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:read-brand' , ['only' => ['index','show']]);
        // $this->middleware('can:create-brand', ['only' => ['create','store']]);
        // $this->middleware('can:update-brand', ['only' => ['edit','update']]);
        // $this->middleware('can:delete-brand', ['only' => ['destroy']]);
    }   

    public function index(Request $request){
        $page = "Master Data Variant";

        if ($request->ajax()) {
            $data = Variant::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editVariant">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteVariant">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('variant.index', compact('page'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            "variant_name" => "required",
            "description" => "required"
        ]);
        Variant::updateOrCreate(['id' => $request->id],
                ['variant_name' => $request->variant_name, 'description' => $request->description]);

        return response()->json(['success'=>'Variant saved successfully.']);

    }

    public function edit($id)
    {
        $variant = Variant::find($id);
        return response()->json($variant);
    }

    public function destroy($id)
    {
        $check = ProductVariant::where('variant_id', $id)->count();
        if($check != 0){
            return response()->json(['error'=>'Variant has been used.']);
        }else {
            Variant::find($id)->delete();
            return response()->json(['response'=>'Variant deleted successfully.']);
        }
    }

}
