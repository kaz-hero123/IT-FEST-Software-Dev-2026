<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index()
    {
        $regencies = Regency::withCount('approvedContents')->get();
        $categories = Category::all();

        return view('pages.user.explore.user-explore-index', compact('regencies', 'categories'));
    }

    public function show(Request $request, Regency $regency)
    {
        $contents = Content::with([
                'photos' => fn($q) => $q->where('is_primary', true),
                'category',
            ])
            ->where('status', 'approved')
            ->where('regency_id', $regency->id)
            ->when($request->category, function ($q) use ($request) {
                $q->whereHas('category', fn($q) =>
                    $q->where('slug', $request->category)
                );
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where(function($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%')
                          ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('pages.user.explore.user-explore-show', compact('regency', 'contents', 'categories'));
    }
}
