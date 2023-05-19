<?php

namespace App\Http\Controllers;

use App\Http\Resources\API\V1\AuthUserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the user input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);

        // Save the user to the database
        $user->save();
        $token =  $user->createToken('aggregator')->accessToken;

        return response()->json(data: [
            'token' => $token,
            'user' => $user
        ]);
    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $user = Auth::user();
            $token =  $user->createToken('aggregator')->accessToken;

            $user = User::find($user['id']);
            $user->token = $token;
            $user->save();

            return response()->json(data: [
                'token' => $token,
                'user' => $user
            ]);
        }
        else{
            return response()->json([
                'error'=>'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
