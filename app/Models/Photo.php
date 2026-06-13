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

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
