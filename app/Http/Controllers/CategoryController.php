<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'FAQ Categories', 'url' => route('backend.faq.categories.index')],
        ];

        $categories = Category::ordered()->get();
        
        // Check if this is an AJAX request for category list
        if (request()->ajax() || request()->get('ajax-list')) {
            return response()->json([
                'categories' => Category::active()->ordered()->get()->map(function($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name
                    ];
                })
            ]);
        }
        
        return view('backend.categories.index', compact('breadcrumb', 'categories'));
    }

    public function create() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'FAQ Categories', 'url' => route('backend.faq.categories.index')],
            ['title' => 'Create', 'url' => route('backend.faq.categories.create')],
        ];

        return view('backend.categories.create', compact('breadcrumb'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Generate slug from name
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        
        // Ensure unique slug
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('backend.faq.categories.index')->with('success', 'Category added successfully.');
    }

    public function edit($id) {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'FAQ Categories', 'url' => route('backend.faq.categories.index')],
            ['title' => 'Edit', 'url' => route('backend.faq.categories.edit', $id)],
        ];

        $category = Category::findOrFail($id);
        return view('backend.categories.edit', compact('breadcrumb', 'category'));
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Generate slug from name if it changed
        $slug = $category->slug;
        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            
            // Ensure unique slug
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => isset($validated['is_active']) ? (bool) $validated['is_active'] : true,
        ]);

        return redirect()->route('backend.faq.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        
        // Check if category has FAQs
        if ($category->faqs()->count() > 0) {
            return back()->with('error', 'Cannot delete category that has FAQs. Please remove or reassign FAQs first.');
        }

        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }
}
