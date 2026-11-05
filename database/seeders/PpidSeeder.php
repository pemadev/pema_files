<?php

namespace Database\Seeders;

use App\Models\PpidKeberatan;
use App\Models\PpidPengaduan;
use App\Models\PpidPermohonan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * DATA CONTOH untuk mencoba dashboard PPID.
 * Jalankan: php artisan db:seed --class=PpidSeeder
 * Seeder ini tidak berjalan jika tabel PPID sudah berisi data.
 */
class PpidSeeder extends Seeder
{
    private array $namaDepan = ['Ahmad', 'Muhammad', 'Rizki', 'Nurul', 'Cut', 'Teuku', 'Siti', 'Fitri', 'Zulfikar', 'Rahmat',
        'Dewi', 'Fauzan', 'Intan', 'Maulana', 'Rina', 'Hendra', 'Safrizal', 'Yuni', 'Irwan', 'Mutia'];
    private array $namaBelakang = ['Saputra', 'Hidayat', 'Rahman', 'Fadhil', 'Azhari', 'Yusuf', 'Ismail', 'Ramadhan',
        'Nasution', 'Harahap', 'Syahputra', 'Amalia', 'Husein', 'Iskandar', 'Mahmud'];
    private array $pekerjaan = ['Mahasiswa', 'Wartawan', 'Peneliti', 'Karyawan swasta', 'Wiraswasta', 'Dosen', 'Aktivis LSM', 'PNS'];
    private array $informasi = [
        'Laporan keuangan tahunan PT PEMA tahun %d yang telah diaudit.',
        'Rencana kerja dan anggaran perusahaan (RKAP) tahun %d.',
        'Daftar penyertaan modal Pemerintah Aceh kepada PT PEMA hingga tahun %d.',
        'Dokumen kerja sama pengelolaan Wilayah Kerja migas yang dikelola anak perusahaan tahun %d.',
        'Data penyaluran program tanggung jawab sosial (CSR) di kabupaten/kota tahun %d.',
        'Struktur organisasi dan profil direksi serta komisaris tahun %d.',
        'Laporan kinerja anak perusahaan sektor energi tahun %d.',
        'Prosedur pengadaan barang dan jasa yang berlaku tahun %d.',
    ];
    private array $tujuan = ['Bahan penelitian skripsi', 'Bahan pemberitaan', 'Kajian kebijakan publik', 'Kebutuhan advokasi masyarakat', 'Referensi kerja sama usaha'];
    private array $subjekAduan = [
        'layanan'   => ['Permohonan belum ditanggapi', 'Formulir online tidak bisa dikirim', 'Tidak menerima email konfirmasi'],
        'informasi' => ['Informasi yang diberikan tidak lengkap', 'Dokumen di situs tidak bisa diunduh', 'Data di situs tidak diperbarui'],
        'petugas'   => ['Petugas sulit dihubungi', 'Respons petugas lambat'],
        'lainnya'   => ['Saran perbaikan layanan PPID', 'Pertanyaan jadwal layanan tatap muka'],
    ];

