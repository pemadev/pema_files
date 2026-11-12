<?php

namespace App\Http\Controllers\Ppid;

use App\Models\PpidKeberatan;
use Illuminate\Database\Eloquent\Model;

class KeberatanController extends PpidRecordController
{
    protected string $model = PpidKeberatan::class;
    protected string $view = 'keberatan';
    protected string $routeName = 'keberatan';
    protected string $title = 'Keberatan';
    protected array $with = ['user', 'latestStatus', 'permohonan.latestStatus'];

    protected function exportHeader(): array
    {
        return ['No. Permohonan', 'Tanggal', 'Nama', 'Email', 'Telepon', 'Alasan Keberatan', 'Tujuan Penggunaan Informasi',
            'Kuasa Hukum', 'Alamat Kuasa Hukum', 'Telepon Kuasa Hukum', 'Status', 'Tanggal Selesai', 'Keterangan Status'];
    }

    protected function exportRow(Model $item): array
    {
        return [
            $item->no_permohonan,
            $item->created_at->format('Y-m-d H:i'),
            $item->nama,
            $item->email,
            $item->telepon,
            $item->alasan_pengajuan_keberatan,
            $item->tujuan_penggunaan_informasi,
            $item->nama_kuasa_hukum,
            $item->alamat_kuasa_hukum,
            $item->telepon_kuasa_hukum,
            $item->status_label,
            optional($item->tanggal_selesai)->format('Y-m-d'),
            $item->latestStatus?->info,
        ];
    }
}
