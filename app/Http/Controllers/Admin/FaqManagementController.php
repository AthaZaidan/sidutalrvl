<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqManagementController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->where('deleted', 0)->orderByDesc('id')->paginate(15);
        $categories = FaqCategory::where('deleted', 0)->orderBy('name')->get();

        return view('admin.management.faqs.index', [
            'activeMenu' => 'Management',
            'faqs' => $faqs,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'id_category_faq' => ['required', 'integer'],
            'category_user' => ['required', 'in:0,1,2'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        Faq::create([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'id_category_faq' => $data['id_category_faq'],
            'category_user' => $data['category_user'],
            'is_published' => $request->boolean('is_published', true) ? 1 : 0,
            'deleted' => 0,
        ]);

        return back()->with('flash_success', 'FAQ ditambahkan.');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:256']]);
        FaqCategory::create(['name' => $data['name'], 'deleted' => 0]);
        return back()->with('flash_success', 'Kategori FAQ ditambahkan.');
    }

    public function destroy(int $id)
    {
        Faq::where('id', $id)->update(['deleted' => 1]);
        return back()->with('flash_success', 'FAQ dihapus.');
    }
}
