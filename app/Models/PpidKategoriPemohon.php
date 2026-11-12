<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Kategori pemohon (tabel ppid_kategori_pemohon). */
class PpidKategoriPemohon extends Model
{
    protected $table = 'ppid_kategori_pemohon';

    public function getConnectionName()
    {
        return config('database.ppid_connection');
    }
}
