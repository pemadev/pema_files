<?php

namespace App\Models;

use App\Models\Concerns\HasPpidRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/** Permohonan informasi (tabel ppid_permohonan_informasi di database production). */
class PpidPermohonan extends Model
{
    use HasPpidRecord;

    protected $table = 'ppid_permohonan_informasi';

    const NUMBER_COLUMN = 'no_permohonan';
    const STATUS_MODEL = PpidPiStatus::class;
    const STATUS_FK = 'ppid_pi_id';
    const SEARCHABLE = ['no_permohonan', 'rincian_informasi', 'user.name', 'user.email', 'user.no_ktp'];

    protected $casts = [
        'cara_memperoleh_informasi' => 'array',
        'bentuk_salinan_informasi'  => 'array',
    ];

    /** Keberatan yang diajukan atas permohonan ini (dihubungkan lewat no_permohonan). */
    public function keberatan(): HasMany
    {
        return $this->hasMany(PpidKeberatan::class, 'no_permohonan', 'no_permohonan');
    }

    /** Batas jawaban: 10 hari kerja sejak permohonan diterima (Pasal 22 ayat 7 UU KIP). */
    public function getBatasWaktuAttribute(): Carbon
    {
        return $this->created_at->copy()->addWeekdays(10);
    }

    public function getTerlambatAttribute(): bool
    {
        return in_array($this->status, static::openStatuses(), true) && now()->greaterThan($this->batas_waktu);
    }
}
