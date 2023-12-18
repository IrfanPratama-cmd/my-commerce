<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\Transaction;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;


class CheckoutController extends Controller
{
    public function index(){
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isSanitized = true;
        Config::$isProduction = false;
        Config::$is3ds = true;

        $profile = UserProfile::where('user_id', auth()->user()->id)->first();
        $category = Category::all();
        $transaction = Transaction::where('user_id', auth()->user()->id)->where('transaction_status', 'pending')->first();
        if($transaction == null){
            return view('ecommerce.checkout.null', compact('profile', 'category'));
        }
        $checkout = DB::table('checkouts')
        ->join('product', 'checkouts.product_id', '=', 'product.id')
        ->select('product.product_name', DB::raw('checkouts.qty * product.price AS total_price'))
        ->where('transaction_id', $transaction->id)
        ->get();

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->price_after_tax
            ],
            'customer_details' => [
                'name' => $profile->full_name,
                'phone' => $profile->phone_number,
                'email' => $profile->user->email,
                'address' => $profile->address
            ]
        ];
        // dd($params);
        $snapToken = Snap::getSnapToken($params);
        return view('ecommerce.checkout.index', compact('profile', 'transaction', 'checkout', 'snapToken', 'category'));
    }


    public function create(Request $request){
        // dd($request);
        $checkTransaction = Transaction::where('user_id', auth()->user()->id)->where('transaction_status', 'pending')->first();
        if($checkTransaction != null){
            return redirect()->back()->with('error', 'You have other transactions that have not been completed!');
        }
        $transaction = Transaction::create([
            'transaction_code' => Str::random(6),
            'transaction_time' => Carbon::now(),
            'user_id' => auth()->user()->id,
            'transaction_status' => "pending",
            'total_price' => $request->total_price,
            'total_tax' => $request->tax_price,
            'price_after_tax' => $request->price_after_tax
        ]);

        $cart = Cart::with('product')->where('user_id', auth()->user()->id)->get();

        foreach ($cart as $c) {
            Checkout::create([
                'product_id' => $c->product_id,
                'transaction_id' => $transaction->id,
                'qty' => $c->qty
            ]);
        }

        Cart::where('user_id', auth()->user()->id)->delete();

        return redirect()->route('checkout')
                        ->with('success','Checkout successfully');

    }
}
