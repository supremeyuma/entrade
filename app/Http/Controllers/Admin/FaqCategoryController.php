<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::latest()->get();
        return view('admin.faq_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        FaqCategory::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'icon_type' => $request->icon_type ?? 'emoji',
            'icon_value' => $request->icon_value,
        ]);
        
        return redirect()->route('admin.faq-categories.index')->with('success', 'Category created.');
    }

    public function edit(FaqCategory $faqCategory)
    {
        return view('admin.faq_categories.edit', compact('faqCategory'));
    }

    public function update(Request $request, FaqCategory $faqCategory)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $faqCategory->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'icon_type' => $request->icon_type ?? 'emoji',
            'icon_value' => $request->icon_value,
        ]);
        
        return redirect()->route('admin.faq-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();
        return redirect()->route('admin.faq-categories.index')->with('success', 'Category deleted.');
    }
}
