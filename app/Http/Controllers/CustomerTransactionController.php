<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerTransactionController extends Controller
{

    public function index()
    {
        $customer = Customer::where('user_id', Auth::user()->id)->first();
        $queues = Queue::with('service.shop.application')
            ->where(['customer_id' => $customer->id, 'payment_status' => 'paid'])->get();

        return response()->json([
            'data' => $queues
        ]);
    }
}
