<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
            $request->validate([
                "count" => "required",
                "product_id" => "required"
            ]);


            // Calculate of the price
            $productPrice = Product::find($request->product_id)->price;
            $totalPrice = $productPrice * $request->count;


            $cart = new Cart;
            $cart->count = $request->count;
            $cart->product_id = $request->product_id;
            $cart->total_price = $totalPrice;
            $cart->user_id = auth()->user()->id;
            $cart->save();

            return response()->json([
                "status" => 1,
                "messaga" => "وسع وسع ..وسع وسع",
                "data" => $cart
            ]);
    }

    public function getCart()
    {
        $cart = Cart::where('user_id' , auth()->user()->id)->get();

        return response()->json([
            "status" => 1,
            "messaga" => "وسع وسع ..وسع وسع",
            "cart" => $cart,
        ]);
    }

    public function removeCart()
    {

    }
}
