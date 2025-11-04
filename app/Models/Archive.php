<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Archive extends Model
{
    protected $fillable = ['title', 'slug'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'archive_id');
    }

    protected static function booted()
    {

        static::creating(function ($archive) {
            $archive->slug = Str::slug($archive->title);
        });
    }
}
