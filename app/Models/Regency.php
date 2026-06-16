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

    public function approvedContents()
    {
        return $this->hasMany(Content::class)->where('status', 'approved');
    }

    public function getRouteKeyName(): string
    {
    return 'slug';
    }
}
