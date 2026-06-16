<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationNote extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'admin_id',
        'action',
        'note',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi ke konten yang dimoderasi
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    // Relasi ke admin yang memberi catatan — foreign key custom
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
