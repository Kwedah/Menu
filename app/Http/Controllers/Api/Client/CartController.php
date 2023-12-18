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
//                                  <-------------------- remove Cart -------------------->
    public function removeFromCart($id){
        $cart = Cart::where('product_id' , $id)->where('client_id' , Auth::guard('client_api')->user()->id)->first();
        if($cart){
            Cart::destroy($cart->id);
        }
        $allCart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->get();
        if($cart){
            $total_price = 0 ;
            foreach($allCart as $c){
                $total_price = $total_price + $c->total_price;
                $c['product_name'] = Product::find($c->product_id)->name;
                $c['product_image'] = Product::find($c->product_id)->image;
            }
            $delivery_tax = DeliveryTax::find(1)->delivery_tax ;

            // $cart->delete();
            Cart::destroy($cart->id);
            return $this->helper->ResponseJson( 1 , 'لقد تم حذف منتج من سلتك' , ['cart'=>$allCart , 'total'=>$total_price , 'delivery_tax' => $delivery_tax]);
        }else{
            $total_price = 0 ;
            foreach($allCart as $c){
                $total_price = $total_price + $c->total_price;
                $c['product_name'] = Product::find($c->product_id)->name;
                $c['product_image'] = Product::find($c->product_id)->image;
            }
            $delivery_tax = DeliveryTax::find(1)->delivery_tax ;

            return $this->helper->ResponseJson( 0 , 'سلتك ليس بها هذا المنتج' , ['cart' => $allCart, 'total' => $total_price  , 'delivery_tax' => $delivery_tax]);
        }
    }
//                                  <-------------------- increaseCart -------------------->
    public function increaseCart($id)
    {
        $product = Product::find($id);
        if($product){
            $existedCart = Cart::where('product_id' , $id)->where('client_id' , Auth::guard('client_api')->user()->id)->first();
            if($existedCart){
                $existedCart->quantity = $existedCart->quantity + 1;
                $existedCart->save();
                $existedCart->total_price = $existedCart->quantity * $product->price;
                $existedCart->save();
                $allCart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->get();
                $total_price = 0 ;
                foreach($allCart as $c){
                    $total_price = $total_price + $c->total_price;
                    $c['product_name'] = Product::find($c->product_id)->name;
                    $c['product_image'] = Product::find($c->product_id)->image;
                }
                $delivery_tax = DeliveryTax::find(1)->delivery_tax;
                return $this->helper->ResponseJson(1 , 'لقد قمت بتقليل كمية المنتج' , ['cart' => $allCart , 'total' => $total_price , 'delivery_tax' => $delivery_tax]);
            }else{
                return $this->helper->ResponseJson(0 , 'السلة ليس بها هذا المنتج');
            }
        }else{
            return $this->helper->ResponseJson(0 , 'منتج غير موجود');

        }
    }
//                                  <-------------------- decreaseCart -------------------->

    public function decreaseCart($id){
        $product = Product::find($id);
        if($product){
            $existedCart = Cart::where('product_id' , $id)->where('client_id' , Auth::guard('client_api')->user()->id)->first();
            if($existedCart){
                if($existedCart->quantity > 0){
                    $existedCart->quantity = $existedCart->quantity - 1;
                    $existedCart->save();
                    $existedCart->total_price = $existedCart->quantity * $product->price;
                    $existedCart->save();
                    $existedCart = Cart::where('product_id' , $id)->where('client_id' , Auth::guard('client_api')->user()->id)->first();
                    $allCart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->get();
                    $total_price = 0;
                    foreach($allCart as $c){
                        $total_price = $total_price + $c->total_price;
                        $c['product_name'] = Product::find($c->product_id)->name;
                        $c['product_image'] = Product::find($c->product_id)->image;
                    }
                    $delivery_tax = DeliveryTax::find(1)->delivery_tax ;
                    return $this->helper->ResponseJson(1 , 'لقد قمت بتقليل كمية المنتج' , ['cart' => $allCart , 'total' => $total_price , 'delivery_tax' => $delivery_tax]);

                }
            }else{
                return $this->helper->ResponseJson(0 , 'السلة ليس بها هذا المنتج');
            }
        }else{
            return $this->helper->ResponseJson(0 , 'منتج غير موجود');

        }
    }
//                                  <-------------------- delete Cart -------------------->
    public function clearCart(){
        $cart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->get();
        foreach($cart as $f){
            Cart::destroy($f->id);
        }
        return $this->helper->ResponseJson(1 , 'لقد تم مسح العربة');
    }
}



