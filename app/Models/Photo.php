<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'file_path',
        'is_primary',
    ];

    protected $appends = ['resolved_url'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function getResolvedUrlAttribute()
    {
        if (str_starts_with($this->file_path, 'images/')) {
            return asset($this->file_path);
        }
        
        return \Illuminate\Support\Facades\Storage::url($this->file_path);
    }
}
