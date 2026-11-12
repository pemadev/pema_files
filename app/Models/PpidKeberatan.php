<?php

namespace App\Models;

use App\Models\Concerns\HasPpidRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/** Permohonan keberatan (tabel ppid_permohonan_keberatan di database production). */
class PpidKeberatan extends Model
{
    use HasPpidRecord;

    protected $table = 'ppid_permohonan_keberatan';

    const NUMBER_COLUMN = 'no_permohonan';
    const STATUS_MODEL = PpidPkStatus::class;
    const STATUS_FK = 'ppid_pk_id';
    const SEARCHABLE = ['no_permohonan', 'alasan_pengajuan_keberatan', 'nama_kuasa_hukum', 'user.name', 'user.email'];

    /** Permohonan informasi yang dikeberatani (dihubungkan lewat no_permohonan). */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(PpidPermohonan::class, 'no_permohonan', 'no_permohonan');
    }

    /** Batas tanggapan atasan PPID: 30 hari kerja (Pasal 36 UU KIP). */
    public function getBatasWaktuAttribute(): Carbon
    {
        return $this->created_at->copy()->addWeekdays(30);
    }
}
