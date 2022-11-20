<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Shop;
use App\Models\Service;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function show(Shop $shop)
    {
        $shops = Shop::where('id', $shop->id)->first();
        $service = Service::where('shop_id', $shops->id)->first();
        $queues = Queue::where(['service_id' => $service->id, 'payment_status' => 'paid'])->latest()->paginate(5);

        return response()->json([
            'data' => $queues
        ]);
    }

    public function update(Shop $shop)
    {
        $shops = Shop::where('id', $shop->id)->first();
        $service = Service::where('shop_id', $shops->id)->first();
        $queues = Queue::where(['service_id' => $service->id, 'payment_status' => 'paid'])->get();

        foreach($queues as $queue){
            $queue->update(['paid' => 'yes']);
        }

        $currentShop = Shop::with('application.businessOwner', 'services', 'services.queues', 'services.queues.service')
        ->where('id', $shop->id)->first();

        return response()->json([
            'data' => $currentShop
        ]);

    }

}
