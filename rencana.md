# Rencana Pengembangan: Penyederhanaan Alur Verifikasi Admin ULP pada `/paket`

Dokumen ini menyimpan catatan teknis dan opsi rancangan untuk menyederhanakan alur kerja role **ADMIN ULP** pada modul Paket Pengadaan (`/paket`), khususnya terkait pertimbangan melewati (*skip*) tahap **"Pilih Paket"** tanpa mengubah integritas logika bisnis dan struktur database.

---

## 1. Kondisi Saat Ini (As-Is)

Kode sumber utama yang mengatur alur ini:
- Definisi status & aksi: `app/Libraries/PaketWorkflow.php` (`ACTIONS` & `available()`)
- Eksekusi transisi & database: `app/Controllers/PaketWorkflowController.php` (`transition()` & `catatanStore()`)
- Antarmuka & filter tab: `app/Views/paket.php` & `app/Views/partials/paket-workflow.php`

### Rincian Tahapan & Perubahan Database Saat Ini

| Tahap / Aksi | Syarat Awal (`PaketWorkflow`) | Perubahan di Database | Efek Bisnis & UI |
| :--- | :--- | :--- | :--- |
| **1. `pilih`**<br>*(Pilih Paket)* | • `status_paket = 2`<br>• `admin_ukpbj_id = NULL / 0`<br>• Role: `ADMIN ULP` | **Tabel `paket`**:<br>• `admin_ukpbj_id` = `id` Admin ULP yang mengklik<br>• `status_paket` **tetap `2`** (tidak berubah)<br>• `updated_at` = waktu sekarang | • Mengklaim (*lock*) paket ke akun Admin ULP tersebut.<br>• Paket berpindah dari tab pill **Daftar** ke tab pill **Verifikasi**.<br>• Membuka akses tombol **Terima** & **Verifikasi (Kembalikan ke PPK)** khusus untuk Admin ULP pemilik klaim (`assigned => true`). |
| **2A. `kembalikan`**<br>*(Verifikasi / Kembalikan ke PPK)* | • `status_paket = 2`<br>• `admin_ukpbj_id` = ID Admin ULP aktif<br>• Wajib ada catatan terbuka (`status_paket = 3`) | **Tabel `paket`**:<br>• `status_paket` = **`3`** *(Dikembalikan ULP)*<br>• `status_verifikasi` = **`2`** *(Perlu Revisi)*<br>**Tabel `rup`**:<br>• `rup_status` = **`1`** *(Kunci RUP dibuka kembali)*<br>**Tabel `catatan`**:<br>• Insert baris catatan revisi baru (`status_paket = 3`) | • Paket kembali ke PPK untuk dilengkapi/diperbaiki.<br>• Masuk ke tab **Dikembalikan** milik Admin ULP tersebut.<br>• Saat PPK mengajukan kembali (`ajukan_kembali`), `status_paket` kembali ke `2` dan `admin_ukpbj_id` tetap merujuk pada Admin ULP semula. |
| **2B. `terima`**<br>*(Terima)* | • `status_paket = 2`<br>• `admin_ukpbj_id` = ID Admin ULP aktif | **Tabel `paket`**:<br>• `status_paket` = **`4`** *(Diterima UKPBJ)*<br>• `status_verifikasi` = **`1`** *(Disetujui)* | • Berkas dinyatakan lolos verifikasi ULP.<br>• Masuk ke tab **Diterima** milik Admin ULP.<br>• Paket lanjut masuk ke antrean kerja **Admin Distribusi** untuk penunjukan Pokja. |

---

## 2. Opsi Penyederhanaan (Skip Tahap "Pilih Paket")

Secara substansi bisnis, aksi **"Pilih Paket"** tidak mengubah `status_paket`, melainkan hanya mengisi kolom `admin_ukpbj_id` pada tabel `paket`. Pengisian `admin_ukpbj_id` dapat diotomatisasi di backend saat keputusan diambil.

### Opsi 1: Langsung Eksekusi (Full Direct Action — Tanpa Tombol "Pilih Paket")

