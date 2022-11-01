<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function update(Service $service, Request $request)
    {
        $service->update([
            'service_name' => $request->service_name,
            'price' => json_encode($request->price),
        ]);

        return response([
            'data' => $service
        ]);
    }
}
