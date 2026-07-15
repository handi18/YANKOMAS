# YANKOMAS
## Sistem Informasi Pelayanan Saran, Informasi, dan Pengaduan Internal

Aplikasi web untuk mencatat dan mengelola saran, informasi, dan pengaduan dari masyarakat di Kantor Imigrasi Kelas I TPI Kota Bandung.

---

### Fitur Utama

- ✅ Authentication & Authorization (Super Admin, Admin & Petugas)
- ✅ CRUD Data Aspirasi dengan nomor tiket otomatis (`ASP-YYYYMMDD-XXXX`)
- ✅ Dashboard interaktif dengan grafik (Chart.js)
- ✅ Filter data berdasarkan periode, jenis, kategori, status, dan layanan
- ✅ Export laporan ke Excel dan PDF
- ✅ Input kustom untuk jenis, kategori, dan layanan di luar standar
- ✅ Kelola user/petugas (Admin only)
- ✅ Activity log untuk audit trail
- ✅ Profil mandiri (edit data & foto)
- ✅ Responsive design dengan Bootstrap 5 & AdminLTE

---

### Persyaratan Sistem

| Komponen    | Versi Minimum       |
|-------------|---------------------|
| PHP         | 8.2+                |
| Composer    | 2.x                 |
| MySQL       | 5.7+ / MariaDB 10.3+ |
| Node.js     | 18+ (opsional)      |

---

### Instalasi (Step-by-Step)

#### 1. Clone Repository

```bash
git clone <url-repository-anda> yankomas
cd yankomas
```

#### 2. Install Dependencies PHP

```bash
composer install
```

#### 3. Salin File Environment

```bash
cp .env.example .env
```

#### 4. Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yankomas_db
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Buat Database

Buat database secara manual melalui terminal MySQL atau phpMyAdmin:

