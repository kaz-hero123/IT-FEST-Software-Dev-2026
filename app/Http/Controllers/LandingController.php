<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $popularContents = Content::with(['primaryPhoto', 'category', 'regency'])
            ->where('status', 'approved')
            ->orderByDesc('view_count')
            ->limit(6)
            ->get();

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
