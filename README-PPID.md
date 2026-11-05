# Modul Dashboard PPID – PT PEMA

Salin seluruh isi folder ini ke root proyek Laravel (`pema_files/`), menimpa file yang sama.

## File baru
- database/migrations/2026_11_02_000001_create_ppid_tables.php  (tabel ppid_permohonan, ppid_pengaduan, ppid_keberatan)
- database/seeders/PpidSeeder.php  (data contoh, opsional)
- app/Models/PpidPermohonan.php, PpidPengaduan.php, PpidKeberatan.php, Concerns/HasPpidRecord.php
- app/Http/Controllers/Ppid/PpidRecordController.php, PermohonanController.php, PengaduanController.php, KeberatanController.php
- resources/views/ppid/** (dashboard, daftar, detail, partial)

## File yang diubah
- app/Http/Controllers/Ppid/DashboardController.php  (dashboard berisi data asli)
- app/Helpers/MenuHelper.php  (menu sidebar: Jumlah Pemohon, Pengaduan, Keberatan)
- routes/web.php  (rute PPID sekarang wajib login admin; alamat lama dialihkan)
- resources/views/admin-panel/layouts/app.blade.php, app-header.blade.php  (perbaikan namespace komponen x-admin::)
- resources/views/admin-panel/layouts/sidebar.blade.php  (menu tetap aktif di halaman detail)
- resources/views/admin-panel/components/header/user-dropdown.blade.php  (nama user login + tombol Keluar)

## Pemasangan
    php artisan migrate
    php artisan db:seed --class=PpidSeeder   # opsional, hanya untuk data contoh
    npm run build                             # wajib: mengompilasi class Tailwind yang baru
    php artisan optimize:clear

## Alamat
- /dashboard            Dashboard PPID
- /ppid/pemohon         Jumlah pemohon (permohonan informasi)
- /ppid/pengaduan       Pengaduan
- /ppid/keberatan       Keberatan
Semua halaman memakai login admin yang sama (/admin/login).
