<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StatistikPema extends Model
{
    use HasFactory;

    protected $table = 'statistik_pemas';

    protected $fillable = [
        'label',
        'value',
        'decimals',
        'prefix',
        'suffix',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'value'     => 'float',
        'decimals'  => 'integer',
        'urutan'    => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function getValueFormattedAttribute(): string
    {
        return number_format($this->value, $this->decimals, ',', '.');
    }
}