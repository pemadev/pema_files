<?php

namespace App\Models;

/** Riwayat status permohonan informasi (tabel ppid_pi_status). */
class PpidPiStatus extends PpidStatusRow
{
    protected $table = 'ppid_pi_status';

    protected $fillable = ['ppid_pi_id', 'status', 'status_by', 'active', 'info'];
}
