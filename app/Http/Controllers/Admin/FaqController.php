<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::with('category');

        if ($request->filled('category')) {
            $query->where('faq_category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('question', 'like', '%' . $request->search . '%');
        }

        $faqs = Faq::with('category')->orderBy('position')->orderByDesc('created_at')->get();
        $categories = FaqCategory::all();

        return view('admin.faqs.index', compact('faqs', 'categories'));
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
            'position' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        Faq::create($request->only(['question', 'answer', 'faq_category_id', 'position']) + [
            'is_featured' => $request->has('is_featured')
        ]);
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
            'position' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $faq->update($request->only(['question', 'answer', 'faq_category_id', 'position']) + [
            'is_featured' => $request->has('is_featured')
        ]);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }


    // ✅ Export
    public function exportJson()
    {
        $data = Faq::with('category')->get();
        return response()->json($data);
    }

    public function exportCsv()
    {
        $faqs = Faq::with('category')->get();
        $csv = "Category,Question,Answer,Position,Is Featured\n";

        foreach ($faqs as $faq) {
            $csv .= '"' . $faq->category->title . '","' . str_replace('"', '""', $faq->question) . '","' . str_replace('"', '""', $faq->answer) . '",' . $faq->position . ',' . ($faq->is_featured ? 'yes' : 'no') . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="faqs.csv"',
        ]);
    }

    // ✅ Import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,json',
        ]);

        $file = $request->file('file');

        if ($file->getClientOriginalExtension() === 'json') {
            $data = json_decode(file_get_contents($file), true);
        } else {
            $rows = array_map('str_getcsv', file($file));
            $headers = array_map('strtolower', array_map('trim', array_shift($rows)));
            $data = [];

            foreach ($rows as $row) {
                $entry = array_combine($headers, $row);
                if ($entry) {
                    $category = FaqCategory::firstOrCreate(['title' => $entry['category'] ?? 'Uncategorized'], [
                        'slug' => Str::slug($entry['category'] ?? 'uncategorized'),
                    ]);

                    $data[] = [
                        'faq_category_id' => $category->id,
                        'question' => $entry['question'] ?? '',
                        'answer' => $entry['answer'] ?? '',
                        'position' => $entry['position'] ?? 0,
                        'is_featured' => strtolower($entry['is featured'] ?? '') === 'yes',
                    ];
                }
            }
        }

        foreach ($data as $item) {
            Faq::create($item);
        }

        return redirect()->route('admin.faqs.index')->with('success', 'FAQs imported successfully.');
    }
}
