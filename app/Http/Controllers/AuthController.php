<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'username' => 'required|unique:users,username',
            'contact_email' => 'required|email|unique:customers,contact_email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
        ]);

        $user->customers()->create([
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
        ]);

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