    public function run(): void
    {
        if (PpidPermohonan::withTrashed()->exists() || PpidPengaduan::withTrashed()->exists()) {
            $this->command?->warn('Tabel PPID sudah berisi data. PpidSeeder dilewati agar data asli tidak tercampur.');
            return;
        }

        mt_srand(2026);
        $start = Carbon::create(2025, 1, 1);
        $end = now();

        // Permohonan informasi
        $permohonan = collect();
        foreach ($this->randomDates(160, $start, $end) as $i => $date) {
            $nama = $this->nama();
            $permohonan->push(PpidPermohonan::forceCreate([
                'no_registrasi'     => $this->nomor('PPID/REG', $date),
                'nama'              => $nama,
                'nik'               => '11' . mt_rand(1000000, 9999999) . mt_rand(1000000, 9999999),
                'email'             => $this->email($nama),
                'telepon'           => '08' . mt_rand(1100000000, 1399999999),
                'pekerjaan'         => $this->pick($this->pekerjaan),
                'alamat'            => 'Banda Aceh',
                'kategori_pemohon'  => $this->weighted(['perorangan' => 80, 'badan_hukum' => 12, 'kelompok' => 8]),
                'rincian_informasi' => sprintf($this->pick($this->informasi), (int) $date->format('Y') - mt_rand(0, 1)),
                'tujuan_penggunaan' => $this->pick($this->tujuan),
                'cara_memperoleh'   => $this->weighted(['softcopy' => 70, 'melihat' => 15, 'hardcopy' => 15]),
                'cara_mendapatkan'  => $this->weighted(['email' => 75, 'langsung' => 20, 'pos' => 5]),
                ...$this->resolution($date, [
                    'dikabulkan' => 65, 'dikabulkan_sebagian' => 20, 'ditolak' => 15,
                ], 'catatan', 'Informasi telah dikirim melalui email pemohon.'),
                'created_at'        => $date,
                'updated_at'        => $date,
            ]));
        }

        // Pengaduan
        foreach ($this->randomDates(48, $start, $end) as $date) {
            $nama = $this->nama();
            $kategori = $this->weighted(['layanan' => 40, 'informasi' => 30, 'petugas' => 15, 'lainnya' => 15]);
            $res = $this->resolution($date, ['selesai' => 100], 'tanggapan', 'Pengaduan telah ditindaklanjuti dan disampaikan kepada pengadu.');
            if ($res['status'] === 'diproses' && $date->diffInDays(now()) < 4) {
                $res['status'] = 'baru';
            }
            PpidPengaduan::forceCreate([
                'no_tiket'   => $this->nomor('PPID/ADU', $date),
                'nama'       => $nama,
                'email'      => $this->email($nama),
                'telepon'    => '08' . mt_rand(1100000000, 1399999999),
                'kategori'   => $kategori,
                'subjek'     => $this->pick($this->subjekAduan[$kategori]),
                'isi'        => 'Mohon perhatian PPID PT PEMA terkait hal ini. Saya sudah mencoba beberapa kali namun belum mendapat kejelasan.',
                ...$res,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // Keberatan (mengacu ke permohonan yang ditolak/sebagian bila ada)
        $basis = $permohonan->whereIn('status', ['ditolak', 'dikabulkan_sebagian'])->values();
        foreach ($basis->random(min(16, $basis->count())) as $p) {
            $date = $p->created_at->copy()->addDays(mt_rand(12, 25));
            if ($date->greaterThan(now())) {
                $date = now()->subHours(mt_rand(1, 48));
            }
            PpidKeberatan::forceCreate([
                'no_registrasi' => $this->nomor('PPID/KBR', $date),
                'permohonan_id' => $p->id,
                'nama'          => $p->nama,
                'email'         => $p->email,
                'telepon'       => $p->telepon,
                'alasan'        => $p->status === 'ditolak' ? 'a' : $this->pick(['d', 'e']),
                'uraian'        => 'Saya keberatan atas jawaban PPID terhadap permohonan ' . $p->no_registrasi . ' karena informasi tersebut menyangkut kepentingan publik.',
                ...$this->resolution($date, ['diterima' => 45, 'ditolak' => 55], 'tanggapan', 'Atasan PPID telah memeriksa keberatan dan memberikan keputusan.', 30),
                'created_at'    => $date,
                'updated_at'    => $date,
            ]);
        }

        $this->command?->info('Data contoh PPID dibuat: ' . PpidPermohonan::count() . ' permohonan, '
            . PpidPengaduan::count() . ' pengaduan, ' . PpidKeberatan::count() . ' keberatan.');
    }

    /** Status: data lama selesai, data baru (< $openDays hari) masih diproses. */
    private function resolution(Carbon $date, array $finalWeights, string $noteField, string $note, int $openDays = 14): array
    {
        $age = $date->diffInDays(now());
        if ($age < $openDays || mt_rand(1, 100) <= 4) {
            return ['status' => 'diproses', $noteField => null, 'tanggal_selesai' => null];
        }
        $done = $date->copy()->addWeekdays(mt_rand(2, 9));
        return [
            'status'          => $this->weighted($finalWeights),
            $noteField        => $note,
            'tanggal_selesai' => $done->greaterThan(now()) ? now()->toDateString() : $done->toDateString(),
        ];
    }

    private array $counters = [];

    private function nomor(string $prefix, Carbon $date): string
    {
        $key = $prefix . $date->format('Y');
        $this->counters[$key] = ($this->counters[$key] ?? 0) + 1;
        return $prefix . '/' . $date->format('Y') . '/' . str_pad((string) $this->counters[$key], 4, '0', STR_PAD_LEFT);
    }

    /** Tanggal acak, terurut, hanya hari kerja, jam kantor. */
    private function randomDates(int $n, Carbon $start, Carbon $end): array
    {
        $dates = [];
        $span = $end->getTimestamp() - $start->getTimestamp();
        while (count($dates) < $n) {
            $d = Carbon::createFromTimestamp($start->getTimestamp() + mt_rand(0, $span))->setTime(mt_rand(8, 16), mt_rand(0, 59));
            if (! $d->isWeekend() && $d->lessThan($end)) {
                $dates[] = $d;
            }
        }
        usort($dates, fn ($a, $b) => $a <=> $b);
        return $dates;
    }

    private function nama(): string
    {
        return $this->pick($this->namaDepan) . ' ' . $this->pick($this->namaBelakang);
    }

    private function email(string $nama): string
    {
        return strtolower(str_replace(' ', '.', $nama)) . mt_rand(1, 99) . '@example.com';
    }

    private function pick(array $items)
    {
        return $items[mt_rand(0, count($items) - 1)];
    }

    private function weighted(array $weights): string
    {
        $r = mt_rand(1, array_sum($weights));
        foreach ($weights as $key => $w) {
            if (($r -= $w) <= 0) {
                return $key;
            }
        }
        return array_key_first($weights);
    }
}
