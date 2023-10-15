<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index(){
        return view('FrontEnd.details');
    }
    public function store(Request $request)
    {
        $formData = $request->validate([
            "name" => "required|string|min:2",
            "phone" => "required|string|min:10|max:13",
            "address" => "required|string",
            "city" => "required|string",
        ]);
        $formData["product_id"] = 1;
        $formData["color"] = "red";
        $formData["size"] = "xl";
        $formData["quantity"] = 4;
        Order::create($formData);
        // Optionally, you can return a response, redirect, or perform other actions
        return redirect('/details')->with('success', 'Order created successfully');
    }
    
}