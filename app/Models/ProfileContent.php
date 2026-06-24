<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileContent extends Model
{
    use SoftDeletes;
    protected $fillable = ['type', 'title', 'content', 'image', 'additional_info'];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
