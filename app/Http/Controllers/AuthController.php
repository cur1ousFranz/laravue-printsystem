<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        if(Auth::attempt($credentials, $remember)){

            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
            ]);
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
            'username' => 'required|unique:users,username',
            'contact_email' => 'required|email|unique:customers,contact_email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'contact_email' => $validated['contact_email'],
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
        ]);

        $user->customers()->create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'contact_email' => $validated['contact_email']
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function registerOwner(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',

            'contact_number' => 'required',
            'contact_email' => 'required|email|unique:business_owners,contact_email',
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


        $permitPath = $validated['permit_image']->store('images', 's3');
        $valid_id_image = $validated['valid_id_image']->store('images', 's3');
        $face_image = $validated['face_image']->store('images', 's3');

        $validated['permit_image'] = Storage::disk('s3')->url($permitPath);
        $validated['valid_id_image'] = Storage::disk('s3')->url($valid_id_image);
        $validated['face_image'] = Storage::disk('s3')->url($face_image);

        $user = User::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'role' => 'businessowner',
        ]);

        $owner = $user->businessOwners()->create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'contact_number' => $validated['contact_number'],
            'contact_email' => $validated['contact_email'],
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

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
