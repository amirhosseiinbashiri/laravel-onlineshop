<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'image',
        'description',
        'parent_id',
    ];

    protected static function booted()
    {
        static::deleting(function ($category) {
            Category::where('parent_id', $category->id)
                ->update(['parent_id' => null]);
        });

        static::creating(function ($category) {
            $category->slug = Str::slug($category->title);
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
