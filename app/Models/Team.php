<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'position', 'photo', 'category', 'sort_order'];

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
