<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Baris riwayat status PPID (dasar untuk ppid_pi_status & ppid_pk_status).
 * Kolom: status, status_by, active, info.
 */
abstract class PpidStatusRow extends Model
{
    protected $fillable = ['status', 'status_by', 'active', 'info'];

    protected $casts = ['active' => 'boolean'];

    public function getConnectionName()
    {
        return config('database.ppid_connection');
    }

    public function getLabelAttribute(): string
    {
        return PpidPermohonan::STATUSES[$this->status]['label'] ?? ucfirst((string) $this->status);
    }

    public function getColorAttribute(): string
    {
        return PpidPermohonan::STATUSES[$this->status]['color'] ?? 'gray';
    }
}
