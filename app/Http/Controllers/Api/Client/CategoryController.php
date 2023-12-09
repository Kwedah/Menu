<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getCategory()
    {
        $category = Category::all();

        return response()->json([
            "status" => 1,
            "message" => "All Category",
            "data" => $category
        ]);
    }
}
