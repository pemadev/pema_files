<?php

namespace App\Models;

use App\Models\Concerns\HasPpidRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpidPengaduan extends Model
{
    use SoftDeletes, HasPpidRecord;

    protected $table = 'ppid_pengaduan';

    const NUMBER_COLUMN = 'no_tiket';
    const NUMBER_PREFIX = 'PPID/ADU';
    const SEARCHABLE = ['no_tiket', 'nama', 'email', 'subjek', 'isi'];

    const STATUSES = [
        'baru'     => ['label' => 'Baru',     'color' => 'error'],
        'diproses' => ['label' => 'Diproses', 'color' => 'warning'],
        'selesai'  => ['label' => 'Selesai',  'color' => 'success', 'final' => true],
    ];

    const KATEGORI = [
        'layanan'   => 'Layanan informasi',
        'informasi' => 'Isi informasi',
        'petugas'   => 'Petugas',
        'lainnya'   => 'Lainnya',
    ];

    protected $fillable = [
        'no_tiket', 'nama', 'email', 'telepon', 'kategori', 'subjek', 'isi',
        'status', 'tanggapan', 'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
    ];
}
