<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerTransactionResource;
use App\Models\Queue;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class CustomerTransactionController extends Controller
{

    public function index()
    {
        $customer = Customer::where('user_id', Auth::user()->id)->first();

        // return CustomerTransactionResource::collection($customer->queues);

        return response()->json([
            'data' => $customer->queues
        ]);
    }
}
