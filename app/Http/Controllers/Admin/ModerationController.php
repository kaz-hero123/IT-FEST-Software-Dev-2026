<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectContentRequest;
use App\Models\Content;
use App\Models\ModerationNote;

use Illuminate\Http\Request;

class ModerationController extends Controller
{
    /**
     * List konten berdasarkan filter.
     * Default: pending (antrian moderasi).
     * Supports: ?search=xxx, ?status=pending|approved|rejected
     * URL: GET /admin/moderation
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');
        $search = $request->input('search');

        $contents = Content::with([
                'user',
                'category',
                'regency',
                'photos' => fn($q) => $q->where('is_primary', true),
            ])
            ->when($status !== 'all', function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
                });
            })
            ->oldest()
            ->paginate(12)
            ->appends(['search' => $search, 'status' => $status]);

        return view('pages.admin.moderation.index', compact('contents', 'status', 'search'));
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
