<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('pages.user.home.user-home-index');
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
