<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Queue;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerShopController extends Controller
{

    public function index()
    {
        // if(Auth::user()->role !== 'customer'){
        //     return response([
        //         'error' => 'Unauthorized Action'
        //     ], 403);
        // }

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
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://g.payx.ph/payment_request',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'x-public-key' => 'pk_e3eb47a615e259898cb61c2be3dc41e3',
                'amount' => $request->total,
                'description' => 'Payment for printing',
                'merchantname' => 'Near Printer',
                'webhooksuccessurl' => 'http://nearprinter-env-1.eba-zympgiwr.us-east-1.elasticbeanstalk.com/api/success',
                'redirectsuccessurl' => 'http://near-printer-vuejs.s3-website-ap-southeast-1.amazonaws.com/checkout/success',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        $redirect = $data['data']['checkouturl'];

        $filePath = $request->file('file')->store('documents', 's3');
        $customer = Customer::where('user_id', Auth::user()->id)->first();

        $queue = Queue::create([
            'service_id' => $request->service_id,
            'customer_id' => $customer->id,
            'control_number' => '',
            'document' => Storage::disk('s3')->url($filePath),
            'size' => $request->size,
            'color' => $request->color,
            'pages' => $request->pages,
            'amount' => $request->total,
            'admin_commission' => $request->admin_commission,
            'pickup' => $request->pickup,
            'status' => 'pending',
            'request_id' => $data['data']['request_id'],
            'payment_status' => 'pending',
            'paid' => 'no',
        ]);

        $queue->update([
            'control_number' => '#'.str_pad($queue->id + 1, 8, "0", STR_PAD_LEFT)
        ]);

        return response([
            'data' =>  $redirect
        ]);

    }

    public function checkoutSuccess(Request $request)
    {

        // Log::info(print_r($request->all(), true));
        $queues = Queue::where('payment_status', 'pending')->get();

        foreach ($queues as $queue) {
            if($request['request_id'] === $queue->request_id){
                $queue->update(['payment_status' => 'paid']);
            }
        }

    }
}
