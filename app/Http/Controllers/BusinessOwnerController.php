<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use Illuminate\Support\Facades\Auth;

class BusinessOwnerController extends Controller
{

    public function index()
    {
        $owner = BusinessOwner::where('user_id', Auth::user()->id)->first();
        $data = $owner->applications()->get();
        return response([
            'data' => $data
        ]);
    }

    public function show()
    {
        $owner = BusinessOwner::where('user_id', Auth::user()->id)->first();
        $shops = $owner->shops()->with('application', 'services.queues')->latest()->get();

        return response([
            'data' => $shops
        ]);
    }
}
