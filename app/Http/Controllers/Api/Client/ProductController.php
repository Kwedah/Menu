<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function getProduct()
    {
        $product = Product::all();

    return response()->json([
        "status" => 1,
        "message" => "The Product",
    ]);
    }
}
