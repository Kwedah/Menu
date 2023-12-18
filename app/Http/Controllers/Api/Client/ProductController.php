<?php

namespace App\Http\Controllers\Api\Client;

use App\Helper\helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

    class ProductController extends Controller
    {
        public $helper;

        public function getProduct()
    {
        $product = Product::all();

    return response()->json([
        "status" => 1,
        "message" => "The Product",
    ]);
    }

// <------------------------------------------------------------------------------------->
        public function __construct(){
            $this->helper = new helper();
        }

        public function index(){
            $products = Product::get();
            return $this->helper->ResponseJson( 1 , 'products' , [ 'data' => $products ] );
        }

        public function product($id)
        {
            $product = Product::find($id);
            // $category = $product->category;
            // $restaurant = $product->restaurant;
            return $this->helper->ResponseJson( 1 , 'product' , [ 'product data' => $product ,
                // 'category info'  => $category , 'restaurant info' => $restaurant
            ] );
        }

        public function productsByCategory($id){
            $products = Product::where('category_id' , $id)->get();
            return $this->helper->ResponseJson(1 , 'Products Details' , $products);
        }

    }
