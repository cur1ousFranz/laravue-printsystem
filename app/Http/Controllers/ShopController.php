<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{

    public function show(Shop $shop)
    {

        // $owner = BusinessOwner::where('user_id', Auth::user()->id)->first();

        // if($shop->business_owner_id !== $owner->id){
        //     return response([
        //         'error' => 'Unauthorized Action'
        //     ], 403);
        // }

        $currentShop = Shop::with('application.businessOwner', 'services', 'services.queues', 'services.queues.service')
        ->where('id', $shop->id)->first();

        return response()->json([
            'data' => $currentShop
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

    public function updateImage(Request $request)
    {
        $shop = Shop::where('id', $request->shop_id)->first();

        if($request->has('image')){
            $imgPath = $request->image->store('banner-img', 's3');
            $shop->update([
                'image' => Storage::disk('s3')->url($imgPath)
            ]);
        }

        return response()->json([
            'data' => $shop
        ]);
    }

    public function storeDocuments(Shop $shop)
    {
        $service = Service::create([
            'shop_id' => $shop->id,
            'service_name' => 'documents'
        ]);

        $service->servicePrice()->create();

        $currentShop = Shop::with('application', 'services')->where('id', $shop->id)->first();

        return response()->json([
            'data' => $currentShop
        ]);
    }

    public function deleteServiceDocuments(Shop $shop)
    {

        $shop->services()->delete();
        $shop->update([
            'status' => 'close'
        ]);

        $currentShop = Shop::with('application', 'services')->where('id', $shop->id)->first();
        return response()->json([
            'data' => $currentShop
        ]);
    }
}
