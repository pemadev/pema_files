<?php

namespace App\Http\Controllers\Ppid;

use App\Models\PpidPengaduan;
use Illuminate\Database\Eloquent\Model;

class PengaduanController extends PpidRecordController
{
    protected string $model = PpidPengaduan::class;
    protected string $view = 'pengaduan';
    protected string $routeName = 'pengaduan';
    protected string $title = 'Pengaduan';
    protected string $noteField = 'tanggapan';

    protected function exportHeader(): array
    {
        return ['No. Tiket', 'Tanggal', 'Nama', 'Email', 'Telepon', 'Kategori', 'Subjek', 'Isi',
            'Status', 'Tanggal Selesai', 'Tanggapan'];
    }

    protected function exportRow(Model $item): array
    {
        return [
            $item->no_tiket,
            $item->created_at->format('Y-m-d H:i'),
            $item->nama,
            $item->email,
            $item->telepon,
            PpidPengaduan::KATEGORI[$item->kategori] ?? $item->kategori,
            $item->subjek,
            $item->isi,
            $item->status_label,
            optional($item->tanggal_selesai)->format('Y-m-d'),
            $item->tanggapan,
        ];
    }
}
