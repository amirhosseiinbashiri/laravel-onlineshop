<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable =  ['archive_id', 'user_id', 'title', 'slug', 'summary', 'body', 'main_image', 'is_published'];


    protected static function booted()
    {

        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }


    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function pins()
    {
        return $this->belongsToMany(Pin::class);
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
