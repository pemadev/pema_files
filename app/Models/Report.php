<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'file', 'year', 'description', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
