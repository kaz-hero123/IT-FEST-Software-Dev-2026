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
        // Single query: GROUP BY status instead of 4 separate COUNT queries (F-07b)
        $statusCounts = Content::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total'    => $statusCounts->sum(),
            'pending'  => $statusCounts->get('pending', 0),
            'approved' => $statusCounts->get('approved', 0),
            'rejected' => $statusCounts->get('rejected', 0),
        ];

        $recentPending = Content::with(['user', 'category', 'regency'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.admin.admin-home-index', compact('stats', 'recentPending'));
    }
}

