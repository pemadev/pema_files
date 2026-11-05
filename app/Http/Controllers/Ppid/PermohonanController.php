<?php

namespace App\Http\Controllers\Ppid;

use App\Models\PpidPermohonan;
use Illuminate\Database\Eloquent\Model;

class PermohonanController extends PpidRecordController
{
    protected string $model = PpidPermohonan::class;
    protected string $view = 'permohonan';
    protected string $routeName = 'pemohon';
    protected string $title = 'Permohonan Informasi';
    protected string $noteField = 'catatan';

    protected function exportHeader(): array
    {
        return ['No. Registrasi', 'Tanggal', 'Nama', 'NIK', 'Email', 'Telepon', 'Pekerjaan', 'Kategori',
            'Rincian Informasi', 'Tujuan', 'Cara Memperoleh', 'Status', 'Tanggal Selesai', 'Catatan'];
    }

    protected function exportRow(Model $item): array
    {
        return [
            $item->no_registrasi,
            $item->created_at->format('Y-m-d H:i'),
            $item->nama,
            $item->nik,
            $item->email,
            $item->telepon,
            $item->pekerjaan,
            PpidPermohonan::KATEGORI_PEMOHON[$item->kategori_pemohon] ?? $item->kategori_pemohon,
            $item->rincian_informasi,
            $item->tujuan_penggunaan,
            PpidPermohonan::CARA_MEMPEROLEH[$item->cara_memperoleh] ?? $item->cara_memperoleh,
            $item->status_label,
            optional($item->tanggal_selesai)->format('Y-m-d'),
            $item->catatan,
        ];
    }
}
