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

        return view('explore.index', compact('regencies'));
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
                ->latest()
                ->paginate(12);

    $categories = Category::all();

    return view('explore.show', compact('regency', 'contents', 'categories'));
    }
}
