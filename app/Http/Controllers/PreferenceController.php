<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function store(Request $request, User $user)
    {
        // Validate the user input
        $request->validate([
            'preference' => 'required|json',
        ]);

        // Retrieve the preference from the request
        $preference = $request->input('preference');

        // Retrieve the user's preference
        $userPreference = $user->preference;

        if (!$userPreference) {
            // If the user doesn't have a preference, create a new one
            $userPreference = new Preference();
            $userPreference->user_id = $user->id;
            $userPreference->preference = $preference;
            $userPreference->save();
        } else {
            // If the user has a preference, update the existing one
            $userPreference->preference = $preference;
            $userPreference->save();
        }

        // Return a success response
        return response()->json(['message' => 'Preference saved successfully']);
    }
    public function show(Request $request, User $user)
    {
        // Retrieve the user's related search preference
        $preference = $user->preference;

        // Check if user has a preference saved
        if ($preference) {
            // Return the preferences
            return $preference;
        }

        // If no preferences found, return an error message
        return response()->json(['error' => 'Preferences not found'], 404);
    }
}
