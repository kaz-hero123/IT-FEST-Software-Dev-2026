<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;

class DashboardController extends Controller
{
    /**
     * Admin dashboard: stats global + recent pending contents.
     * URL: GET /admin/dashboard
     */
    public function index()
    {
        $stats = [
            'total'    => Content::count(),
            'pending'  => Content::where('status', 'pending')->count(),
            'approved' => Content::where('status', 'approved')->count(),
            'rejected' => Content::where('status', 'rejected')->count(),
        ];

        $recentPending = Content::with(['user', 'category', 'regency'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPending'));
    }
}
