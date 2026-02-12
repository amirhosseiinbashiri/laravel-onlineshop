<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'discount_price',
        'discount_ends_at',
        'category_id',
        'main_image',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }

    protected $casts = [
        'discount_ends_at' => 'datetime',
    ];

    // روابط
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // متد کمکی برای بررسی تخفیف فعال
    public function getHasActiveDiscountAttribute()
    {
        return $this->discount_price && $this->discount_ends_at > now();
    }

    public function getFinalPriceAttribute()
    {
        return $this->has_active_discount ? $this->discount_price : $this->price;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->where('is_approved', true);
    }
}
