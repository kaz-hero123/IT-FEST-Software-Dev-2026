<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use App\Models\Regency;
use App\Models\Photo;
use App\Http\Requests\Content\StoreContentRequest;
use App\Http\Requests\Content\UpdateContentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Public: tampilkan detail konten.
     * URL: GET /explore/{regency}/{content}
     * Validasi: content harus milik regency ini DAN status approved.
     */
    public function show(Regency $regency, Content $content)
    {
        // Validasi cross-regency access & status
        if ($content->regency_id !== $regency->id || $content->status !== 'approved') {
            abort(404);
        }

        // Increment view count
        $content->increment('view_count');

        $content->load(['photos', 'category', 'regency']);

        // Related contents: same category + same regency, approved, max 4, exclude current
        $relatedContents = Content::with([
                'photos' => fn($q) => $q->where('is_primary', true),
                'category',
            ])
            ->where('status', 'approved')
            ->where('category_id', $content->category_id)
            ->where('regency_id', $regency->id)
            ->where('id', '!=', $content->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('explore.detail', compact('content', 'relatedContents'));
    }

    /**
     * Contributor: form buat konten baru.
     * URL: GET /contents/create
     */
    public function create()
    {
        $categories = Category::all();
        $regencies = Regency::all();

        return view('contents.create', compact('categories', 'regencies'));
    }

    /**
     * Contributor: simpan konten baru.
     * URL: POST /contents
     */
    public function store(StoreContentRequest $request)
    {
        // Auto-generate slug dari title
        $slug = $this->generateUniqueSlug($request->title);

        $content = Content::create([
            'user_id'      => Auth::id(),
            'category_id'  => $request->category_id,
            'regency_id'   => $request->regency_id,
            'title'        => $request->title,
            'slug'         => $slug,
            'description'  => $request->description,
            'address'      => $request->address,
            'maps_url'     => $request->maps_url,
            'status'       => 'pending',
            'was_approved' => false,
        ]);

        // Simpan foto ke disk public, path: contents/{content_id}/
        foreach ($request->file('photos') as $index => $photo) {
            $path = $photo->store("contents/{$content->id}", 'public');
            Photo::create([
                'content_id' => $content->id,
                'file_path'  => $path,
                'is_primary' => $index === 0,
            ]);
        }

        return redirect('/dashboard')->with('success', 'Konten berhasil ditambahkan dan menunggu moderasi.');
    }

    /**
     * Contributor: form edit konten.
     * URL: GET /contents/{content}/edit
     */
    public function edit(Content $content)
    {
        // Cek kepemilikan
        if ($content->user_id !== Auth::id()) {
            abort(403);
        }

        $content->load(['photos', 'category', 'regency']);
        $categories = Category::all();
        $regencies = Regency::all();

        return view('contents.edit', compact('content', 'categories', 'regencies'));
    }

    /**
     * Contributor: update konten.
     * URL: PUT /contents/{content}
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        // Cek kepemilikan
        if ($content->user_id !== Auth::id()) {
            abort(403);
        }

        // Re-generate slug dari title baru (exclude current content dari uniqueness check)
        $slug = $this->generateUniqueSlug($request->title, $content->id);

        $content->update([
            'category_id' => $request->category_id,
            'regency_id'  => $request->regency_id,
            'title'       => $request->title,
            'slug'        => $slug,
            'description' => $request->description,
            'address'     => $request->address,
            'maps_url'    => $request->maps_url,
            'status'      => 'pending', // Paksa reset ke pending setelah edit
        ]);

        // Jika ada foto baru: replace all
        if ($request->hasFile('photos')) {
            // Hapus foto lama dari storage
            foreach ($content->photos as $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto->file_path);
            }
            // Hapus record foto lama dari DB
            $content->photos()->delete();

            // Insert foto baru
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store("contents/{$content->id}", 'public');
                Photo::create([
                    'content_id' => $content->id,
                    'file_path'  => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect('/dashboard')->with('success', 'Konten berhasil diperbarui dan menunggu moderasi ulang.');
    }

    /**
     * Contributor: hapus konten (soft delete).
     * URL: DELETE /contents/{content}
     */
    public function destroy(Content $content)
    {
        // Cek kepemilikan
        if ($content->user_id !== Auth::id()) {
            abort(403);
        }

        $content->update(['status' => 'deleted']);
        $content->delete(); // Soft delete — isi deleted_at

        return redirect('/dashboard')->with('success', 'Konten berhasil dihapus.');
    }

    /**
     * Generate unique slug dari title.
     * Jika sudah ada, append angka: pantai-jumiang, pantai-jumiang-2, dst.
     */
    private function generateUniqueSlug(string $title, int $excludeId = 0): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (Content::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
