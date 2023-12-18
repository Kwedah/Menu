<?php

namespace App\Http\Controllers\Api\Client;

use App\Helper\helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public $helper;
    public function __construct()
    {
        $this->helper = new helper();
    }

    public function favorites(){
        $favorite = Favorite::where('clients_id' , Auth::guard('client_api')->user()->id)->get();
        foreach($favorite as $f){
            $f['product_name'] = Product::find($f->product_id)->name;
            $f['product_price'] = Product::find($f->product_id)->price;
            $f['product_image'] = Product::find($f->product_id)->image;
        }
        return $this->helper->ResponseJson( 1 , 'المفضلة' ,$favorite );
    }

    public function addToFavorite($id){
        $product = Product::find($id);
        if($product){
            $favoriteExits = Favorite::where('clients_id' ,Auth::guard('client_api')->user()->id )->where('product_id' , $id)->first();
            if($favoriteExits){
                return $this->helper->ResponseJson( 0 , 'This Product existed in your favorite' , $favoriteExits);
            }else{
                $favorite = new Favorite();
                $favorite->clients_id = Auth::guard('client_api')->user()->id;
                $favorite->product_id = $id;
                $favorite->save();
                $favoriteExits = Favorite::where('clients_id' ,Auth::guard('client_api')->user()->id )->where('product_id' , $id)->first();
                $myFavorite = Favorite::where('clients_id' , Auth::guard('client_api')->user()->id )->get();
                foreach($myFavorite as $f){
                    $f['product_name'] = Product::find($f->product_id)->name;
                    $f['product_price'] = Product::find($f->product_id)->price;
                    $f['product_image'] = Product::find($f->product_id)->image;
                }
                return $this->helper->ResponseJson( 1 , 'تم اضافة منتج الى المفضلة' , $myFavorite);
            }
        }else{
            return $this->helper->ResponseJson( 0 , '  المنتج غير متاح ');
        }
    }

    public function removeFromFavorite($id){
        $favorite = Favorite::where('clients_id' , Auth::guard('client_api')->user()->id )->where('product_id' , $id)->first();
        if($favorite){
            $favorite->delete();
            $myFavorite = Favorite::where('clients_id' , Auth::guard('client_api')->user()->id )->get();
            foreach($myFavorite as $f){
                $f['product_name'] = Product::find($f->product_id)->name;
                $f['product_price'] = Product::find($f->product_id)->price;
                $f['product_image'] = Product::find($f->product_id)->image;
            }
            return $this->helper->ResponseJson( 1 , 'تم ازالة المنتج من المفضلة ' , $myFavorite);
        }else{
            return $this->helper->ResponseJson( 0 , 'المفضلة ليس بها هذا المنتج');
        }
    }

    public function clearFavorite(){
        $fav = Favorite::where('clients_id' , Auth::guard('client_api')->user()->id)->get();
        foreach($fav as $f){
            Favorite::destroy($f->id);
        }
        return $this->helper->ResponseJson(1 , 'لقد تم مسح المفضلة');
    }

}
