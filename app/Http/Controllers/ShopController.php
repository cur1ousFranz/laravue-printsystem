<?php

namespace App\Http\Controllers;

use App\Models\BusinessOwner;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{


    public function show(Shop $shop)
    {

        $owner = BusinessOwner::where('user_id', Auth::user()->id)->first();

        if($shop->business_owner_id !== $owner->id){
            return response([
                'error' => 'Unauthorized Action'
            ], 403);
        }

        return response([
            'data' => [
                $shop->with('application')->first(),
                $shop->services()->first()
            ]
        ]);
    }

    public function update(Shop $shop, Request $request)
    {
        $shop->update([
            'status' => $request->status
        ]);

        return response([
            'success' => 'Update Success'
        ], 204);
    }
}
