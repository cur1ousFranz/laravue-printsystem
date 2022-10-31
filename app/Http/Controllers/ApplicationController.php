<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{


    public function index()
    {
        if(Auth::user()->role !== 'admin'){
            return response([
                'error' => 'Unauthorized Action'
            ], 403);
        }

        return response([
            'data' => Application::with('businessOwner')->latest()->get()
        ]);
    }

    public function show(Application $application)
    {

        $data = Application::with('businessOwner')->where('id', $application->id)->first();

        return response([
            'data' => $data,
        ]);
    }

    public function update(Application $application)
    {

        if(Auth::user()->role !== 'admin'){
            return response([
                'error' => 'Unauthorized Action'
            ], 403);
        }

        $application->update([
            'status' => 'approved'
        ]);

        Shop::create([
            'business_owner_id' => $application->businessOwner->id,
            'application_id' => $application->id,
            'status' => 'close'
        ]);

        return response([
            'success' => 'Application updated'
        ], 200);
    }
}
