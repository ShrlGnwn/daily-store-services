<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable =[
        'id',
        'slug',
        'name',
        'unit',
        'price',
        'original_price',
        'category_slug',
        'images',
        'rating',
        'stock',
        'is_popular',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
        'is_popular' => 'boolean',
        'price' => 'integer',
        'original_price' => 'integer',
        'rating' => 'float',
        'stock' => 'integer',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_slug', 'slug');
    }
}
