<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-role');
    }

    public function index(Request $request){
        $page = "Master Data Permission";

        if ($request->ajax()) {
            $data = Permission::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editGroup">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRole">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('permission.index', compact('page'));
    }

    public function store(Request $request)
    {
        Permission::updateOrCreate(['id' => $request->id],
                ['name' => $request->name, 'guard_name' => $request->guard_name]);

        return response()->json(['success'=>'Permission saved successfully.']);
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    public function destroy($id)
    {
        $check = RoleHasPermission::where('permission_id', $id)->count();
        if($check != 0){
            return response()->json(['error'=>'Permission has been used.']);
        }else {
            Permission::find($id)->delete();
            return response()->json(['response'=>'Permission deleted successfully.']);
        }
    }
}
