<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectContentRequest;
use App\Models\Content;
use App\Models\ModerationNote;
use Illuminate\Support\Facades\Auth;

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

        return view('admin.moderation.index', compact('contents'));
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

        return view('admin.moderation.show', compact('content', 'moderationNotes'));
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

        ModerationNote::create([
            'content_id' => $content->id,
            'admin_id'   => Auth::id(),
            'action'     => 'approved',
            'note'       => null,
            'created_at' => now(),
        ]);

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

        ModerationNote::create([
            'content_id' => $content->id,
            'admin_id'   => Auth::id(),
            'action'     => 'rejected',
            'note'       => $request->note,
            'created_at' => now(),
        ]);

        return redirect('/admin/moderation')->with('success', 'Konten berhasil di-reject.');
    }
}
