<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnpublishContentRequest;
use App\Models\Content;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * List semua konten yang sudah approved.
     * Supports: ?search=xxx
     * URL: GET /admin/contents
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $contents = Content::with([
                'user',
                'category',
                'regency',
                'photos' => fn($q) => $q->where('is_primary', true),
            ])
            ->where('status', 'approved')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest('updated_at')
            ->paginate(12)
            ->appends(['search' => $search]);

        return view('pages.admin.contents.index', compact('contents', 'search'));
    }

    /**
     * Unpublish konten (kembalikan ke pending).
     * URL: POST /admin/contents/{content}/unpublish
     */
    public function unpublish(UnpublishContentRequest $request, Content $content)
    {
        $content->update([
            'status' => 'pending',
            // was_approved tetap true — pernah di-approve sebelumnya
        ]);

        $content->logModeration('unpublished', $request->note);

        return redirect('/admin/contents')->with('success', 'Konten berhasil di-unpublish.');
    }

    /**
     * Delete konten (soft delete oleh admin).
     * URL: DELETE /admin/contents/{content}
     */
    public function destroy(Content $content)
    {
        $content->softDeleteWithStatus();
        $content->logModeration('deleted');

        return redirect('/admin/contents')->with('success', 'Konten berhasil dihapus.');
    }
}
