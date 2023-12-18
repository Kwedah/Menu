<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    Public function order(Request $request)
    {
        $request->validate([
            "delivery_id" => "required",
        ]);

        $carts = Cart::where('user_id', auth()->user()->id)->get();

        $totalPrice = 0;
        foreach($carts as $cart){
            $totalPrice = $totalPrice +  $cart->total_price;
         $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->total_price = $totalPrice;

        $order->delivery_id = $request->delivery_id;

        $order->save();

        return response()->json([
            "status" => 1,
            "message" => "The order has been registered successfully!",
            "data" => $order
        ]);
      }
    }

    Public function showOrder()
    {
        $order = Order::all();

        return response()->json([
            "status" => 1,
            "message" => "All Orders",
            "data" => $order
        ]);

        // $show_order = auth()->user();

        // $show_order = Order::find($request->id);
    }

    public function orderDelivered($id){
        $order = Order::find($id);
        if($order){
            $order->status = 'deliverd';
            $order->save();
            $cart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->where('restaurant_id' , $order->restaurant_id)->get();

            foreach($cart as $c ){
                $c->status = 'deliverd';
                $c->save();
            }
            return $this->helper->ResponseJson( 1 , 'تم الاستلام بنجاح');
            return $this->helper->ResponseJson( 0 , 'لا يوجد طلب بهذه البيانات');
        }else{
        }
    }

    public function orderNotDelivered($id){
        $order = Order::find($id);
        $order->status = 'not_delivered';
        $order->save();
        $cart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->where('restaurant_id' , $order->restaurant_id)->get();

        foreach($cart as $c ){
            $c->status = 'not_delivered';
            $c->save();
        }

        return $this->helper->ResponseJson( 0 , 'لم يتم استلام الاوردر , سنتواصل معك في غضون دقائق');
    }

    public function order2(){
        $cart = Cart::where('client_id' , Auth::guard('client_api')->user()->id)->where('ordered' , 'no')->get()->groupBy('restaurant_id');
        if( $cart ){
            // Create Order from Cart
            foreach ($cart as $cart) {
                $total_price = 0;

                // TO get Total Price
                foreach($cart as $c){
                    $total_price  = $total_price + $c->total_price;
                    $editCart = Cart::find($c->id);
                    $editCart->ordered = 'yes';
                    $editCart->save();
                }

                $order = new Order();
                $order->clients_id  = Auth::guard('client_api')->user()->id;
                $order->restaurant_id = $c->restaurant_id;
                $order->total_price = $total_price;
                $order->save();

                foreach($cart as $c){
                    $editCart = Cart::find($c->id);
                    $editCart->order_id = $order->id;
                    $editCart->save();
                }

            }
            return $this->helper->ResponseJson( 1 , 'لقد قمت بعمل طلب , سيصلك الطلب خلال بضع دقائق');
        }

    }
}
