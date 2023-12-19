<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
   public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
                $transaction = Transaction::find($request->order_id);
                $transaction->update(['transaction_status' => 'paid']);
            }
        }
   }

   public function invoice($id){
        $transaction = Transaction::findOrFail($id);

        $profile = UserProfile::where('user_id', $transaction->user_id)->first();

        $category = Category::all();

        $checkout = DB::table('checkouts')
        ->join('product', 'checkouts.product_id', '=', 'product.id')
        ->select('product.product_name','product.product_code', 'checkouts.qty', DB::raw('checkouts.qty * product.price AS total_price'))
        ->where('transaction_id', $transaction->id)
        ->get();

        return view('ecommerce.invoice.index', compact('transaction', 'checkout', 'profile', 'category'));
   }


   public function index(){
     $transaction = Transaction::with('user', 'checkout', 'checkout.product')->where('user_id', auth()->user()->id)->get();
     $category = Category::all();

     return view('ecommerce.transaction.index', compact('transaction', 'category'));
   }

   public function cancel($id){
      $transaction = Transaction::where('id', $id)->update(["transaction_status" => "cancel"]);
      return redirect()->back()->with('success', 'Transaction has been canceled!');
   }
}
