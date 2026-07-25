<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectContentRequest;
use App\Models\Content;
use App\Models\ModerationNote;

class ModerationController extends Controller
{
    /**
     * List semua konten pending (antrian moderasi).
     * URL: GET /admin/moderation
     */
    public function index()
    {
        $contents = Content::with([
                'user',
                'category',
                'regency',
                'photos' => fn($q) => $q->where('is_primary', true),
            ])
            ->where('status', 'pending')
            ->oldest() // FIFO — konten paling lama dulu
            ->paginate(12);

        return view('pages.admin.moderation.index', compact('contents'));
    }

    /**
     * Detail konten untuk review moderasi.
     * URL: GET /admin/moderation/{content}
     */
    public function show(Content $content)
    {
        $content->load(['photos', 'category', 'regency', 'user']);

        $moderationNotes = ModerationNote::with('admin')
            ->where('content_id', $content->id)
            ->latest('created_at')
            ->get();

        return view('pages.admin.moderation.show', compact('content', 'moderationNotes'));
    }

    /**
     * Approve konten.
     * URL: POST /admin/moderation/{content}/approve
     */
    public function approve(Content $content)
    {
        $content->update([
            'status'       => 'approved',
            'was_approved' => true,
        ]);

        $content->logModeration('approved');

        return redirect('/admin/moderation')->with('success', 'Konten berhasil di-approve.');
    }

    /**
     * Reject konten.
     * URL: POST /admin/moderation/{content}/reject
     */
    public function reject(RejectContentRequest $request, Content $content)
    {
        $content->update([
            'status' => 'rejected',
        ]);

        $content->logModeration('rejected', $request->note);

        return redirect('/admin/moderation')->with('success', 'Konten berhasil di-reject.');
    }
}
