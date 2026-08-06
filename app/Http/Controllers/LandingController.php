<?php

namespace App\Http\Controllers;

use App\Models\Content;

class LandingController extends Controller
{
    public function index()
    {
        $popularContents = \Illuminate\Support\Facades\Cache::remember('popular_contents', 300, function () {
            return Content::with(['primaryPhoto', 'category', 'regency'])
                ->where('status', 'approved')
                ->orderByDesc('view_count')
                ->limit(6)
                ->get();
        });

        return view('pages.user.home.user-home-index', compact('popularContents'));
    }

    public function about()
    {
        return view('pages.user.about.user-about-index');
    }

    public function question()
    {
        return view('pages.user.question.user-question-index');
    }
}
