<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Contributor dashboard: stats + list konten milik user.
     * URL: GET /dashboard
     */
    public function index()
    {
        $userId = Auth::id();

        // Single query: GROUP BY status instead of 3 separate COUNT queries (F-07a)
        $statusCounts = Content::query()
            ->where('user_id', $userId)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'approved' => $statusCounts->get('approved', 0),
            'pending'  => $statusCounts->get('pending', 0),
            'rejected' => $statusCounts->get('rejected', 0),
        ];

        $contents = Content::with([
                'category',
                'regency',
                'photos' => fn($q) => $q->where('is_primary', true),
                'latestModerationNote',
            ])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(12);

        return view('pages.contributor.home.contributor-home-index', compact('stats', 'contents'));
    }
}

