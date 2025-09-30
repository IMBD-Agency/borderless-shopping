<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'Reviews', 'url' => route('backend.reviews.index')],
            ['title' => 'Create', 'url' => route('backend.reviews.create')],
        ];

        return view('backend.reviews.create', compact('breadcrumb'));
    }

    public function index() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'Reviews', 'url' => route('backend.reviews.index')],
        ];

        $reviews = Review::orderByDesc('id')->get();
        return view('backend.reviews.index', compact('breadcrumb', 'reviews'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $imageFileName = 'blank-profile.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uniqueName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/images/reviews');
            if (!is_dir($destination)) {
                @mkdir($destination, 0775, true);
            }
            $file->move($destination, $uniqueName);
            $imageFileName = $uniqueName;
        }

        Review::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'location' => $validated['location'],
            'rating' => (string) $validated['rating'],
            'comment' => $validated['comment'],
            'image' => $imageFileName,
        ]);

        return back()->with('success', 'Review added successfully.');
    }

    public function destroy($id) {
        $review = Review::findOrFail($id);

        // Remove image file if it exists and is not the placeholder
        if (!empty($review->image) && $review->image !== 'blank-profile.jpg') {
            $path = public_path('assets/images/reviews/' . $review->image);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}
