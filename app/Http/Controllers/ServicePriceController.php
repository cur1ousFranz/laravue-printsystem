<?php

namespace App\Http\Controllers;

use App\Models\ServicePrice;
use App\Models\Shop;
use Illuminate\Http\Request;

class ServicePriceController extends Controller
{

    public function setDocumentsPrice(Shop $shop, Request $request)
    {
        foreach ($request->services as $service) {

            if($service['service_name'] === 'documents'){

                ServicePrice::where('service_id', $service['id'])->update([
                    'price' => json_encode($service['service_price']['price'])
                ]);
            }
        }

        $currentShop = Shop::with('application', 'services')->where('id', $shop->id)->first();

        return response()->json([
            'data' => $currentShop
        ]);
    }
}
