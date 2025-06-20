<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categories = FaqCategory::all();
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'faq_category_id' => 'required|exists:faq_categories,id',
        ]);

        Faq::create($request->all());
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::all();
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'faq_category_id' => 'required|exists:faq_categories,id',
        ]);

        $faq->update($request->all());
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }
}
