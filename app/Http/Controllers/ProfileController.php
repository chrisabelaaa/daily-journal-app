<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return back()->with('status', 'Profile updated successfully!');
    }

    public function photo(Request $request)
    {
        if ($request->isMethod('delete')) {
            // Handle photo deletion
            $user = $request->user();
            if ($user->photo) {
                Storage::disk('public')->delete('profile/' . $user->photo);
                $user->photo = null;
                $user->save();
                return back()->with('status', 'Profile photo removed successfully!');
            }
            return back()->with('status', 'No photo to remove.');
        }

        // Handle GET request (show form)
        if ($request->isMethod('get')) {
            return view('profile_photo');
        }

        // Handle photo upload (POST request)
        if (!$request->hasFile('photo')) {
            return back()->withErrors(['photo' => 'Please select a photo to upload.']);
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'photo.required' => 'Please select a photo to upload.',
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'Only JPEG, PNG, JPG, GIF, and WebP files are allowed.',
            'photo.max' => 'The photo must not be larger than 2MB.',
        ]);

        $user = $request->user();
        
        // Delete old photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete('profile/' . $user->photo);
        }

        $file = $request->file('photo');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Store the file
        $file->storeAs('profile', $filename, 'public');
        
        // Update user record
        $user->photo = $filename;
        $user->save();

        return back()->with('status', 'Profile photo updated successfully!');
    }
}
