<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerShopController extends Controller
{

    public function index()
    {
        if(Auth::user()->role !== 'customer'){
            return response([
                'error' => 'Unauthorized Action'
            ], 403);
        }

        $shops = Shop::with('application')->latest()->get();

        return response([
            'data' => $shops
        ]);
    }

    public function show(Shop $shop)
    {
        // return response([
        //     'data' => $shop->with('application', 'services')->first()
        // ]);
    }
}