```sql
CREATE DATABASE yankomas_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 6. Generate Application Key

```bash
php artisan key:generate
```

#### 7. Jalankan Migrasi Database

```bash
php artisan migrate
```

#### 8. Jalankan Seeder (Data Awal)

```bash
php artisan db:seed
```

Seeder akan membuat:
- 1 Akun Admin (`admin` / `password123`)
- 3 Akun Petugas (lihat tabel di bawah)
- 4 Data Layanan Keimigrasian

#### 9. Buat Symbolic Link untuk Storage

```bash
php artisan storage:link
```

#### 10. Jalankan Server

```bash
php artisan serve
```

Akses di browser: **http://localhost:8000**

---

### Akun Login Default

> ⚠️ **Semua akun menggunakan password: `password123`**

| Role     | Username          | Nama                |
|----------|-------------------|---------------------|
| Admin    | `admin`           | Administrator Utama |
| Petugas  | `handi_petugas`   | Handi (Petugas)     |
| Petugas  | `doni_petugas`    | Doni (Petugas)      |
| Petugas  | `okta_petugas`    | Okta (Petugas)      |

---

### Data Layanan Default

| No | Nama Layanan       |
|----|--------------------|
| 1  | Paspor Baru        |
| 2  | Paspor Penggantian |
| 3  | Izin Tinggal       |
| 4  | BAP                |

---

### Struktur Project

```
yankomas/
├── app/
│   ├── Exports/                # Export Excel (Maatwebsite)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── AspirasiController.php
│   │   │   ├── AdminController.php
│   │   │   └── ReportController.php
│   │   └── Middleware/
│   │       └── Role.php        # Middleware otorisasi role
│   └── Models/
│       ├── User.php
│       ├── Aspirasi.php
│       ├── Layanan.php
│       └── ActivityLog.php
├── database/
│   ├── migrations/             # Skema tabel database
│   ├── seeders/                # Data awal (user, layanan)
│   └── factories/              # Factory untuk testing
├── resources/views/
│   ├── auth/                   # Halaman login
│   ├── layouts/                # Template utama (AdminLTE)
│   ├── dashboard/              # Halaman dashboard & grafik
│   ├── aspirasi/               # Halaman CRUD aspirasi
│   ├── admin/                  # Halaman kelola user & log
│   └── reports/                # Template cetak PDF
├── routes/
│   └── web.php                 # Definisi semua route
├── public/                     # Asset publik (gambar, CSS, JS)
├── .env.example                # Template konfigurasi environment
├── composer.json               # Dependencies PHP
└── package.json                # Dependencies JavaScript
```

---

### Skema Database

#### Tabel: `users`
Menyimpan data pengguna (Super Admin, Admin & Petugas).
- `role`: enum (`super_admin`, `admin`, `petugas`)
- `nip`: Nomor Induk Pegawai (unik)
- `foto`: Path foto profil (nullable)

#### Tabel: `layanan`
Data master jenis layanan keimigrasian.

#### Tabel: `aspirasi`
Tabel transaksi utama untuk saran, informasi, dan pengaduan.
- `nomor_tiket`: Auto-generate format `ASP-YYYYMMDD-XXXX`
- `jenis`: `saran`, `informasi`, `pengaduan`
- `kategori`: `ringan`, `sedang`, `berat` (khusus pengaduan)
- `status`: `Baru`, `Diproses`, `Selesai`
- `layanan_id`: Nullable (mendukung input layanan kustom)
- Kolom kustom: `jenis_custom`, `kategori_custom`, `layanan_custom`

#### Tabel: `activity_logs`
Audit trail untuk tracking seluruh aktivitas pengguna.

---

### Daftar Route

| Method | Route                              | Deskripsi             | Akses           |
|--------|------------------------------------|-----------------------|-----------------|
| GET    | `/`                                | Halaman login         | Public          |
| POST   | `/login`                           | Proses autentikasi    | Public          |
| POST   | `/logout`                          | Logout                | Auth            |
| GET    | `/dashboard`                       | Dashboard             | Auth            |
| GET    | `/profile`                         | Edit profil           | Auth            |
| PUT    | `/profile`                         | Simpan profil         | Auth            |
| DELETE | `/profile/foto`                    | Hapus foto profil     | Auth            |
| GET    | `/aspirasi`                        | Daftar aspirasi       | Auth            |
| GET    | `/aspirasi/create`                 | Form tambah aspirasi  | Auth            |
| POST   | `/aspirasi`                        | Simpan aspirasi       | Auth            |
| GET    | `/aspirasi/{id}`                   | Detail aspirasi       | Auth            |
| GET    | `/aspirasi/{id}/edit`              | Form edit aspirasi    | Auth            |
| PUT    | `/aspirasi/{id}`                   | Update aspirasi       | Auth            |
| DELETE | `/aspirasi/{id}`                   | Hapus aspirasi        | Auth            |
| POST   | `/aspirasi/{id}/update-status`     | Ubah status           | Auth            |
| GET    | `/aspirasi/export/excel`           | Export Excel          | Auth            |
| GET    | `/aspirasi/export/pdf`             | Export PDF            | Auth            |
| GET    | `/admin/users`                     | Daftar petugas        | Admin           |
| GET    | `/admin/users/create`              | Form tambah petugas   | Admin           |
| POST   | `/admin/users`                     | Simpan petugas        | Admin           |
| GET    | `/admin/users/{id}/edit`           | Form edit petugas     | Admin           |
| PUT    | `/admin/users/{id}`                | Update petugas        | Admin           |
| DELETE | `/admin/users/{id}`                | Hapus petugas         | Admin           |
| POST   | `/admin/users/{id}/reset-password` | Reset password        | Admin           |
| GET    | `/admin/activity-logs`             | Log aktivitas         | Admin           |

---

### Tech Stack

| Layer     | Teknologi                          |
|-----------|------------------------------------|
| Backend   | Laravel 12 (PHP 8.3+)             |
| Frontend  | Blade + Bootstrap 5 + AdminLTE 3   |
| Database  | MySQL / MariaDB                    |
| Grafik    | Chart.js 4                         |
| Export    | Maatwebsite/Excel, Barryvdh/DomPDF |
| Bundler   | Vite 5                             |

---

### Troubleshooting

#### ❌ Error: SQLSTATE[HY000] [1045] Access denied
Database connection error. Pastikan:
- Database `yankomas_db` sudah dibuat
- Username & password di `.env` sudah benar
- MySQL/MariaDB sudah berjalan

#### ❌ Error: PDOException: could not find driver
Extension `pdo_mysql` belum aktif di PHP. Aktifkan di `php.ini`:
```ini
extension=pdo_mysql
```

#### ❌ Error: The key must be 32 characters
Jalankan:
```bash
php artisan key:generate
```

#### ❌ Error: The stream or file ... could not be opened
Permission issue pada folder `storage`. Jalankan:
```bash
php artisan storage:link
```

---

### License

MIT License

