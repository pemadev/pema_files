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
    protected array $with = ['user.kategori', 'latestStatus'];

    protected function exportHeader(): array
    {
        return ['No. Permohonan', 'Tanggal', 'Nama', 'No. KTP', 'Email', 'Telepon', 'Kategori',
            'Rincian Informasi', 'Tujuan Penggunaan', 'Cara Memperoleh', 'Bentuk Salinan', 'Cara Mendapatkan Salinan',
            'Status', 'Tanggal Selesai', 'Keterangan Status'];
    }

    protected function exportRow(Model $item): array
    {
        return [
            $item->no_permohonan,
            $item->created_at->format('Y-m-d H:i'),
            $item->nama,
            $item->user?->no_ktp,
            $item->email,
            $item->telepon,
            $item->user?->kategori?->kategori_pemohon,
            $item->rincian_informasi,
            $item->tujuan_penggunaan,
            implode(', ', (array) $item->cara_memperoleh_informasi),
            implode(', ', (array) $item->bentuk_salinan_informasi),
            $item->cara_mendapatkan_salinan,
            $item->status_label,
            optional($item->tanggal_selesai)->format('Y-m-d'),
            $item->latestStatus?->info,
        ];
    }
}
