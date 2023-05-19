<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        if($user)
            // Validate the user input
            $request->validate([
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6|confirmed',
                'password_confirmation' => 'nullable',
            ]);

        // Update the user instance with the new name and email or replace with old ones
        $user->name = $request['name']??$user->name;
        $user->email = $request['email']??$user->email;

        // Check if the old password and new password are provided
        if ($request->filled('password') && $request->filled('old_password')) {
            // Verify if the old password matches the user's current password
            if (Hash::check($request['old_password'], $user->password)) {
                // Update the password with the new confirmed password
                $user->password = Hash::make($request['password']);
            } else {
                // Return an error if the old password doesn't match
                return response()->json(['error' => 'Old password is incorrect'], 400);
            }
        }

        // Save the updated user to the database
        $user->save();

        // Return a JSON response
        return response()->json(['message' => 'User updated successfully']);
    }
}