#### Cara Kerja:
1. Saat PPK mengajukan paket (`status_paket = 2`), Admin ULP langsung melihat tombol **"Terima"** dan **"Verifikasi (Kembalikan ke PPK)"** pada tabel maupun modal detail tanpa perlu mengklik *"Pilih Paket"* terlebih dahulu.
2. Ketika Admin ULP menekan **"Terima"** atau **"Verifikasi (Kembalikan ke PPK)"**, backend secara otomatis mengisi `admin_ukpbj_id = $actor['id']` sekaligus mengubah `status_paket` menjadi `4` (Diterima) atau `3` (Dikembalikan) dalam **1 langkah**.
3. Jika paket pernah dikembalikan (`status = 3`) dan diajukan ulang oleh PPK (`status = 2`), karena `admin_ukpbj_id` sudah terisi oleh verifikator sebelumnya, paket tersebut tetap hanya bisa dieksekusi oleh Admin ULP yang bersangkutan (atau Administrator).

#### Dampak pada UI & Kode jika Diimplementasikan:
- **`app/Libraries/PaketWorkflow.php`**:
  - Menghapus aksi `'pilih'` dari konstanta `ACTIONS`.
  - Pada `available()`, melonggarkan pengecekan `assigned => true` untuk aksi `'kembalikan'` dan `'terima'`: diizinkan apabila `$assignee === 0` (belum ada verifikator) **atau** `$assignee === (int) $actor['id']`.
- **`app/Controllers/PaketWorkflowController.php`**:
  - Pada `transition()` untuk `case 'kembalikan':` dan `case 'terima':`, tambahkan `$update['admin_ukpbj_id'] = (int) $actor['id'];` jika `empty($paket['admin_ukpbj_id'])`.
- **`app/Views/paket.php`**:
  - Menggabungkan tab filter pill **Daftar** dan **Verifikasi** milik Admin ULP menjadi satu tab antrean (misal: **Daftar / Perlu Verifikasi** untuk semua paket `status_paket = 2` yang belum diambil orang lain).

---

### Opsi 2: Hybrid (Direct Action + Auto-Claim Saat Menulis Catatan)

#### Cara Kerja:
1. Tombol **"Pilih Paket"** tetap dihilangkan, sehingga tombol **"Terima"** dan **"Verifikasi (Kembalikan ke PPK)"** langsung aktif sejak paket berstatus `2` (`admin_ukpbj_id = 0`).
2. **Skenario Berkas Lengkap (1 Klik):** Admin ULP langsung klik **"Terima"** -> Backend otomatis mencatat `admin_ukpbj_id = $actor['id']` dan mengubah `status_paket = 4`.
3. **Skenario Pemeriksaan Bertahap (Auto-Claim):** Jika Admin ULP membuka modal detail dan menambahkan catatan koreksi pada tab **Catatan** sebelum mengembalikan paket, fungsi `catatanStore()` di backend otomatis mengisi `admin_ukpbj_id = $actor['id']` pada tabel `paket`.
   - Dengan demikian, paket langsung ter-*claim* menjadi milik Admin ULP tersebut, berpindah dari tab **Daftar** ke tab **Verifikasi**, dan terkunci dari Admin ULP lain selama proses pemeriksaan berlangsung.

#### Dampak pada UI & Kode jika Diimplementasikan:
- **`app/Libraries/PaketWorkflow.php`**:
  - Menghapus aksi `'pilih'` dari `ACTIONS`.
  - Mengizinkan `'kembalikan'` dan `'terima'` ketika `$assignee === 0` atau `$assignee === (int) $actor['id']`.
- **`app/Controllers/PaketWorkflowController.php`**:
  - Pada `transition()` (`kembalikan` & `terima`): mengisi `admin_ukpbj_id = (int) $actor['id']` bila masih kosong.
  - Pada `catatanStore()`: jika `$role === 'ADMIN ULP'`, `$curStatus === 2`, dan `empty($paket['admin_ukpbj_id'])`, lakukan update `paket.admin_ukpbj_id = (int) $actor['id']`.
- **`app/Views/paket.php`**:
  - Struktur 5 tab antrean Admin ULP (**Daftar**, **Verifikasi**, **Dikembalikan**, **Diterima**, **Hasil Lelang**) tetap dapat dipertahankan karena paket yang sedang dicicil catatannya otomatis masuk ke tab **Verifikasi**.
