<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    // Untuk ExploreController — hitung konten approved saja
    public function approvedContents()
    {
        return $this->hasMany(Content::class)->where('status', 'approved');
    }
}
