<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Models\Modul;
use App\Models\ModulPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-role');
    }

    public function index(Request $request){
        $page = "Master Data Role";

        if ($request->ajax()) {
            $data = Role::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="/roles/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRole">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('roles.index', compact('page'));
    }

    public function create(){
        $page = "Create Data Role";
        $permission = Modul::with('permission')->get();
        return view('roles.create',compact('permission', 'page'));
        // return response()->json(['data'=> $p]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    public function edit($id)
    {
        // $role = Role::find($id);
        // return response()->json($role);
        $page = "Edit Data Role";
        $role = Role::find($id);
        $permission = Modul::with('permission')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions', 'page'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        $checkUser = User::where('role_id', $id)->count();
        if($checkUser != 0){
            return response()->json(['error'=>'Role has been used.']);
        }else {
            Role::find($id)->delete();
            RoleHasPermission::where('role_id', $id)->delete();
            return response()->json(['response'=>'Role deleted successfully.']);
        }
    }
}
