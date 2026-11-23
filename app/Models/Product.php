<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const CATEGORIES = [
        'imported'  => 'Imported Items',
        'handcraft' => 'Handcrafts',
    ];

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'price',
        'cost_price',
        'initial_sold',
        'in_stock',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
        'in_stock'   => 'boolean',
    ];

    // Safety net: these never appear if a product is ever sent out as JSON.
    protected $hidden = [
        'cost_price',
        'initial_sold',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    // The first photo is the cover photo.
    public function getCoverAttribute(): ?string
    {
        return $this->images->first()?->path;
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }
}