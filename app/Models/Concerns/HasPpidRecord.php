<?php

namespace App\Models\Concerns;

use App\Models\PpidUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Perilaku bersama data layanan PPID di database production (permohonan informasi & keberatan).
 *
 * Struktur di server: data pengajuan disimpan di satu tabel, identitas pemohon di ppid_users,
 * dan riwayat status di tabel terpisah (ppid_pi_status / ppid_pk_status). Status saat ini
 * adalah baris status terakhir (id terbesar).
 *
 * Model yang memakai trait ini wajib mendefinisikan:
 *   const NUMBER_COLUMN, const STATUS_MODEL, const STATUS_FK, const SEARCHABLE
 */
trait HasPpidRecord
{
    /** Status di server: enum('disubmit','diproses','selesai','ditolak'). */
    public const STATUSES = [
        'disubmit' => ['label' => 'Disubmit', 'color' => 'brand'],
        'diproses' => ['label' => 'Diproses',   'color' => 'warning'],
        'selesai'  => ['label' => 'Selesai',    'color' => 'success', 'final' => true],
        'ditolak'  => ['label' => 'Ditolak',    'color' => 'error',   'final' => true],
    ];

    public const DEFAULT_STATUS = 'disubmit';

    /** Semua data PPID memakai koneksi database PPID (config database.ppid_connection). */
    public function initializeHasPpidRecord(): void
    {
        $this->setConnection(config('database.ppid_connection'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(PpidUser::class, 'ppid_users_id');
    }

    /** Riwayat status, urut dari yang paling awal. */
    public function statuses(): HasMany
    {
        return $this->hasMany(static::STATUS_MODEL, static::STATUS_FK)->orderBy('id');
    }

    public function latestStatus(): HasOne
    {
        return $this->hasOne(static::STATUS_MODEL, static::STATUS_FK)->latestOfMany('id');
    }

    /** SQL status saat ini, dipakai untuk filter & rekap di database. */
    public static function currentStatusSql(): string
    {
        $instance = new static;
        $statusTable = (new (static::STATUS_MODEL))->getTable();

        return sprintf(
            "COALESCE((SELECT s.status FROM `%s` s WHERE s.`%s` = `%s`.`id` ORDER BY s.id DESC LIMIT 1), '%s')",
            $statusTable, static::STATUS_FK, $instance->getTable(), static::DEFAULT_STATUS
        );
    }

    public function scopeWhereCurrentStatus(Builder $query, string|array $status): Builder
    {
        $status = (array) $status;

        return $query->whereRaw(static::currentStatusSql() . ' IN (' . implode(',', array_fill(0, count($status), '?')) . ')', $status);
    }

    public function getNomorAttribute(): string
    {
        return (string) $this->{static::NUMBER_COLUMN};
    }

    public function getStatusAttribute(): string
    {
        return $this->latestStatus?->status ?? static::DEFAULT_STATUS;
    }

    public function getStatusLabelAttribute(): string
    {
        return static::STATUSES[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return static::STATUSES[$this->status]['color'] ?? 'gray';
    }

    /** Tanggal status final (selesai/ditolak) dicatat; null bila belum selesai. */
    public function getTanggalSelesaiAttribute(): ?Carbon
    {
        return in_array($this->status, static::finalStatuses(), true) ? $this->latestStatus?->created_at : null;
    }

    public function getNamaAttribute(): string
    {
        return (string) ($this->user?->name ?? '—');
    }

    public function getEmailAttribute(): ?string
    {
        return $this->user?->email;
    }

    public function getTeleponAttribute(): ?string
    {
        return $this->user?->telepon;
    }

    /** Status yang dianggap selesai. */
    public static function finalStatuses(): array
    {
        return array_keys(array_filter(static::STATUSES, fn ($s) => $s['final'] ?? false));
    }

    /** Status yang masih perlu ditangani. */
    public static function openStatuses(): array
    {
        return array_values(array_diff(array_keys(static::STATUSES), static::finalStatuses()));
    }

    /**
     * Filter daftar: q (cari), status, tahun, bulan.
     * Kolom SEARCHABLE berawalan "user." dicari di data pemohon (ppid_users).
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $table = $this->getTable();

        return $query
            ->when($filters['q'] ?? null, function (Builder $q, $term) use ($table) {
                $like = '%' . $term . '%';
                $own = array_filter(static::SEARCHABLE, fn ($c) => ! str_starts_with($c, 'user.'));
                $userCols = array_map(fn ($c) => substr($c, 5), array_filter(static::SEARCHABLE, fn ($c) => str_starts_with($c, 'user.')));

                $q->where(function (Builder $w) use ($own, $userCols, $like, $table) {
                    foreach ($own as $column) {
                        $w->orWhere($table . '.' . $column, 'like', $like);
                    }
                    if ($userCols) {
                        $w->orWhereHas('user', function (Builder $u) use ($userCols, $like) {
                            $u->where(function (Builder $uw) use ($userCols, $like) {
                                foreach ($userCols as $column) {
                                    $uw->orWhere($column, 'like', $like);
                                }
                            });
                        });
                    }
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $q, $s) => $q->whereCurrentStatus($s))
            ->when($filters['tahun'] ?? null, fn (Builder $q, $y) => $q->whereYear($table . '.created_at', $y))
            ->when($filters['bulan'] ?? null, fn (Builder $q, $m) => $q->whereMonth($table . '.created_at', $m));
    }

    /** Jumlah data per status saat ini (mengikuti filter lain). */
    public static function statusCounts(array $filters = []): array
    {
        $counts = static::query()
            ->filter(array_diff_key($filters, ['status' => true]))
            ->selectRaw(static::currentStatusSql() . ' as current_status, COUNT(*) as total')
            ->groupBy('current_status')
            ->pluck('total', 'current_status')
            ->map(fn ($v) => (int) $v)
            ->all();

        return $counts;
    }
}
