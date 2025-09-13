<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller {
    public function profile() {
        $this->user = User::find(auth()->user()->id);
        return view('backend.users.profile', $this->data);
    }

    public function updateProfile(Request $request) {
        $user = User::find(auth()->user()->id);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ]
        ];

        $request->validate($rules);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        return redirect()->route('backend.profile')
            ->with('success', 'Profile updated successfully');
    }

    public function changeOwnPassword(Request $request) {
        $user = User::find(auth()->user()->id);

        // Validation rules
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('backend.profile')
            ->with('success', 'Password changed successfully');
    }

    public function updateOwnProfilePicture(Request $request) {
        $user = User::find(auth()->user()->id);

        // Validation rules
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png',
        ], [
            'profile_picture.required' => 'Please select a profile picture.',
            'profile_picture.image' => 'The file must be an image.',
            'profile_picture.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'profile_picture.max' => 'The image may not be greater than 2MB.',
        ]);

        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Delete old image if it exists and is not the default
            if ($user->image && $user->image != 'blank-profile.jpg') {
                $oldImagePath = public_path('assets/images/users/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Generate unique filename
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();

            // Resize image
            $image = Image::read($file)->cover(300, 300)->save(public_path('assets/images/users/' . $filename));

            // Update user record
            $user->update(['image' => $filename]);

            return redirect()->route('backend.profile')
                ->with('success', 'Profile picture updated successfully');
        }

        return redirect()->route('backend.profile')
            ->with('error', 'Failed to upload profile picture');
    }
}
