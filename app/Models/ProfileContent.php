<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileContent extends Model
{
    use SoftDeletes;
    protected $fillable = ['type', 'title', 'content', 'image', 'image_left', 'additional_info', 'person_name', 'person_position'];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}