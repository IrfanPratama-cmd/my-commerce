<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Transaction;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request){
        $page = "Data Transaction";

        if ($request->ajax()) {
            $data = Transaction::with('user', 'checkout', 'checkout.product')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                            $btn = '<a href="/transactions/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Detail" class="detail btn btn-primary btn-sm">Detail</a> ';
                            return $btn;
                    })
                    ->addColumn('formatted_price', function ($data) {
                        return number_format($data->price_after_tax); // Adjust the formatting as per your currency requirements
                    })
                    ->rawColumns(['formatted_price'])
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('transaction.index', compact('page'));
    }

    public function show($id){
        $data = Transaction::with('user', 'checkout', 'checkout.product')->where('id', $id)->first();
        $page = "Detail Transaction";
        $profile = UserProfile::where('user_id', $data->user_id)->first();

        // return response()->json($data);
        return view('transaction.detail', compact('data', 'page', 'profile'));
    }

}
