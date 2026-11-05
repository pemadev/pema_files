<?php

namespace App\Models;

use App\Models\Concerns\HasPpidRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpidKeberatan extends Model
{
    use SoftDeletes, HasPpidRecord;

    protected $table = 'ppid_keberatan';

    const NUMBER_COLUMN = 'no_registrasi';
    const NUMBER_PREFIX = 'PPID/KBR';
    const SEARCHABLE = ['ppid_keberatan.no_registrasi', 'ppid_keberatan.nama', 'ppid_keberatan.email', 'ppid_keberatan.uraian'];

    const STATUSES = [
        'diproses' => ['label' => 'Diproses', 'color' => 'warning'],
        'diterima' => ['label' => 'Diterima', 'color' => 'success', 'final' => true],
        'ditolak'  => ['label' => 'Ditolak',  'color' => 'error',   'final' => true],
    ];

    /** Alasan keberatan, Pasal 35 ayat (1) UU 14/2008. */
    const ALASAN = [
        'a' => 'Permohonan informasi ditolak berdasarkan alasan pengecualian',
        'b' => 'Informasi berkala tidak disediakan',
        'c' => 'Permohonan informasi tidak ditanggapi',
        'd' => 'Permohonan ditanggapi tidak sebagaimana yang diminta',
        'e' => 'Permohonan informasi tidak dipenuhi',
        'f' => 'Biaya yang dikenakan tidak wajar',
        'g' => 'Informasi disampaikan melebihi waktu yang diatur',
    ];

    protected $fillable = [
        'no_registrasi', 'permohonan_id', 'nama', 'email', 'telepon', 'alasan', 'uraian',
        'status', 'tanggapan', 'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(PpidPermohonan::class, 'permohonan_id');
    }

    public function getAlasanLabelAttribute(): string
    {
        return self::ALASAN[$this->alasan] ?? (string) $this->alasan;
    }
}
