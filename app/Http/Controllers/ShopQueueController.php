<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Queue;
use App\Models\BusinessOwner;
use Illuminate\Support\Facades\Auth;

class ShopQueueController extends Controller
{

    public function index()
    {

        $owner = BusinessOwner::where('user_id', Auth::user()->id)->first();
        $shops = Shop::with('application', 'services')
            ->where('business_owner_id', $owner->id)
            ->get();

        return response()->json([
            'data' => $shops
        ]);
    }

    public function update(Queue $queue)
    {

        $queue->update([
            'status' => 'done'
        ]);

        return response([
            'success' => 'Status updated'
        ], 200);
    }
}
