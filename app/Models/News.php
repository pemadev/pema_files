<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'title', 'content', 'image', 'document_name', 'document_path', 'date', 'author', 'is_published'];

    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
    ];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'name');
    }
}
