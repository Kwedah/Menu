<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Delivary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DelivaryController extends Controller
{
    public function delivary(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'id_number' => 'required',
            'image' => 'required',
            'rate' => 'required'
        ]);

        $delivary = new Delivary;
        $delivary->name = $request->name;
        $delivary->phone = $request->phone;
        $delivary->id_number = $request->id_number;
        $delivary->image = $request->image;
        $delivary->rate = $request->rate;

        $delivary->save();

        return response()->json([
            "status" => 1,
            "message" => "Welcome to your new job!"
        ]);

    }

}
