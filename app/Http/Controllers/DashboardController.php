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

        $stats = [
            'approved' => Content::where('user_id', $userId)->where('status', 'approved')->count(),
            'pending'  => Content::where('user_id', $userId)->where('status', 'pending')->count(),
            'rejected' => Content::where('user_id', $userId)->where('status', 'rejected')->count(),
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

        return view('dashboard.index', compact('stats', 'contents'));
    }
}
