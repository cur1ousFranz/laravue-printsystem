<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerShopController extends Controller
{

    public function index()
    {
        if(Auth::user()->role !== 'customer'){
            return response([
                'error' => 'Unauthorized Action'
            ], 403);
        }

        $shops = Shop::with('application')->latest()->get();

        return response([
            'data' => $shops
        ]);
    }

    public function show(Shop $shop)
    {

        $currentShop = Shop::with('application', 'services')->where('id', $shop->id)->first();

        return response()->json([
            'data' => $currentShop
        ]);
    }

    public function upload(Request $request)
    {
        /** GCASH API */
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://g.payx.ph/payment_request',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'x-public-key' => 'pk_3bdc85a0dbe276bfa74375a1879935b4',
        //         'amount' => $request->total,
        //         'description' => 'Payment for printing',
        //         'merchantname' => 'Chungmi Loves Merchant'
        //     ),
        // ));

        // $response = curl_exec($curl);
        // curl_close($curl);

        // $data = json_decode($response, true);
        // $redirect = $data['data']['checkouturl'];

        // return response([
        //     'data' =>  $redirect
        // ]);

        $file = $request->file('file');
        $originalName =  $file->getClientOriginalName();
        $newName = time() . '_' . $originalName;

        $filePath = $request->file->storeAs('uploads', $newName, 'public');

        Queue::create([
            'service_id' => $request->service_id,
            'document' => $filePath,
            'size' => $request->size,
            'color' => $request->color,
            'pages' => $request->pages,
            'status' => 'pending',
        ]);

        // return response([
        //     'data' =>  $filePath
        // ]);

    }
}
