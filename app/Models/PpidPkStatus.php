<?php

namespace App\Models;

/** Riwayat status permohonan keberatan (tabel ppid_pk_status). */
class PpidPkStatus extends PpidStatusRow
{
    protected $table = 'ppid_pk_status';

    protected $fillable = ['ppid_pk_id', 'status', 'status_by', 'active', 'info'];
}
