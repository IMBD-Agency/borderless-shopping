<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'FAQs', 'url' => route('backend.faqs.index')],
        ];

        $faqs = Faq::with('category')->orderBy('order')->orderBy('id')->get();
        return view('backend.faqs.index', compact('breadcrumb', 'faqs'));
    }

    public function create() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'FAQs', 'url' => route('backend.faqs.index')],
            ['title' => 'Create', 'url' => route('backend.faqs.create')],
        ];

        $categories = Category::active()->ordered()->get();
        return view('backend.faqs.create', compact('breadcrumb', 'categories'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Faq::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('backend.faqs.index')->with('success', 'FAQ added successfully.');
    }

    public function edit($id) {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')],
            ['title' => 'FAQs', 'url' => route('backend.faqs.index')],
            ['title' => 'Edit', 'url' => route('backend.faqs.edit', $id)],
        ];

        $faq = Faq::findOrFail($id);
        $categories = Category::active()->ordered()->get();
        return view('backend.faqs.edit', compact('breadcrumb', 'faq', 'categories'));
    }

    public function update(Request $request, $id) {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $faq->update([
            'category_id' => $validated['category_id'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'order' => $validated['order'] ?? 0,
            'is_active' => isset($validated['is_active']) ? (bool) $validated['is_active'] : true,
        ]);

        return redirect()->route('backend.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy($id) {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return back()->with('success', 'FAQ deleted successfully.');
    }
}
