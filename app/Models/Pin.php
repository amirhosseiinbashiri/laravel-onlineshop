<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pin extends Model
{
    protected $fillable = ['name', 'slug'];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    protected static function booted()
    {

        static::creating(function ($pin) {
            $pin->slug = Str::slug($pin->name);
        });
    }
}
