<?php

namespace Database\Seeders;

use App\Models\StatistikPema;
use Illuminate\Database\Seeder;

class StatistikPemaSeeder extends Seeder
{
    
    public function run(): void
    {
        $data = [
            [
                'label'     => 'Anak Perusahaan & Unit Bisnis',
                'value'     => 12,
                'decimals'  => 0,
                'suffix'    => '+',
                'deskripsi' => 'Portofolio bisnis PT PEMA di sektor migas, energi, dan jasa penunjang.',
                'urutan'    => 1,
            ],
            [
                'label'     => 'Pertumbuhan Pendapatan',
                'value'     => 18,
                'decimals'  => 0,
                'suffix'    => '%',
                'deskripsi' => 'Pertumbuhan pendapatan tahun berjalan dibanding tahun sebelumnya.',
                'urutan'    => 2,
            ],
            [
                'label'     => 'Nilai Aset Dikelola',
                'value'     => 1.2,
                'decimals'  => 1,
                'prefix'    => 'Rp ',
                'suffix'    => ' T',
                'deskripsi' => 'Total nilai aset yang dikelola PT PEMA beserta anak usaha.',
                'urutan'    => 3,
            ],
            [
                'label'     => 'Proyek Strategis Berjalan',
                'value'     => 24,
                'decimals'  => 0,
                'suffix'    => '+',
                'deskripsi' => 'Proyek pembangunan dan investasi strategis di Aceh yang sedang berjalan.',
                'urutan'    => 4,
            ],
            [
                'label'     => 'Mitra Kerja Sama',
                'value'     => 30,
                'decimals'  => 0,
                'suffix'    => '+',
                'deskripsi' => 'Mitra dari kalangan pemerintah, BUMN, dan swasta.',
                'urutan'    => 5,
            ],
            [
                'label'     => 'Tenaga Kerja Lokal Terserap',
                'value'     => 850,
                'decimals'  => 0,
                'suffix'    => '+',
                'deskripsi' => 'Tenaga kerja lokal Aceh yang terlibat dalam proyek PT PEMA.',
                'urutan'    => 6,
            ],
        ];

        foreach ($data as $item) {
            StatistikPema::updateOrCreate(
                ['label' => $item['label']],
                $item
            );
        }
    }
}