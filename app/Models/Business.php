<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;
    protected $fillable = ['category', 'title', 'subtitle', 'description', 'icon', 'image', 'images', 'tags', 'sort_order'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
