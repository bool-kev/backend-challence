<?php

namespace App\Models;

use App\Enums\V1\BlogStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    /** @use HasFactory<\Database\Factories\ThemeFactory> */
    use HasFactory;

    protected $fillable = [
        'titre'
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class)->where('status', BlogStatus::PUBLISHED);
    }
}
