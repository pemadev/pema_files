<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Agenda;
use App\Models\Business;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Partner;
use App\Models\ProfileContent;
use App\Models\Report;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Roles ───────────────────────────────────────
        if (!Role::where('name', 'super_admin')->exists()) {
            Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        }
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }

        // ─── Admin User ──────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@pema.co.id'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('super_admin');

        // ─── Profil Perusahaan ────────────────────────────
        ProfileContent::updateOrCreate(
            ['type' => 'sambutan'],
            [
                'title' => 'Mawardi Nur, SE',
                'content' => 'Direktur Utama PT PEMA',
                'image' => 'team/foto-direktur.png',
                'additional_info' => 'PT PEMA merupakan Perseroan Daerah (Perseroda) dengan saham 100% dimiliki Pemerintah Aceh. Mari kita terus maju, demi tujuan meningkatkan kesejahteraan serta kemandirian bagi masyarakat Aceh.',
            ]
        );

        ProfileContent::firstOrCreate(
            ['type' => 'sejarah'],
            [
                'title' => 'Perjalanan PT Pembangunan Aceh',
                'content' => '<p>PT Pembangunan Aceh (PEMA) didirikan pada tahun 2016 berdasarkan Qanun Aceh Nomor 3 Tahun 2015 tentang Perusahaan Daerah. Sebagai Badan Usaha Milik Daerah Aceh (BUMD/BUMA), PEMA memiliki tugas mulia: mengelola potensi sumber daya alam Aceh untuk sebesar-besarnya kemakmuran rakyat.</p><p>Sejak berdiri, PEMA telah berkembang dari perusahaan yang fokus pada sektor migas menjadi korporasi yang memiliki tiga pilar bisnis utama: Migas, Agroindustri, serta Jasa & Perdagangan. Perjalanan ini diwarnai dengan berbagai capaian dan pembelajaran yang menjadikan PEMA semakin kokoh sebagai penggerak ekonomi daerah.</p><p>Dengan saham 100% milik Pemerintah Aceh, PEMA berkomitmen untuk menjalankan tata kelola perusahaan yang baik (GCG) dan memberikan kontribusi nyata bagi pembangunan dan kesejahteraan masyarakat Aceh.</p>',
            ]
        );

        ProfileContent::firstOrCreate(
            ['type' => 'visi_misi'],
            [
                'title' => 'Menjadi perusahaan daerah yang profesional, inovatif, dan berkelanjutan untuk kesejahteraan masyarakat Aceh.',
                'content' => 'Mengelola sumber daya daerah secara optimal, mendorong pertumbuhan ekonomi, dan memberikan kontribusi nyata bagi pembangunan Aceh melalui pengelolaan bisnis yang profesional dan berintegritas.',
            ]
        );

        ProfileContent::firstOrCreate(
            ['type' => 'stakeholder'],
            [
                'title' => 'Pemangku Kepentingan PEMA',
                'content' => 'Sebagai BUMD milik Pemerintah Aceh, PEMA memiliki tanggung jawab kepada seluruh pemangku kepentingan, termasuk Pemerintah Aceh sebagai pemegang saham, masyarakat Aceh sebagai penerima manfaat, mitra bisnis, karyawan, dan regulator.',
            ]
        );

        // ─── Bidang Bisnis ────────────────────────────────
        $businesses = [
            ['category' => 'migas',        'title' => 'Alih Kelola Kerja Blok B',                          'description' => 'PEMA mengelola alih kelola kerja Blok B yang merupakan wilayah kerja migas strategis di Aceh. Pengelolaan dilakukan secara profesional dengan mengedepankan aspek keselamatan, lingkungan, dan kepatuhan terhadap regulasi.',                                                                        'tags' => ['Alih Kelola', 'Blok B', 'Migas Aceh', 'Hulu Migas'],                     'sort_order' => 1],
            ['category' => 'migas',        'title' => 'Perdagangan Komoditi Sulfur',                      'description' => 'PEMA bergerak dalam perdagangan komoditi sulfur yang merupakan hasil samping dari pengolahan migas. Komoditi ini memiliki nilai ekonomi tinggi dan permintaan yang stabil di pasar nasional maupun internasional.',                                            'tags' => ['Sulfur', 'Komoditi', 'Perdagangan'],                                    'sort_order' => 2],
            ['category' => 'agroindustri', 'title' => 'Perkebunan Kopi Arabika Gayo',                     'description' => 'PEMA mengembangkan perkebunan kopi Arabika Gayo yang telah dikenal sebagai salah satu kopi terbaik dunia. Dikelola dengan praktik pertanian berkelanjutan untuk menghasilkan biji kopi berkualitas premium.',                                                'tags' => ['Kopi Gayo', 'Arabika', 'Perkebunan', 'Ekspor'],                          'sort_order' => 1],
            ['category' => 'agroindustri', 'title' => 'Industri Perikanan Aceh',                          'description' => 'PEMA berinvestasi dalam industri perikanan berbasis potensi kelautan Aceh yang melimpah. Pengembangan dilakukan dari hulu ke hilir untuk menciptakan rantai nilai yang kuat dan berkelanjutan.',                                                              'tags' => ['Perikanan', 'Kelautan', 'Industri'],                                     'sort_order' => 2],
            ['category' => 'agroindustri', 'title' => 'Ekspor Cangkang Sawit',                            'description' => 'PEMA melakukan ekspor cangkang sawit (palm kernel shell) yang digunakan sebagai bahan bakar biomassa ramah lingkungan. Produk ini memiliki permintaan tinggi di pasar Jepang, Korea, dan Eropa.',                                                               'tags' => ['Cangkang Sawit', 'Biomassa', 'Ekspor'],                                  'sort_order' => 3],
            ['category' => 'jasa',         'title' => 'Kawasan Industri Aceh (KIA) Ladong',               'description' => 'PEMA mengelola Kawasan Industri Aceh (KIA) Ladong yang berlokasi strategis di Aceh Besar. Kawasan ini dikembangkan sebagai pusat industri terpadu yang ramah lingkungan dan berdaya saing global.',                                                            'tags' => ['KIA Ladong', 'Kawasan Industri', 'Investasi'],                           'sort_order' => 1],
            ['category' => 'jasa',         'title' => 'KEK Arun — Kawasan Ekonomi Khusus',               'description' => 'PEMA berperan dalam pengembangan Kawasan Ekonomi Khusus (KEK) Arun sebagai pusat pertumbuhan ekonomi baru di Aceh Utara. KEK Arun difokuskan pada sektor industri, energi, dan logistik.',                                                                     'tags' => ['KEK Arun', 'Kawasan Ekonomi', 'Industri'],                               'sort_order' => 2],
            ['category' => 'jasa',         'title' => 'Jaringan Telekomunikasi',                          'description' => 'PEMA menyediakan layanan infrastruktur telekomunikasi untuk mendukung konektivitas digital di berbagai wilayah Aceh, termasuk daerah terpencil yang belum terjangkau oleh operator utama.',                                                                    'tags' => ['Telekomunikasi', 'Infrastruktur', 'Digital'],                            'sort_order' => 3],
        ];
        foreach ($businesses as $b) {
            Business::updateOrCreate(
                ['category' => $b['category'], 'title' => $b['title']],
                $b
            );
        }

        // ─── Berita ──────────────────────────────────────
        News::firstOrCreate(
            ['type' => 'berita', 'title' => 'PEMA Tandatangani Kerjasama Pengembangan Blok B'],
            [
                'content' => '<p>PT Pembangunan Aceh (PEMA) resmi menandatangani perjanjian kerjasama pengembangan Blok B dengan mitra strategis nasional. Kerjasama ini bertujuan untuk mengoptimalkan potensi migas di wilayah Aceh melalui teknologi terkini dan praktik industri yang bertanggung jawab.</p><p>Penandatanganan dilakukan di Banda Aceh dan disaksikan oleh pejabat Pemerintah Aceh serta para pemangku kepentingan terkait. Direktur Utama PEMA menyatakan bahwa kerjasama ini merupakan langkah maju dalam mewujudkan kemandirian energi Aceh.</p>',
                'date' => '2026-03-15',
                'author' => 'Tim Humas PEMA',
                'is_published' => true,
            ]
        );
        News::firstOrCreate(
            ['type' => 'berita', 'title' => 'Kopi Gayo PEMA Tembus Pasar Eropa'],
            [
                'content' => '<p>Kopi Arabika Gayo yang dikembangkan oleh PT Pembangunan Aceh (PEMA) berhasil menembus pasar Eropa. Ekspor perdana dilakukan ke Belanda dan Jerman dengan volume 20 ton.</p><p>Keberhasilan ini menandai babak baru bagi pengembangan sektor agroindustri Aceh. Kopi Gayo dikenal memiliki cita rasa khas dengan acidity rendah dan body yang kuat, menjadikannya salah satu kopi terbaik di dunia.</p>',
                'date' => '2026-04-20',
                'author' => 'Tim Humas PEMA',
                'is_published' => true,
            ]
        );
        News::firstOrCreate(
            ['type' => 'berita', 'title' => 'PEMA Raih Penghargaan BUMD Terbaik 2026'],
            [
                'content' => '<p>PT Pembangunan Aceh (PEMA) meraih penghargaan sebagai Badan Usaha Milik Daerah (BUMD) Terbaik Tahun 2026 dalam acara Aceh Investment and Business Award yang diselenggarakan oleh Pemerintah Aceh.</p><p>Penghargaan ini diberikan atas kinerja keuangan yang solid, tata kelola perusahaan yang baik, serta kontribusi nyata terhadap pembangunan ekonomi Aceh. Penerimaan penghargaan diterima langsung oleh Direktur Utama PEMA di Banda Aceh.</p>',
                'date' => '2026-05-10',
                'author' => 'Tim Humas PEMA',
                'is_published' => true,
            ]
        );

        // ─── Pengumuman ──────────────────────────────────
        News::firstOrCreate(
            ['type' => 'pengumuman', 'title' => 'Pengumuman Seleksi Calon Mitra Kerja Sama Blok B'],
            [
                'content' => '<p>Sehubungan dengan pengembangan Blok B, PT Pembangunan Aceh (PEMA) membuka seleksi calon mitra kerjasama. Pendaftaran dibuka mulai tanggal 1 Juni hingga 30 Juni 2026.</p><p>Persyaratan lengkap dapat diunduh melalui website resmi PEMA. Informasi lebih lanjut dapat menghubungi Sekretariat PEMA di Banda Aceh.</p>',
                'date' => '2026-05-25',
                'author' => 'Sekretariat PEMA',
                'is_published' => true,
            ]
        );

        // ─── Agenda ──────────────────────────────────────
        Agenda::firstOrCreate(
            ['title' => 'Rapat Umum Pemegang Saham (RUPS) Tahunan 2026'],
            [
                'description' => 'RUPS Tahunan PT Pembangunan Aceh untuk membahas laporan tahunan, pengesahan laporan keuangan, dan penetapan penggunaan laba tahun buku 2025.',
                'date' => '2026-06-30',
                'location' => 'Banda Aceh',
                'is_published' => true,
            ]
        );
        Agenda::firstOrCreate(
            ['title' => 'Expo Investasi Aceh 2026'],
            [
                'description' => 'PEMA berpartisipasi dalam Expo Investasi Aceh untuk mempromosikan peluang investasi di sektor migas, agroindustri, dan kawasan industri.',
                'date' => '2026-08-15',
                'location' => 'Aceh Convention Center',
                'is_published' => true,
            ]
        );

        // ─── Galeri ──────────────────────────────────────
        Gallery::firstOrCreate(
            ['title' => 'Penandatanganan Kerjasama Blok B'],
            ['image' => 'gallery/kickoff.jpg', 'caption' => 'Penandatanganan perjanjian kerjasama pengembangan Blok B', 'sort_order' => 1]
        );
        Gallery::firstOrCreate(
            ['title' => 'Ekspor Kopi Gayo Perdana'],
            ['image' => 'gallery/kopi-ekspor.jpg', 'caption' => 'Pelepasan ekspor perdana kopi Gayo ke pasar Eropa', 'sort_order' => 2]
        );
        Gallery::firstOrCreate(
            ['title' => 'Penghargaan BUMD Terbaik'],
            ['image' => 'gallery/penghargaan.jpg', 'caption' => 'PEMA meraih penghargaan BUMD Terbaik 2026', 'sort_order' => 3]
        );

        // ─── Tim ─────────────────────────────────────────
        $teamMembers = [
            ['name' => 'Dr. Teuku Muhammad Fadhil, SE, MM',     'position' => 'Direktur Utama',              'category' => 'direksi',   'sort_order' => 1, 'photo' => 'team/team-1.jpg'],
            ['name' => 'Ir. Cut Nuraida, MT',                   'position' => 'Direktur Operasional',        'category' => 'direksi',   'sort_order' => 2, 'photo' => 'team/team-2.jpg'],
            ['name' => 'M. Ali Basyah, S.H., M.Kn.',            'position' => 'Direktur Keuangan',           'category' => 'direksi',   'sort_order' => 3, 'photo' => 'team/team-3.jpg'],
            ['name' => 'Ir. Teuku Reza Fahlevi, ST, MT',        'position' => 'Direktur Teknik & Operasional','category' => 'direksi',   'sort_order' => 4, 'photo' => 'team/team-4.jpg'],
            ['name' => 'Prof. Dr. Ir. Syamsul Rizal, M.Eng.',   'position' => 'Komisaris Utama',             'category' => 'komisaris', 'sort_order' => 1, 'photo' => 'team/team-5.jpg'],
            ['name' => 'Dra. Hj. Nurlelawati, M.Si.',           'position' => 'Komisaris',                   'category' => 'komisaris', 'sort_order' => 2, 'photo' => 'team/team-6.jpg'],
            ['name' => 'Dr. Ir. Zulkifli, M.Si.',               'position' => 'Komisaris Independen',        'category' => 'komisaris', 'sort_order' => 3, 'photo' => 'team/team-7.jpg'],
            ['name' => 'H. Muhammad Yunus, SE, Ak., MBA',       'position' => 'Komisaris',                   'category' => 'komisaris', 'sort_order' => 4, 'photo' => 'team/team-8.jpg'],
        ];
        foreach ($teamMembers as $member) {
            Team::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }
        Team::firstOrCreate(
            ['name' => 'Ir. Cut Nuraida, MT'],
            ['position' => 'Direktur Operasional', 'category' => 'direksi', 'sort_order' => 2]
        );
        Team::firstOrCreate(
            ['name' => 'M. Ali Basyah, S.H., M.Kn.'],
            ['position' => 'Direktur Keuangan', 'category' => 'direksi', 'sort_order' => 3]
        );
        Team::firstOrCreate(
            ['name' => 'Ir. Teuku Reza Fahlevi, ST, MT'],
            ['position' => 'Direktur Teknik & Operasional', 'category' => 'direksi', 'sort_order' => 4]
        );
        Team::firstOrCreate(
            ['name' => 'Prof. Dr. Ir. Syamsul Rizal, M.Eng.'],
            ['position' => 'Komisaris Utama', 'category' => 'komisaris', 'sort_order' => 1]
        );
        Team::firstOrCreate(
            ['name' => 'Dra. Hj. Nurlelawati, M.Si.'],
            ['position' => 'Komisaris', 'category' => 'komisaris', 'sort_order' => 2]
        );
        Team::firstOrCreate(
            ['name' => 'Dr. Ir. Zulkifli, M.Si.'],
            ['position' => 'Komisaris', 'category' => 'komisaris', 'sort_order' => 3]
        );
        Team::firstOrCreate(
            ['name' => 'H. Muhammad Yunus, SE, Ak., MBA'],
            ['position' => 'Komisaris', 'category' => 'komisaris', 'sort_order' => 4]
        );

        // ─── Mitra ───────────────────────────────────────
        // Hapus data partner lama
        \App\Models\Partner::query()->forceDelete();
        $partners = [
            ['name' => 'PT Pupuk Iskandar Muda',     'website' => 'https://pim.co.id',         'sort_order' => 1, 'logo' => 'partners/pupuk-iskandar-muda.gif'],
            ['name' => 'CHL',                        'website' => null,                        'sort_order' => 2, 'logo' => 'partners/chl.webp'],
            ['name' => 'Koperasi Karyawan PEMA Syariah', 'website' => null,                    'sort_order' => 3, 'logo' => 'partners/koperasi-karyawan-pema-syariah.webp'],
            ['name' => 'Cemindo Sari Gemilang',      'website' => null,                        'sort_order' => 4, 'logo' => 'partners/cemindo-sari-gemilang.webp'],
            ['name' => 'Mitra Strategis PEMA',       'website' => null,                        'sort_order' => 5, 'logo' => 'partners/3.webp'],
        ];
        foreach ($partners as $p) {
            Partner::updateOrCreate(['name' => $p['name']], $p);
        }

        // ─── Laporan ─────────────────────────────────────
        Report::firstOrCreate(
            ['title' => 'Laporan Tahunan 2025'],
            ['year' => '2025', 'description' => 'Laporan tahunan PT Pembangunan Aceh tahun buku 2025 mencakup kinerja keuangan, operasional, dan tata kelola perusahaan.', 'is_published' => true]
        );
        Report::firstOrCreate(
            ['title' => 'Laporan Keberlanjutan 2025'],
            ['year' => '2025', 'description' => 'Laporan keberlanjutan yang menguraikan komitmen PEMA terhadap aspek lingkungan, sosial, dan tata kelola (ESG).', 'is_published' => true]
        );
        Report::firstOrCreate(
            ['title' => 'Laporan Kinerja Semester I 2026'],
            ['year' => '2026', 'description' => 'Laporan kinerja semester pertama tahun 2026 yang mencakup pencapaian target dan realisasi program kerja.', 'is_published' => true]
        );

        // ─── Enquiries (dummy) ────────────────────────────
        $enquiries = [
            ['name' => 'Ahmad Fauzi',     'email' => 'ahmad.fauzi@email.com',     'phone' => '0812-3456-7890', 'subject' => 'Informasi Kerja Sama Blok B',     'message' => 'Selamat siang, saya ingin mendapatkan informasi lebih lanjut mengenai peluang kerjasama pengembangan Blok B. Apakah ada persyaratan khusus untuk menjadi mitra? Terima kasih.', 'is_read' => false],
            ['name' => 'Siti Rahmawati',  'email' => 'siti.r@company.co.id',      'phone' => '0852-1111-2222', 'subject' => 'Penawaran Jasa Konsultan',       'message' => 'Kami adalah perusahaan konsultan yang bergerak di bidang energi dan pertambangan. Tertarik untuk menawarkan jasa konsultan teknis untuk proyek pengembangan migas PEMA. Mohon info kontak PIC terkait.', 'is_read' => false],
            ['name' => 'Budi Santoso',    'email' => 'budi.santoso@gmail.com',    'phone' => '0877-8888-9999', 'subject' => 'Lowongan Kerja',               'message' => 'Halo, saya tertarik dengan lowongan kerja di PT PEMA. Apakah saat ini ada posisi yang tersedia untuk lulusan teknik industri? Mohon infonya. Terima kasih.', 'is_read' => false],
            ['name' => 'Cut Mutia',       'email' => 'cut.mutia@aceh.ac.id',      'phone' => '0811-6666-3333', 'subject' => 'Penelitian Akademik',          'message' => 'Dengan hormat, saya mahasiswa S2 Teknik Sipil Unsyiah yang sedang melakukan penelitian tentang dampak ekonomi kawasan industri. Mohon izin untuk mendapatkan data sekunder terkait KIA Ladong.', 'is_read' => true],
            ['name' => 'Teuku Irfan',     'email' => 'teuku.irfan@yahoo.com',     'phone' => '0853-7777-4444', 'subject' => 'Proposal Investasi',           'message' => 'Kami dari konsorsium investor asing tertarik untuk berinvestasi di sektor agroindustri Aceh. Mohon informasi lebih lanjut mengenai proyek perkebunan kopi PEMA.', 'is_read' => true],
        ];
        foreach ($enquiries as $e) {
            \App\Models\Enquiry::firstOrCreate(
                ['email' => $e['email'], 'subject' => $e['subject']],
                $e
            );
        }
    }
}
