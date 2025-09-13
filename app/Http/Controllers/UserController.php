<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!isSuperAdmin() && !isAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index() {
        $this->users = User::all();
        return view('backend.users.index', $this->data);
    }

    public function create() {
        return view('backend.users.create');
    }

    public function store(Request $request) {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|string|max:20|unique:users',
            'role' => 'required|in:admin,client',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];

        $request->validate($rules);

        // Create user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ];

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Resize image
            $image = Image::read($file)->cover(300, 300)->save(public_path('assets/images/users/' . $filename));

            $userData['image'] = $filename;
        }

        // Create user
        User::create($userData);

        return redirect()->route('backend.users.index')
            ->with('success', 'User created successfully');
    }

    public function edit($id) {
        $this->user = User::findOrFail($id);
        if ($this->user->role == 'super_admin' && !isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('backend.users.edit', $this->data);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        if ($user->role == 'super_admin' && !isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

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
            ],
            'role' => 'required|in:super_admin,admin,client',
            'status' => 'required|in:active,inactive',
        ];

        $request->validate($rules);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.users.edit', $user->id)
            ->with('success', 'User information updated successfully');
    }

    public function changePassword(Request $request, $id) {
        $user = User::findOrFail($id);

        if ($user->role == 'super_admin' && !isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Validation rules
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'new_password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('backend.users.edit', $user->id)
            ->with('success', 'Password changed successfully');
    }

    public function updateProfilePicture(Request $request, $id) {
        $user = User::findOrFail($id);

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

            return redirect()->route('backend.users.edit', $user->id)
                ->with('success', 'Profile picture updated successfully');
        }

        return redirect()->route('backend.users.edit', $user->id)
            ->with('error', 'Failed to upload profile picture');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);

        if ($user->role == 'super_admin' && !isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Don't allow deletion of the current user
        if ($user->id === auth()->id()) {
            return redirect()->route('backend.users.index')
                ->with('error', 'You cannot delete your own account');
        }

        // Delete profile image if it exists and is not the default
        if ($user->image && $user->image != 'blank-profile.jpg') {
            $imagePath = public_path('assets/images/users/' . $user->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $user->delete();

        return redirect()->route('backend.users.index')
            ->with('success', 'User deleted successfully');
    }
}
