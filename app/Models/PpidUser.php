<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Akun pemohon di portal PPID (tabel ppid_users). Hanya dibaca dari dashboard ini;
 * pendaftaran & perubahan akun dilakukan dari portal PPID.
 */
class PpidUser extends Model
{
    protected $table = 'ppid_users';

    protected $hidden = ['password'];

    protected $casts = ['active' => 'boolean'];

    public function getConnectionName()
    {
        return config('database.ppid_connection');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(PpidKategoriPemohon::class, 'id_kategori_pemohon');
    }

    public function permohonan(): HasMany
    {
        return $this->hasMany(PpidPermohonan::class, 'ppid_users_id');
    }

    public function keberatan(): HasMany
    {
        return $this->hasMany(PpidKeberatan::class, 'ppid_users_id');
    }

    public function getAlamatAttribute(): ?string
    {
        $parts = array_filter([$this->kelurahan_desa, $this->kecamatan, $this->kabupaten_kota, $this->provinsi, $this->kode_pos]);

        return $parts ? implode(', ', $parts) : null;
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['q'] ?? null, function (Builder $q, $term) {
                $like = '%' . $term . '%';
                $q->where(fn (Builder $w) => $w->where('name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('telepon', 'like', $like)
                    ->orWhere('no_ktp', 'like', $like));
            })
            ->when($filters['kategori'] ?? null, fn (Builder $q, $k) => $q->where('id_kategori_pemohon', $k))
            ->when(($filters['aktif'] ?? '') !== '', fn (Builder $q) => $q->where('active', (int) $filters['aktif']))
            ->when($filters['tahun'] ?? null, fn (Builder $q, $y) => $q->whereYear('created_at', $y));
    }
}
