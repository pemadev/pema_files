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
    protected string $noteField = 'tanggapan';
    protected array $with = ['permohonan'];

    protected function exportHeader(): array
    {
        return ['No. Registrasi', 'Tanggal', 'Nama', 'Email', 'Telepon', 'No. Permohonan', 'Alasan',
            'Uraian', 'Status', 'Tanggal Selesai', 'Tanggapan'];
    }

    protected function exportRow(Model $item): array
    {
        return [
            $item->no_registrasi,
            $item->created_at->format('Y-m-d H:i'),
            $item->nama,
            $item->email,
            $item->telepon,
            optional($item->permohonan)->no_registrasi,
            strtoupper($item->alasan) . '. ' . $item->alasan_label,
            $item->uraian,
            $item->status_label,
            optional($item->tanggal_selesai)->format('Y-m-d'),
            $item->tanggapan,
        ];
    }
}
