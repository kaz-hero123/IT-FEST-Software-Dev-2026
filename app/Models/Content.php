<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'regency_id',
        'title',
        'slug',
        'description',
        'address',
        'maps_url',
        'status',
        'was_approved',
        'view_count',
    ];

    protected $casts = [
        'was_approved' => 'boolean',
    ];

    /**
     * Route model binding uses slug instead of ID for SEO-friendly URLs.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Relasi: konten milik satu user (contributor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: konten masuk satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: konten ada di satu kabupaten
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    // Relasi: satu konten punya banyak foto
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    // Relasi: satu konten bisa punya banyak moderation notes
    public function moderationNotes()
    {
        return $this->hasMany(ModerationNote::class);
    }

    // Helper: ambil hanya foto utama (is_primary = true)
    public function primaryPhoto()
    {
        return $this->hasOne(Photo::class)->where('is_primary', true);
    }

    // Helper: ambil moderation note terbaru (1 saja, per konten — aman untuk eager load)
    public function latestModerationNote()
    {
        return $this->hasOne(ModerationNote::class)->latestOfMany('created_at');
    }
}
