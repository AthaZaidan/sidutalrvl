<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $categories = FaqCategory::where('deleted', 0)->orderBy('name')->get();

        $query = Faq::with('category')
            ->where('deleted', 0)
            ->where('is_published', 1);

        if ($request->filled('category_user') && $request->query('category_user') !== 'all') {
            $query->where('category_user', (int) $request->query('category_user'));
        }
        if ($request->filled('id_category_faq') && $request->query('id_category_faq') !== 'all') {
            $query->where('id_category_faq', (int) $request->query('id_category_faq'));
        }
        if ($request->filled('q')) {
            $kw = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($kw) {
                $sub->where('question', 'like', "%{$kw}%")->orWhere('answer', 'like', "%{$kw}%");
            });
        }

        $faqs = $query->orderBy('id')->get();

        return view('public.faq', compact('categories', 'faqs'));
    }
}
