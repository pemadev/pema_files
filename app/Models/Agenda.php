<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;
    protected $table = 'agenda';

    protected $fillable = ['title', 'description', 'date', 'location', 'latitude', 'longitude', 'is_published'];

    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
    ];
}
