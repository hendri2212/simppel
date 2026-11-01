# SIMPPLE - Sistem Informasi Manajemen Pengadaan Paket Lelang Elektronik

[![CodeIgniter Version](https://img.shields.io/badge/CodeIgniter-4.x-orange.svg)](https://codeigniter.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.1-blue.svg)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-Proprietary-red.svg)]()

**SIMPPLE** (Sistem Informasi Manajemen Pengadaan / Pengajuan Paket Lelang Elektronik) adalah aplikasi berbasis web yang dirancang untuk mengelola dan memfasilitasi proses pengadaan barang dan jasa pemerintah (khususnya tender dan seleksi) pada tingkat instansi/Satuan Kerja Perangkat Daerah (SKPD) dan Unit Kerja Pengadaan Barang/Jasa (UKPBJ).

Aplikasi ini mencakup siklus persiapan pengadaan, integrasi Rencana Umum Pengadaan (RUP) dengan INAPROC / SiRUP LKPP, pembuatan dan pengajuan paket pengadaan, validasi kelengkapan berkas persyaratan lelang, hingga penugasan Pokja Pemilihan.

---

## 📌 Fitur Utama

### 1. Manajemen Akun & Kontrol Akses Berbasis Peran (RBAC)
- **9 Peran Pengguna (Roles):**
  - `ADMINISTRATOR`: Akses penuh terhadap seluruh sistem, konfigurasi, dan manajemen pengguna.
  - `ADMIN PPK`: Pengelola administrasi PPK pada SKPD terkait.
  - `PPK` (Pejabat Pembuat Komitmen): Penyusun dan pemilik paket pengadaan serta berkas syarat.
  - `ADMIN ULP`: Administrator Unit Layanan Pengadaan / UKPBJ.
  - `DISTRIBUSI`: Tim distribusi berkas dan disposisi paket.
  - `KEPALA ULP`: Pimpinan UKPBJ untuk pemantauan dan persetujuan.
  - `POKJA`: Kelompok Kerja Pengadaan untuk penanganan paket tender.
  - `ADMIN AGENCY`: Administrator perwakilan SKPD/instansi.
  - `MONEV`: Petugas Monitoring dan Evaluasi pengadaan.
- **Scoping Data Bertingkat (`ProcurementScope`):**
  - Role pusat (Administrator, ULP, Pokja, Monev) memiliki visibilitas lintas SKPD secara menyeluruh.
  - Role daerah/penyusun (PPK, Admin PPK, Admin Agency) dibatasi secara otomatis hanya dapat melihat dan mengelola data milik SKPD/PPK yang terafiliasi dengan akun mereka.
- **Proteksi Autentikasi & Keamanan:**
  - Filter akses ketat (`AuthFilter`, `RoleFilter`, `GuestFilter`, `CsrfHeader`).
  - Fitur reset password pengguna oleh Administrator.
  - Proteksi CSRF (Cross-Site Request Forgery) pada seluruh operasi mutasi (POST).

### 2. Rencana Umum Pengadaan (RUP)
- Pencatatan dan manajemen paket perencanaan RUP per tahun anggaran.
- **Integrasi INAPROC API:** Sinkronisasi dan pengambilan data paket RUP langsung dari API INAPROC (SiRUP LKPP).
- Pencarian dan filter dinamis data RUP berdasarkan SKPD, jenis pengadaan, metode pemilihan, dan pagu anggaran.
- Detail informasi paket perencanaan beserta riwayat data.

### 3. Manajemen Paket Pengadaan (Tender & Seleksi)
- Pembuatan dan pembaruan paket lelang/seleksi berbasis RUP.
- **Penomoran Atomik Aman:** Mekanisme locking database (`simpple_no_paket`) saat pembuatan nomor paket untuk mencegah tabrakan (race condition) nomor registrasi.
- **Alur Validasi & Pengajuan Paket:** Validasi berkas persyaratan wajib sebelum paket dapat diajukan ke UKPBJ.
- Pemetaan penugasan tim Pokja terhadap paket terkait (`paket_pokja`).

### 4. Manajemen Dokumen Persyaratan Paket
- Upload berkas persyaratan tender (KAK, HPS, Rancangan Kontrak, Gambar Teknis, dll.).
- **Validasi Keamanan File Ketat:**
  - Deteksi MIME type berbasis inspeksi konten asli file (bukan hanya ekstensi nama file).
  - Whitelist format yang diizinkan: `PDF`, `DOC/DOCX`, `XLS/XLSX/XLSM`, `JPG/PNG`, dan `ZIP`.
  - Pembatasan ukuran unggahan berkas (maksimal 20 MB per file).
- Antarmuka unduh dan hapus dokumen secara aman.

### 5. Antarmuka Modern & Dasbor Analitik
- Antarmuka berbasis template premium **SmartAdmin v5** dengan dukungan *Dark Mode* dan *Light Mode*.
- Visualisasi data statistik dan grafik menggunakan **ApexCharts** dan **Peity Charts**.
- Navigasi sidebar terorganisir dengan pencarian menu cepat (*quick filter*).

---

## 🛠️ Tech Stack

- **Backend:** [PHP](https://www.php.net/) ^8.1, [CodeIgniter 4](https://codeigniter.com/)
- **Database:** [MySQL](https://www.mysql.com/) 8.0+ / [MariaDB](https://mariadb.org/) 10.4+
- **Frontend & UI:** [Bootstrap 5.3](https://getbootstrap.com/), SmartAdmin v5, Sass, jQuery
- **Asset Pipeline:** [Gulp](https://gulpjs.com/) v4, PostCSS/Autoprefixer, CleanCSS, Uglify
- **Paket & Dependency:** [Composer](https://getcomposer.org/), [NPM](https://www.npmjs.com/) / [Bun](https://bun.sh/)

---

## 📋 Kebutuhan Sistem (Prerequisites)

Pastikan lingkungan server Anda memenuhi spesifikasi berikut:

1. **PHP >= 8.1** dengan ekstensi aktif:
   - `intl`
   - `mbstring`
   - `json`
   - `mysqlnd`
   - `curl`
   - `fileinfo`
   - `gd` (opsional untuk pemrosesan grafis)
2. **Database:** MySQL 8.0+ atau MariaDB 10.4+
3. **Web Server:** Apache (dengan `mod_rewrite`), Nginx, atau PHP Built-in Server untuk pengembangan.
4. **Composer:** Versi 2.x
5. **Node.js & NPM** (Node >= 18) atau **Bun** (untuk kompilasi aset frontend)

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Kloning Repositori
```bash
git clone <url-repository> simpple
cd simpple
```

### 2. Instalasi Dependensi Backend (Composer)
```bash
composer install
```

### 3. Instalasi & Kompilasi Aset Frontend
Gunakan NPM atau Bun untuk mengunduh package frontend dan melakukan build:

```bash
# Menggunakan NPM
npm install
npm run build

# Atau menggunakan Bun
bun install
bun run build
```

Untuk mode pengembangan frontend dengan file watching & live reload:
```bash
npm run dev
```

### 4. Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh `env` ke `.env`:

```bash
cp env .env
```

Buka file `.env` dan sesuaikan pengaturan aplikasi serta koneksi database:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = simppel
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Jalankan Migrasi & Seeder Database
Buat database terlebih dahulu di MySQL/MariaDB (misal: `simppel`), lalu jalankan migrasi tabel dan pengisian master data:

```bash
# Jalankan migrasi seluruh tabel
php spark migrate

# Jalankan seeder master data (SKPD, PPK, Role, Pengadaan, User, RUP, Paket)
php spark db:seed DatabaseSeeder
```

#### 🔄 Reset & Migrasi Ulang dari Awal (*Migrate Fresh / Refresh*)
Di CodeIgniter 4, padanan perintah `migrate:fresh` adalah `migrate:refresh` (melakukan *rollback* semua migrasi lalu menjalankannya kembali dari awal):

```bash
# Rollback seluruh migrasi dan jalankan ulang dari awal
php spark migrate:refresh

# Reset migrasi sekaligus isi ulang data master seeder
php spark migrate:refresh && php spark db:seed DatabaseSeeder

# Opsi alternatif: Rollback ke batch 0 lalu migrasi ulang
php spark migrate:rollback -b 0 && php spark migrate
```

### 6. Menjalankan Server Lokal
Jalankan server pengembangan bawaan CodeIgniter:

```bash
php spark serve
```
Akses aplikasi melalui peramban web di: `http://localhost:8080`

---

## 🔑 Akun Uji Coba (Login)

Setelah menjalankan seeder `DatabaseSeeder`, Anda dapat masuk menggunakan akun pengujian berikut:

| Peran (Role) | Username | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` *(atau `admin@simpple.com`)* | `admin123` | Akses penuh seluruh modul & manajemen akun |
| **Admin ULP** | `ukpbj_adm_lili` | `12345678` | Akun verifikasi & penanganan ULP / UKPBJ |
| **PPK** | `ppk.pupr-sda` | `12345678` | Akun Pejabat Pembuat Komitmen (buat paket & RUP) |
| *Akun Lainnya* | *(Lihat daftar di `UserSeeder.php`)* | `12345678` | Akun simulasi SKPD dan peran lainnya |

> [!IMPORTANT]
> Segera ubah password default saat menerapkan aplikasi di lingkungan produksi (*production*).

---

## 📁 Struktur Direktori Utama

```text
simpple/
├── app/
│   ├── Config/              # Konfigurasi aplikasi, database, rute, dan filter
│   │   ├── Routes.php       # Definisi rute URL dan proteksi middleware
│   │   └── Filters.php      # Registrasi alias filter keamanan
│   ├── Controllers/         # Controller utama aplikasi
│   │   ├── Auth.php         # Alur autentikasi (login, register, logout)
│   │   ├── AccountController.php # Manajemen pengguna khusus administrator
│   │   ├── PaketController.php   # Manajemen paket tender & dokumen syarat
│   │   ├── RupController.php     # Manajemen RUP & integrasi INAPROC
│   │   └── Traits/
│   │       └── ProcurementScope.php # Logika scoping data per SKPD/PPK
│   ├── Database/
│   │   ├── Migrations/      # Skema tabel database
│   │   └── Seeds/           # Seeder master data, roles, dan user
│   ├── Filters/             # Filter autentikasi, otorisasi peran, & CSRF
│   ├── Models/              # Model data CodeIgniter
│   └── Views/               # File tampilan Blade/PHP (SmartAdmin UI)
│       ├── auth/            # Halaman login, register, lockscreen
│       └── partials/        # Komponen layout (header, sidebar, nav, logo)
├── public/                  # Document root web server (index.php, css, js, icons)
├── writable/                # File cache, logs, session, dan dokumen upload
├── gulpfile.js              # Task runner otomatisasi kompilasi Sass & JS
├── package.json             # Dependensi frontend (SmartAdmin, Bootstrap, ApexCharts)
├── composer.json            # Dependensi backend PHP
└── spark                    # CLI tool CodeIgniter 4
```

---

## 🛡️ Catatan Deployment Produksi

1. **Document Root Server:** Arahkan konfigurasi virtual host web server (Nginx/Apache) ke direktori `public/`, **bukan** ke root folder proyek. Hal ini penting untuk mencegah tereksposnya file framework, konfigurasi `.env`, dan berkas aplikasi.
2. **Izin Akses Folder:** Pastikan direktori `writable/` memiliki izin baca dan tulis (*read/write permissions*) bagi user web server (misal `www-data` atau `nginx`).
3. **Environment Mode:** Ubah `CI_ENVIRONMENT` menjadi `production` di file `.env` untuk menyembunyikan stack trace error debug dari publik.

---

## 📄 Lisensi

Aplikasi ini dikembangkan untuk kebutuhan manajemen pengadaan barang/jasa instansi pemerintah. Seluruh hak cipta dilindungi undang-undang.
