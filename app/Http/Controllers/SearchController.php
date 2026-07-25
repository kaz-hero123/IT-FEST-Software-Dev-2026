<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $category = $request->input('category');

        $contents = collect();

        if (strlen(trim($query)) >= 2) {
            $contents = Content::with(['primaryPhoto', 'category', 'regency'])
                ->where('status', 'approved')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('address', 'like', "%{$query}%");
                })
                ->when($category, function ($q) use ($category) {
                    $q->whereHas('category', fn($c) => $c->where('slug', $category));
                })
                ->latest()
                ->paginate(12)
                ->appends(['q' => $query, 'category' => $category]);
        }

        $categories = Category::all();

        return view('pages.user.search.user-search-index', compact('contents', 'query', 'categories'));
    }
}
