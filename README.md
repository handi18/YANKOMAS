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

### Fitur *Core* (Inti)
- ✅ **Multi-Role Authentication** (Super Admin, Admin & Petugas)
- ✅ CRUD Data Aspirasi dengan nomor tiket otomatis
- ✅ Dashboard interaktif dengan grafik analitik (Chart.js)
- ✅ Filter data dinamis (Berdasarkan periode, jenis, status, "Data Saya", "Data Masyarakat")
- ✅ Export laporan komprehensif ke Excel dan PDF (DomPDF & Laravel Excel)
- ✅ Input kustom (Lainnya) untuk jenis, kategori, dan layanan di luar standar
- ✅ Manajemen akun Petugas & Super Admin (Khusus Admin)
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

### Instalasi Cepat (Bisa untuk Clone)

#### 1. Clone Repository & Masuk ke Folder
```bash
git clone <url-repository-anda> yankomas
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
Buka file `.env`, lalu sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yankomas_db
DB_USERNAME=root
DB_PASSWORD=
```

#### 4. Buat Database Kosong
Buat database bernama `yankomas_db` secara manual melalui aplikasi seperti phpMyAdmin, Laragon, atau HeidiSQL.

#### 5. Generate Key & Link Storage
```bash
php artisan key:generate
php artisan storage:link
```

#### 6. Migrasi & Data Dummy (Seeder)
Jalankan perintah ini untuk membangun tabel dan mengisi data awal (akun Admin & Petugas):
```bash
php artisan migrate --seed
```

#### 7. Jalankan Aplikasi
```bash
php artisan serve
```
Aplikasi kini dapat diakses di browser melalui URL: **`http://localhost:8000`**

---

### Akun Login Default
> ⚠️ **Semua akun menggunakan password bawaan: `password123`**

| Role     | Username          | Akses/Fungsi Utama                            |
|----------|-------------------|---------------------------------------------|
| Admin    | `admin`           | Kelola Petugas, Log Aktivitas, Hapus Tiket |
| Petugas  | `handi_petugas`   | Menjawab tiket, Claim laporan masyarakat   |
| Petugas  | `doni_petugas`    | Menjawab tiket, Claim laporan masyarakat   |

*Catatan: Akses login internal ada di URL `/login`. Tidak ada lagi tombol login di halaman utama/publik untuk menjaga privasi sistem.*

---

### Daftar *Route* Penting

| Route Path                         | Fungsi / Deskripsi                                  | Hak Akses       |
|------------------------------------|---------------------------------------------------|-----------------|
| `/`                                | Landing Page (Formulir Masyarakat & Cek Status)     | Publik          |
| `/lapor`                           | Memproses pengiriman formulir dari masyarakat       | Publik          |
| `/login`                           | Halaman Autentikasi untuk Internal (Petugas/Admin)  | Publik          |
| `/dashboard`                       | Ringkasan statistik tiket dan aktivitas             | Auth            |
| `/aspirasi`                        | Daftar laporan (Data Saya & Semua Data)             | Auth            |
| `/aspirasi/{id}/claim`             | Tombol "Ambil Alih Laporan" untuk tiket baru        | Petugas         |
| `/aspirasi/export/pdf`             | Unduh rekap laporan dalam bentuk PDF                | Auth            |
| `/admin/users`                     | Halaman manajemen akun Petugas & Admin              | Admin           |

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
- ❌ **SQLSTATE[HY000] [2002] Target machine actively refused it:**
  Aplikasi database Anda (seperti XAMPP/Laragon) belum dinyalakan atau MySQL dalam kondisi *Stop*.

---
**Hak Cipta © 2026 - Kantor Imigrasi Kelas I TPI Kota Bandung**
