<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\User; // Ensure User model is imported

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = User::find(Auth::id()); // Ensure full user data is fetched

    if (!$user) {
        return redirect()->route('profile.edit')->with('error', 'User not authenticated.');
    }

    try {
        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public'); 

            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = $path;
        }

        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Ensure changes are detected before saving
        if ($user->exists && $user->isDirty()) {
            $user->save();
        }

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    } catch (\Exception $e) {
        Log::error('Profile update failed: ' . $e->getMessage());

        return redirect()->route('profile.edit')->with('error', 'Error updating profile: ' . $e->getMessage());
    }
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
