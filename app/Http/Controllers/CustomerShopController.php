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

        $currentShop = Shop::with('application', 'services')->where('id', $shop->id)->first();

        return response()->json([
            'data' => $currentShop
        ]);
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $originalName =  $file->getClientOriginalName();
        $newName = time() . '_' . $originalName;

        $filePath = $request->file->storeAs('uploads', $newName);
        return response([
            'data' =>  $filePath
        ]);
    }
}
