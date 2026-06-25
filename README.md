# SIMASPIRASI IMIGRASI
## Sistem Informasi Saran, Masukan, dan Pengaduan Internal

Aplikasi web fullstack untuk mencatat dan mengelola saran, masukan, dan pengaduan dari masyarakat di Kantor Imigrasi Kelas I TPI Kota Bandung.

### Fitur Utama

- ✅ Authentication & Authorization (Admin & Petugas)
- ✅ CRUD Data Aspirasi dengan nomor tiket otomatis
- ✅ Dashboard interaktif dengan Chart.js
- ✅ Filter data berdasarkan periode, jenis, kategori, status, layanan
- ✅ Export Excel dan PDF
- ✅ Kelola user/petugas (Admin only)
- ✅ Activity log untuk audit trail
- ✅ Responsive design dengan Bootstrap 5 & AdminLTE

### Persyaratan Sistem

- PHP 8.2+
- Composer
- MySQL 5.7+ atau MariaDB 10.3+
- Node.js (opsional, untuk development)

### Instalasi

#### 1. Clone / Extract Project

```bash
cd d:\kuliah\Magang\projek magang\simaspirasi-imigrasi
```

#### 2. Install Dependencies

```bash
composer install
```

#### 3. Copy dan Konfigurasi .env

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simaspirasi_imigrasi
DB_USERNAME=root
DB_PASSWORD=
APP_KEY=base64:4ktLQB1pjNmOKxcMa7qC6C/hR5j2F9T+2qW8pV5sX/0=
```

#### 4. Generate Application Key (jika belum)

```bash
php artisan key:generate
```

#### 5. Buat Database

```bash
# MySQL Command
CREATE DATABASE simaspirasi_imigrasi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 6. Run Migration

```bash
php artisan migrate
```

#### 7. Run Seeder

```bash
php artisan db:seed
```

Ini akan membuat:
- 1 Admin default (admin/password)
- 5 Petugas dengan nama/NIP spesifik
- 10 Petugas dummy
- 5 Layanan
- 50 Data aspirasi dummy

#### 8. Create Storage Link

```bash
php artisan storage:link
```

### Menjalankan Aplikasi

#### Development Server

```bash
php artisan serve
```

Akses di: `http://localhost:8000`

#### Production

Untuk production, gunakan web server seperti Nginx atau Apache.

### User Login Default

**Admin:**
- Username: `admin`
- Password: `password`

**Petugas:**
- Username: `budi.santoso`
- Password: `password`

Atau username petugas lainnya: `siti.nurhaliza`, `ahmad.wijaya`, `rini.kusuma`, `eka.prasetya` (semua dengan password: `password`)

### Struktur Project

```
simaspirasi-imigrasi/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # All controllers
│   │   ├── Middleware/         # Role middleware
│   │   └── Requests/           # Request validation
│   ├── Models/                 # Eloquent models
│   └── Exports/                # Excel export
├── config/                     # Configuration files
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
├── resources/
│   └── views/
│       ├── auth/               # Login view
│       ├── layouts/            # Main layout
│       ├── dashboard/          # Dashboard
│       ├── aspirasi/           # Aspirasi CRUD views
│       ├── admin/              # Admin views
│       └── reports/            # Export views
├── routes/
│   └── web.php                 # Web routes
├── public/                     # Public assets
├── storage/                    # Application storage
├── .env.example                # Environment template
├── composer.json               # PHP dependencies
└── README.md                   # Documentation

```

### Penjelasan Database

#### Tabel: users
Menyimpan data user (admin & petugas)
- role: enum (admin, petugas)
- NIP: Nomor Induk Pegawai (unik)

#### Tabel: layanan
Menyimpan data jenis layanan:
- Paspor Baru
- Paspor Penggantian
- Izin Tinggal
- WNA
- Informasi

#### Tabel: aspirasi
Menyimpan data saran, masukan, dan pengaduan
- nomor_tiket: Auto-generate format ASP-YYYYMMDD-XXXX
- jenis: saran, masukan, pengaduan
- kategori: ringan, sedang, berat
- status: Baru, Diproses, Selesai

#### Tabel: activity_logs
Audit trail untuk tracking aktivitas pengguna
- Login, logout
- Tambah/ubah/hapus data
- Export laporan

### Fitur Utama

#### 1. Dashboard

Menampilkan statistik dan grafik:
- Ringkasan aspirasi (hari ini, minggu ini, bulan ini, tahun ini)
- Pie chart jenis aspirasi (Saran, Masukan, Pengaduan)
- Bar chart kategori (Ringan, Sedang, Berat)
- Line chart tren aspirasi per hari
- Bar chart top 5 layanan
- Status breakdown

#### 2. Data Aspirasi

- Daftar semua aspirasi dengan pagination
- Filter: periode, jenis, kategori, status, layanan, pencarian
- Tambah, lihat, edit, hapus aspirasi
- Ubah status (admin only)
- Export Excel dan PDF dengan filter aktif

#### 3. Kelola Petugas (Admin Only)

- Daftar semua petugas
- Tambah petugas baru
- Edit data petugas
- Reset password petugas
- Hapus petugas

#### 4. Activity Log (Admin Only)

- Tampilkan semua aktivitas pengguna
- Filter berdasarkan user dan keyword aktivitas
- Tracking login, logout, CRUD data

### Export Laporan

#### Excel
- Menggunakan Laravel Excel (Maatwebsite)
- Format: Nomor Tiket, Tanggal, Jam, Jenis, Kategori, Isi, Layanan, Media, Status, Petugas
- Mengikuti filter aktif

#### PDF
- Menggunakan DomPDF (Barryvdh)
- Include: Header kantor, filter info, ringkasan statistik, tabel data, footer dengan nama pencetak

### API Route Summary

| Method | Route | Description |
|--------|-------|-------------|
| GET | / | Login page |
| POST | /login | Authenticate user |
| POST | /logout | Logout user |
| GET | /dashboard | Dashboard |
| GET | /aspirasi | List aspirasi |
| GET | /aspirasi/create | Create form |
| POST | /aspirasi | Store aspirasi |
| GET | /aspirasi/{id} | Show detail |
| GET | /aspirasi/{id}/edit | Edit form |
| PUT | /aspirasi/{id} | Update aspirasi |
| DELETE | /aspirasi/{id} | Delete aspirasi |
| POST | /aspirasi/{id}/update-status | Update status |
| GET | /aspirasi/export/excel | Export Excel |
| GET | /aspirasi/export/pdf | Export PDF |
| GET | /admin/users | List petugas |
| POST | /admin/users | Store petugas |
| PUT | /admin/users/{id} | Update petugas |
| DELETE | /admin/users/{id} | Delete petugas |
| POST | /admin/users/{id}/reset-password | Reset password |
| GET | /admin/activity-logs | Activity log |

### Troubleshooting

#### Error: SQLSTATE[HY000] [1045] Access denied

Database connection error. Pastikan:
- Database sudah dibuat
- Username & password .env benar
- MySQL/MariaDB running

#### Error: PDOException: could not find driver

PHP MySQL extension belum terinstall. Install:

```bash
# Windows (dengan XAMPP/WAMP)
# Enable extension=pdo_mysql di php.ini
```

#### Error: The key must be 32 characters when using AES-256-CBC encryption

Jalankan:
```bash
php artisan key:generate
```

### Support & Contact

Untuk pertanyaan atau issue, silakan hubungi tim development.

### License

MIT License

### Changelog

- v1.0.0 (2026-06-23): Initial release
