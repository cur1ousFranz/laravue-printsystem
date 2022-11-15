<?php

namespace App\Http\Controllers;

use App\Models\BusinessOwner;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']); // destroying variable

        /**CHECK THE USER IF VERIFIED*/
        $user = User::where('username', $credentials['username'])->first();
        if($user->role === 'customer'){
            $customer = Customer::where('user_id', $user->id)->first();
            if($customer->verified == 1){
                if(Auth::attempt($credentials, $remember)){
                    $user = Auth::user();
                    $token = $user->createToken('main')->plainTextToken;
                    return response([
                        'user' => $user,
                        'token' => $token
                    ]);
                }
            }
            // Update code and send again to verify
            try {
                $code = rand(124101, 999999);
                $this->smsVerification($customer->contact_number, $code);
                $customer->update(['verify_code' => $code]);
            } catch (Exception $e) {
                return response([
                    'error' => $e->getMessage(),
                ]);
            }
            return response([
                'user_id' => $user->id,
            ]);
        }

        if($user->role === 'businessowner'){
            $owner = BusinessOwner::where('user_id', $user->id)->first();
            if($owner->verified == 1){
                if(Auth::attempt($credentials, $remember)){
                    $user = Auth::user();
                    $token = $user->createToken('main')->plainTextToken;
                    return response([
                        'user' => $user,
                        'token' => $token
                    ]);
                }
            }
            // Update code and send again to verify
            try {
                $code = rand(124101, 999999);
                $this->smsVerification($owner->contact_number, $code);
                $owner->update(['verify_code' => $code]);
            } catch (Exception $e) {
                return response([
                    'error' => $e->getMessage(),
                ]);
            }
            return response([
                'user_id' => $user->id,
            ]);
        }

        if($user->role === 'admin'){
            if(Auth::attempt($credentials, $remember)){
                $user = Auth::user();
                $token = $user->createToken('main')->plainTextToken;
                return response([
                    'user' => $user,
                    'token' => $token
                ]);
            }
        }

        return response([
            'error' => 'Invaid credentials',
        ], 422);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required|unique:customers,contact_number',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
        ]);
        $validated['contact_number'] = '+63' . $validated['contact_number'];

        try {

            $code = rand(124101, 999999);
            $this->smsVerification($validated['contact_number'], $code);

            $user = User::create([
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'role' => 'customer',
            ]);

            $user->customers()->create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
                'verified' => 0,
                'verify_code' => $code
            ]);

        } catch (Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ]);
        }

        return response([
            'user_id' => $user->id,
        ]);

    }

    public function registerOwner(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'contact_number' => 'required|unique:business_owners,contact_number',

            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',

            'shop_name' => 'required',
            'address' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'zipcode' => 'required',

            'permit_image' => 'required',
            'valid_id_image' => 'required',
            'face_image' => 'required',
        ]);
        $validated['contact_number'] = '+63' . $validated['contact_number'];

        try {

            $code = rand(100000, 999999);
            $this->smsVerification($validated['contact_number'], $code);

            $user = User::create([
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'role' => 'businessowner',
            ]);

            $permitPath = $validated['permit_image']->store('permits', 's3');
            $valid_id_image = $validated['valid_id_image']->store('permits', 's3');
            $face_image = $validated['face_image']->store('permits', 's3');

            $validated['permit_image'] = Storage::disk('s3')->url($permitPath);
            $validated['valid_id_image'] = Storage::disk('s3')->url($valid_id_image);
            $validated['face_image'] = Storage::disk('s3')->url($face_image);

            $owner = $user->businessOwners()->create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
                'verified' => 0,
                'verify_code' => $code,
            ]);

            $owner->applications()->create([
                'status' => 'pending',
                'shop_name' => $validated['shop_name'],
                'address' => $validated['address'],
                'barangay' => $validated['barangay'],
                'city' => $validated['city'],
                'zipcode' => $validated['zipcode'],

                'permit_image' => $validated['permit_image'],
                'valid_id_image' => $validated['valid_id_image'],
                'face_image' => $validated['face_image'],
            ]);

        } catch (Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ]);
        }

        return response([
            'user_id' => $user->id,
        ]);

    }

    public function verify(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if($user->role === 'customer'){
            $customer = Customer::where('user_id', $user->id)->first();

            if($customer->verify_code === $request->code){
                $customer->update([
                    'verified' => 1
                ]);
                $token = $user->createToken('main')->plainTextToken;
                return response([
                    'user' => $user,
                    'token' => $token,
                ]);
            }
        }

        if($user->role === 'businessowner'){
            $owner = BusinessOwner::where('user_id', $user->id)->first();

            if($owner->verify_code === $request->code){
                $owner->update([
                    'verified' => 1
                ]);
                $token = $user->createToken('main')->plainTextToken;
                return response([
                    'user' => $user,
                    'token' => $token,
                ]);
            }
        }

        return response([
            'message' => 'Invalid code',
        ], 404);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }

    public function smsVerification($mobile, $code)
    {
        $receiverNumber = $mobile;
        $message = "Your verification code is: " . $code;

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($receiverNumber, [
            'from' => $twilio_number,
            'body' => $message]);
    }
}
