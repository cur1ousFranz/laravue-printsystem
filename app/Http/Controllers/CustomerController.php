<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index()
    {
        $customer = Customer::where('user_id' , Auth::user()->id)->first();

        return response()->json([
            'data' => $customer
        ]);
    }
}
