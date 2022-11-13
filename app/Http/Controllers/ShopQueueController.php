<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Queue;
use App\Models\Customer;
use App\Models\BusinessOwner;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PrintNotification;
use Illuminate\Support\Facades\Notification;

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
            'status' => 'completed'
        ]);

        $customer = Customer::where('id', $queue->customer_id)->first();
        $user = User::where('id', $customer->user_id)->first();
        Notification::send($user, new PrintNotification('Print Completed', $queue->id));

        return response([
            'success' => 'Status updated'
        ], 200);
    }
}
