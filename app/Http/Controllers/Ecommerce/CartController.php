<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(){
        $cart = Cart::with(['product', 'product.asset' => function($query) {
            $query->where('is_primary', 1);
        }])->where('user_id', auth()->user()->id)->get();

        $category = Category::all();

        $totalPrice = DB::table('carts')
        ->join('products', 'carts.product_id', '=', 'products.id')
        ->select(DB::raw('SUM(carts.qty * products.price) AS total_price'))
        ->where('user_id', auth()->user()->id)
        ->first();

        $tax = 11;
        $taxPrice = $totalPrice->total_price * $tax / 100;

        // dd($total);
        // return response()->json($totalPrice);
        return view('ecommerce.cart.index', compact('cart', 'totalPrice', 'taxPrice', 'category'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $checkCart = Cart::where([['product_id', $id], ['user_id', auth()->user()->id]])->first();

        if($checkCart != null){
          $data =  $checkCart->qty + 1;
          $cart =  Cart::where([['product_id', $id], ['user_id', auth()->user()->id]])->update(["qty" => $data]);
        }else{
            Cart::create(
                [
                    'user_id' => auth()->user()->id,
                    'product_id' => $id,
                    'qty' => 1,
                    'price' => $product->price,
                ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function destroy($id){
        Cart::find($id)->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function addQty($id){
        $cart = Cart::find($id)->first();
        Cart::where([['id', $id], ['user_id', auth()->user()->id]])->update(["qty" => $cart->qty+1]);
        return redirect()->back();
    }

    public function rmQty($id){
        $cart = Cart::find($id)->first();
        Cart::where([['id', $id], ['user_id', auth()->user()->id]])->update(["qty" => $cart->qty-1]);
        return redirect()->back();
    }

    public function update(Request $request, $id, $productId)
    {
        $quantity = $request->input('quantity');
        // $productId = $request->input('product_id');

        $checkQty = Product::where('id', $productId)->first();
        $stock = $checkQty->stock;

        if ($quantity > $stock){
            return response()->json(['aaaa'=>'Product stock is not avaiable']);
        }

        Cart::where('id', $id)->update(['qty' => $quantity, 'product_id' => $productId, 'user_id' => auth()->user()->id]);
        $data = [
            'cart_id' => $id,
            'product_id' => $productId,
            'qty' => $quantity,
            'max_qty' => $stock,
        ];

        return response()->json($data);

    }

    public function countCart(){
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->count();
        } else {
            $cart = 0;
        }

        $data = [
            // Your fetched data
            'total' => $cart,
            // Add more data as needed
        ];

        return response()->json($data);
    }
}
