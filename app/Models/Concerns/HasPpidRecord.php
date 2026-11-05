<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Perilaku bersama untuk data layanan PPID (permohonan, pengaduan, keberatan):
 * nomor registrasi otomatis, label & warna status, dan filter daftar.
 *
 * Model yang memakai trait ini wajib mendefinisikan:
 *   const NUMBER_COLUMN, const NUMBER_PREFIX, const STATUSES, const SEARCHABLE
 */
trait HasPpidRecord
{
    protected static function bootHasPpidRecord(): void
    {
        static::creating(function ($model) {
            $column = static::NUMBER_COLUMN;
            if (empty($model->{$column})) {
                $model->{$column} = static::generateNumber();
            }
        });
    }

    /** Contoh hasil: PPID/REG/2026/0042 */
    public static function generateNumber(): string
    {
        $year = now()->format('Y');
        $base = static::NUMBER_PREFIX . '/' . $year . '/';
        $seq = static::withTrashed()->whereYear('created_at', $year)->count() + 1;

        do {
            $number = $base . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
            $seq++;
        } while (static::withTrashed()->where(static::NUMBER_COLUMN, $number)->exists());

        return $number;
    }

    public function getNomorAttribute(): string
    {
        return (string) $this->{static::NUMBER_COLUMN};
    }

    public function getStatusLabelAttribute(): string
    {
        return static::STATUSES[$this->status]['label'] ?? ucfirst((string) $this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return static::STATUSES[$this->status]['color'] ?? 'gray';
    }

    /** Status yang dianggap selesai (punya tanggal_selesai). */
    public static function finalStatuses(): array
    {
        return array_keys(array_filter(static::STATUSES, fn ($s) => $s['final'] ?? false));
    }

    /**
     * Filter daftar: q (cari), status, tahun, bulan.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $table = $this->getTable();

        return $query
            ->when($filters['q'] ?? null, function (Builder $q, $term) {
                $q->where(function (Builder $w) use ($term) {
                    foreach (static::SEARCHABLE as $column) {
                        $w->orWhere($column, 'like', '%' . $term . '%');
                    }
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $q, $s) => $q->where($table . '.status', $s))
            ->when($filters['tahun'] ?? null, fn (Builder $q, $y) => $q->whereYear($table . '.created_at', $y))
            ->when($filters['bulan'] ?? null, fn (Builder $q, $m) => $q->whereMonth($table . '.created_at', $m));
    }
}
