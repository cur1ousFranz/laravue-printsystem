<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Feedback;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required'
        ]);

        $customer = Customer::where('user_id', Auth::user()->id)->first();

        Feedback::create([
            'body' => $validated['message'],
            'shop_id' => $request->shop_id,
            'customer_id' => $customer->id,
        ]);

        $reviews = Feedback::where('shop_id', $request->shop_id)->get();

        return response()->json([
            'data' => $reviews
        ]);
    }

    public function show(Shop $shop)
    {

        $reviews = Feedback::where('shop_id', $shop->id)->get();

        return response()->json([
            'data' => $reviews
        ]);
    }
}
