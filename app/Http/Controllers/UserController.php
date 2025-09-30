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
            'role' => 'required|in:admin,student',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];

        $request->validate($rules);

        // Create user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
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
            'role' => 'required|in:super_admin,admin,student',
            'status' => 'required|in:active,inactive',
        ];

        $request->validate($rules);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
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

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('backend.users.edit', $user->id)
            ->with('success', 'Password changed successfully');
    }

    public function updateProfilePicture(Request $request, $id) {
        $user = User::findOrFail($id);

        if ($user->role == 'super_admin' && !isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Resize image
            $image = Image::read($file)->cover(300, 300)->save(public_path('assets/images/users/' . $filename));

            // Delete old image if exists
            if ($user->image && file_exists(public_path('assets/images/users/' . $user->image))) {
                unlink(public_path('assets/images/users/' . $user->image));
            }

            $user->update(['image' => $filename]);
        }

        return redirect()->route('backend.users.edit', $user->id)
            ->with('success', 'Profile picture updated successfully');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);

        if ($user->role == 'super_admin' && !isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id == auth()->user()->id) {
            return redirect()->route('backend.users.index')
                ->with('error', 'You cannot delete your own account');
        }

        // Delete profile picture if exists
        if ($user->image && file_exists(public_path('assets/images/users/' . $user->image))) {
            unlink(public_path('assets/images/users/' . $user->image));
        }

        $user->delete();

        return redirect()->route('backend.users.index')
            ->with('success', 'User deleted successfully');
    }
}
