<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all users from the database
        $users = User::all();

        // Return a JSON response with the users
        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        // Return a JSON response
        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Check if the user is updating their own profile
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'You can only update your own account.'], 403);
        }

        // Validate the user input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update the user details
        $user->name = $request['name'];
        $user->email = $request['email'];

        // Save the updated user to the database
        $user->save();

        // Return a JSON response with a success message
        return response()->json(['message' => 'User profile updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Check if the authenticated user is trying to delete themselves
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'You cannot delete your own account.'], 403);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

}
