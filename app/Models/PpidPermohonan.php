<?php

namespace App\Models;

use App\Models\Concerns\HasPpidRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpidPermohonan extends Model
{
    use SoftDeletes, HasPpidRecord;

    protected $table = 'ppid_permohonan';

    const NUMBER_COLUMN = 'no_registrasi';
    const NUMBER_PREFIX = 'PPID/REG';
    const SEARCHABLE = ['no_registrasi', 'nama', 'email', 'nik', 'rincian_informasi'];

    const STATUSES = [
        'diproses'            => ['label' => 'Diproses',            'color' => 'warning'],
        'disetujui'           => ['label' => 'Disetujui',          'color' => 'success', 'final' => true],
        'disetujui_sebagian'  => ['label' => 'Disetujui sebagian', 'color' => 'brand',   'final' => true],
        'ditolak'             => ['label' => 'Ditolak',             'color' => 'error',   'final' => true],
    ];

    const KATEGORI_PEMOHON = [
        'perorangan'  => 'Perorangan',
        'badan_hukum' => 'Badan hukum',
        'kelompok'    => 'Kelompok masyarakat',
    ];

    const CARA_MEMPEROLEH = [
        'melihat'  => 'Melihat / membaca / mencatat',
        'softcopy' => 'Salinan softcopy',
        'hardcopy' => 'Salinan hardcopy',
    ];

    const CARA_MENDAPATKAN = [
        'email'    => 'Email',
        'langsung' => 'Mengambil langsung',
        'pos'      => 'Pos / kurir',
    ];

    protected $fillable = [
        'no_registrasi', 'nama', 'nik', 'email', 'telepon', 'pekerjaan', 'alamat',
        'kategori_pemohon', 'rincian_informasi', 'tujuan_penggunaan',
        'cara_memperoleh', 'cara_mendapatkan', 'status', 'catatan', 'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
    ];

    public function keberatan(): HasMany
    {
        return $this->hasMany(PpidKeberatan::class, 'permohonan_id');
    }

    /** Batas jawaban: 10 hari kerja sejak permohonan diterima (Pasal 22 ayat 7 UU KIP). */
    public function getBatasWaktuAttribute(): \Illuminate\Support\Carbon
    {
        $date = $this->created_at->copy();
        $days = 0;
        while ($days < 10) {
            $date->addDay();
            if (! $date->isWeekend()) {
                $days++;
            }
        }
        return $date;
    }

    public function getTerlambatAttribute(): bool
    {
        return $this->status === 'diproses' && now()->greaterThan($this->batas_waktu);
    }
}
