# YANKOMAS
## Sistem Informasi Pelayanan Saran, Informasi, dan Pengaduan Internal & Eksternal

Aplikasi web terpadu untuk mencatat, mengelola, dan melacak saran, informasi, serta pengaduan dari masyarakat pada Kantor Imigrasi Kelas I TPI Kota Bandung.

Sistem ini terbagi menjadi dua bagian utama:
1. **Sistem Eksternal (Publik):** Halaman *Landing Page* modern (*Glassmorphism*) bagi masyarakat untuk mengisi form pengaduan mandiri secara *online* dan mengecek status laporan mereka bermodalkan Nomor Tiket.
2. **Sistem Internal (Admin/Petugas):** Dashboard manajemen tiket bergaya formal untuk merespons, merekap, dan mengalokasikan laporan dari publik maupun *walk-in*.

---

### Fitur Utama Baru (Update Terbaru)
- 🚀 **Public Landing Page (Glassmorphism):** Halaman depan modern yang sepenuhnya terpisah dari sistem internal, dilengkapi efek blur/transparan dan desain premium.
- 🎟️ **Sistem Tiket Otomatis:** Setiap pelapor dari masyarakat otomatis mendapatkan Nomor Tiket (cth: `ASP-20260718-0005`) yang bisa digunakan untuk melacak status laporan (Fitur Cek Status).
- 🧠 **Smart LocalStorage Memory:** Saat masyarakat selesai melapor, *browser* mereka akan otomatis menyimpan nomor tiket tersebut, sehingga mereka tidak perlu mengetik ulang saat ingin "Cek Status".
- 🙋‍♂️ **Shared Pool & Claim System (Ambil Alih):** Laporan baru dari masyarakat akan masuk ke kolam "Data Masyarakat". Semua petugas bisa melihatnya dan berlomba mengambil alih (*Claim/Assign*) laporan tersebut untuk segera diproses.
- 🔔 **Auto-Update & Real-Time Notification:** Menggunakan teknologi *AJAX Polling*, Admin/Petugas akan otomatis mendapatkan notifikasi *Toast* setiap ada laporan baru yang masuk tanpa perlu memuat ulang halaman.
- 🧹 **Mass Delete (Bersihkan Data):** Super Admin memiliki akses tombol khusus (dengan sistem pengamanan *cooldown* 5 detik) untuk menghapus massal semua tiket yang sudah berstatus 'Selesai'.

### Fitur *Core* (Inti)
- ✅ **Multi-Role Authentication** (Super Admin, Admin & Petugas)
- ✅ CRUD Data Aspirasi dengan nomor tiket otomatis
- ✅ Dashboard interaktif dengan grafik analitik (Chart.js)
- ✅ Filter data dinamis (Berdasarkan periode, jenis, status, "Data Saya", "Data Masyarakat")
- ✅ Export laporan komprehensif ke Excel dan PDF (DomPDF & Laravel Excel)
- ✅ Input kustom (Lainnya) untuk jenis, kategori, dan layanan di luar standar
- ✅ Manajemen akun Petugas & Admin (Khusus Super Admin)
- ✅ Activity log (Jejak rekam/audit) untuk melacak seluruh aktivitas pengguna
- ✅ Profil mandiri pengguna (Ubah password, nama, dan foto profil)

---

### Persyaratan Sistem
| Komponen    | Versi Minimum       |
|-------------|---------------------|
| PHP         | 8.2+                |
| Composer    | 2.x                 |
| MySQL       | 5.7+ / MariaDB 10.3+|

---

### Instalasi Cepat (Setup untuk Server/Imigrasi)

#### 1. Masuk ke Folder Proyek
```bash
cd yankomas
```

#### 2. Install Dependencies PHP
```bash
composer install
```

#### 3. Konfigurasi Environment (File .env)
```bash
cp .env.example .env
```
Buka file `.env`, lalu sesuaikan konfigurasi database Anda (secara default sudah disiapkan `yankomas`):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yankomas
DB_USERNAME=root
DB_PASSWORD=
```

#### 4. Buat Database Kosong
Buat database bernama `yankomas` secara manual melalui aplikasi seperti phpMyAdmin, Laragon, atau HeidiSQL.

#### 5. Generate Key & Link Storage
```bash
php artisan key:generate
php artisan storage:link
```

#### 6. Migrasi & Data Master (Seeder)
Jalankan perintah ini untuk membangun 4 tabel utama yang rapi dan mengisi 1 akun akses pertama:
```bash
php artisan migrate --seed
```

#### 7. Jalankan Aplikasi (Jika di Localhost)
```bash
php artisan serve
```
Aplikasi kini dapat diakses di browser melalui URL: **`http://localhost:8000`**

---

### Akun Login Akses Pertama (Default)
> ⚠️ **Sistem ini dirancang murni tanpa data dummy/kotoran.**

Saat pertama kali diinstal, sistem hanya akan membangkitkan **1 Akun Pintu Masuk** untuk memudahkan persiapan pihak instansi:

| Role          | Username      | Password        | Akses Utama                                          |
|---------------|---------------|-----------------|------------------------------------------------------|
| **Super Admin**| `superadmin`  | `password123`   | Manajemen penuh (Tambah Petugas, Hapus Massal, Log)  |

*Catatan: Segera login menggunakan akun ini, tambahkan akun petugas asli Imigrasi di menu "Kelola User", dan ubah password Super Admin di menu Profil demi keamanan.*

---

### Daftar *Route* Penting

| Route Path                         | Fungsi / Deskripsi                                  | Hak Akses       |
|------------------------------------|---------------------------------------------------|-----------------|
| `/`                                | Landing Page (Formulir Masyarakat & Cek Status)     | Publik          |
| `/login`                           | Halaman Autentikasi untuk Internal                  | Publik          |
| `/dashboard`                       | Ringkasan statistik tiket dan aktivitas             | Auth            |
| `/aspirasi`                        | Daftar laporan (Data Saya & Semua Data)             | Auth            |
| `/aspirasi/{id}/claim`             | Tombol "Ambil Alih Laporan" untuk tiket baru        | Petugas         |
| `/aspirasi/export/pdf`             | Unduh rekap laporan dalam bentuk PDF                | Auth            |
| `/admin/users`                     | Halaman manajemen akun Petugas & Admin              | Super Admin     |
| `/admin/aspirasi/destroy-all`      | Hapus massal tiket yang sudah selesai               | Super Admin     |

---

### Tech Stack / Teknologi yang Digunakan
- **Backend:** Laravel 12 (PHP 8.3+)
- **Frontend Publik:** Vanilla HTML/CSS, Glassmorphism UI, SweetAlert2, Flatpickr
- **Frontend Internal:** Bootstrap 5, AdminLTE 3 (CDN Based)
- **Database:** MySQL / MariaDB
- **Visualisasi & Export:** Chart.js 4, Maatwebsite/Excel, Barryvdh/DomPDF

---

### Troubleshooting Umum

- ❌ **The stream or file ... could not be opened:**
  Anda lupa membuat jembatan ke folder foto. Jalankan `php artisan storage:link`.
- ❌ **Target class [AdminController] does not exist:**
  Coba jalankan `composer dump-autoload`.
- ❌ **SQLSTATE[HY000] [1049] Unknown database 'yankomas':**
  Anda belum membuat *database* kosong bernama `yankomas` di phpMyAdmin Anda.

---
**Hak Cipta © 2026 - Kantor Imigrasi Kelas I TPI Kota Bandung**
