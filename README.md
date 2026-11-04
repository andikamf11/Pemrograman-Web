# Sistem Manajemen Kamar & Penghuni Kost (Kost Griya Mandiri)
### Proyek Kolaborasi UTS / Praktikum Pemrograman Web

Aplikasi web manajemen kos berbasis **PHP Native Modern** yang dibangun menggunakan arsitektur **MVC (Model-View-Controller)**, **PSR-4 Autoloading via Composer**, **Front Controller Pattern**, transaksi database aman dengan **PHP Data Objects (PDO)**, antarmuka human-crafted (clean, data-dense, professional dashboard tanpa template AI), serta kontrol alur Git estafet kolaboratif antar 3 anggota kelompok.

---

## 1. Identitas Kelompok & Pembagian Tugas

- **Mata Kuliah:** Pemrograman Web
- **Institusi:** Universitas Muhammadiyah Malang (UMM)
- **Topik Proyek:** Sistem Informasi Operasional Kamar & Relasi Penghuni Kos-Kosan

| No | Nama Anggota | NIM | Peran Utama & Modul | Branch Git Fitur |
| :-: | :--- | :--- | :--- | :--- |
| **1** | **Anggota 1** | *(NIM Anggota 1)* | **Core Architecture & Master Kamar** (Router, PDO, Layout Dasar, CRUD Kamar) | `feat/core-kamar` |
| **2** | **Anggota 2** | *(NIM Anggota 2)* | **Relasi Bisnis & Modul Penghuni** (JOIN Query, Check-in/Checkout, Validasi NIK & Kontak) | `feat/penghuni-relasi` |
| **3** | **Anggota 3** | *(NIM Anggota 3)* | **Dashboard Analytics, Filter & QA** (Ringkasan Statistik Omzet, Search Kamar, Error 404/422, Dokumentasi) | `feat/dashboard-polish` |

---

## 2. Struktur Direktori Proyek

```text
Pemrograman-Web-main/
├─ composer.json                 # Konfigurasi PSR-4 autoloader ("App\\": "src/")
├─ database.sql                  # Skrip skema database db_kostan & dummy data siap demo
├─ panduan-alur-git-dan-review.md# Dokumentasi alur PR, commit message & skrip review silang
├─ panduan-ui-non-ai.md          # Standar pedoman antarmuka human-crafted profesional
├─ plan-anggota-3.md             # Panduan kerja teknis modul Anggota 3
├─ README.md                     # Dokumentasi komprehensif sistem aplikasi
├─ public/
│  ├─ .htaccess                  # Konfigurasi URL rewrite Apache mod_rewrite
│  └─ index.php                  # Front Controller (Single Entry Point & HTTP Routing)
├─ src/
│  ├─ config/
│  │  └─ koneksi.php             # Koneksi Database PDO MySQL dengan exception handler
│  ├─ Core/
│  │  └─ Router.php              # Dispatcher routing GET & POST dengan dukungan parameter dinamis
│  ├─ Model/
│  │  ├─ Kamar.php               # Model entitas Kamar
│  │  └─ Penghuni.php            # Model entitas Penghuni
│  ├─ Repository/
│  │  ├─ KamarRepository.php     # Query database PDO Kamar, validasi unik, & fitur search/filter
│  │  └─ PenghuniRepository.php  # Query JOIN relasi kamar-penghuni, transaksi check-in/checkout
│  └─ Controllers/
│     ├─ DashboardController.php # Kalkulasi agregat statistik kamar, omzet & hunian
│     ├─ KamarController.php     # Controller CRUD kamar, filter status, proteksi hapus
│     └─ PenghuniController.php  # Controller form check-in, validasi ketat, & proses checkout
└─ views/
   ├─ layout/
   │  ├─ header.php              # Navbar & master CSS Bootstrap 5 (Human-Crafted)
   │  └─ footer.php              # Footer bersama
   ├─ dashboard/
   │  └─ index.php               # Kartu ringkasan metrik statistik, progress okupansi & shortcut
   ├─ kamar/
   │  ├─ index.php               # Tabel kamar data-dense, search bar, dropdown filter & badges
   │  ├─ create.php              # Form penambahan kamar baru
   │  └─ edit.php                # Form edit detail kamar & status
   ├─ penghuni/
   │  ├─ index.php               # Tabel daftar penghuni aktif & tombol konfirmasi checkout
   │  └─ create.php              # Form pendaftaran check-in penghuni (dropdown kamar tersedia)
   └─ errors/
      ├─ 404.php                 # Halaman penanganan rute tidak terdaftar (HTTP 404)
      └─ 422.php                 # Halaman penanganan kesalahan validasi input formulir (HTTP 422)
```

---

## 3. Cara Menjalankan Aplikasi di Komputer Lokal

### Langkah 1: Persiapan Database MySQL
1. Buka aplikasi **Laragon** atau **XAMPP**, kemudian nyalakan service **MySQL** (dan Apache jika menggunakan virtual host).
2. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`) atau software SQL client pilihan Anda (HeidiSQL/DBeaver).
3. Impor berkas `database.sql` atau jalankan seluruh sintaks SQL di dalamnya. Berkas ini secara otomatis akan:
   - Membuat basis data `db_kostan`.
   - Membuat tabel relasional `kamar` dan `penghuni` dengan *foreign key constraint*.
   - Mengisi data contoh (*dummy data*) yang siap pakai untuk demo penilaian.

### Langkah 2: Autoloading Composer
Jalankan terminal pada direktori proyek (`Pemrograman-Web-main`), lalu perbarui pemetaan autoloader PSR-4:
```bash
composer dump-autoload
```

### Langkah 3: Menjalankan Server Web

**Opsi Utama: Menggunakan PHP Built-in Server (Rekomendasi untuk Demo & Pengujian)**
```bash
php -S localhost:8000 -t public
```
Buka browser pada alamat:
- **Dashboard Utama:** [http://localhost:8000/](http://localhost:8000/)
- **Manajemen Kamar:** [http://localhost:8000/kamar](http://localhost:8000/kamar)
- **Data Penghuni:** [http://localhost:8000/penghuni](http://localhost:8000/penghuni)

**Opsi Alternatif: Menggunakan Laragon / XAMPP Apache Subfolder**
- Tempatkan folder proyek di dalam direktori `www` (Laragon) atau `htdocs` (XAMPP).
- Akses melalui URL lokal Anda, contoh: `http://localhost/Pemrograman-Web-main/public/`.
- Routing aplikasi telah dibekali pendeteksi otomatis `BASE_URL` sehingga tautan rute dan aset tetap berfungsi tanpa galat path.

---

## 4. Rincian Fitur Berdasarkan Pembagian Anggota

### A. Modul Anggota 1: Core MVC Architecture & Master Kamar
1. **Front Controller & Dispatcher:**
   - Seluruh request pengguna diarahkan ke satu pintu masuk di `public/index.php`.
   - Core Router (`App\Core\Router`) menangkap method `GET` & `POST` serta parsing parameter URL dinamis `{id}`.
2. **Koneksi Database PDO:**
   - Menghubungkan aplikasi ke MySQL melalui `PDO` dengan mode `ERRMODE_EXCEPTION` dan `ATTR_EMULATE_PREPARES => false` guna menjamin keamanan dari serangan SQL Injection.
3. **Master Data Kamar (CRUD Lengkap):**
   - Menampilkan daftar kamar dalam format *data-dense table*.
   - Tambah kamar baru dengan validasi nomor kamar unik dan harga positif.
   - Edit kamar dan proteksi penghapusan: kamar yang berstatus **Terisi** tidak dapat dihapus demi menjaga integritas data relasi penghuni.
   - Menggunakan pola **Post/Redirect/Get (PRG)** untuk mencegah *duplicate form submission* saat browser di-refresh.

### B. Modul Anggota 2: Relasi Bisnis Penghuni & Transaksi Sewa
1. **Repository Relasional (`PenghuniRepository.php`):**
   - Query `allActive()` dengan klausa `JOIN` antara tabel `penghuni` dan `kamar`.
   - Filter kamar siap huni dengan method `getAvailableRooms()`.
2. **Otomasi Status Transaksi Check-in & Checkout:**
   - **Check-in Penghuni:** Sistem memverifikasi status kamar masih kosong, mencatat identitas penyewa, dan secara atomik mengubah status kamar menjadi **Terisi**.
   - **Checkout Penghuni:** Mengakhiri masa sewa penyewa, mengisi tanggal keluar, mengubah `status_sewa` menjadi `selesai`, dan secara otomatis mengembalikan status kamar menjadi **Tersedia**.
3. **Validasi Formulir:**
   - Validasi ketat NIK (minimal 16 digit angka).
   - Validasi nomor kontak WhatsApp/HP (hanya karakter angka numerik).

### C. Modul Anggota 3: Dashboard Analytics, Filter Pencarian, QA & Dokumentasi
1. **Dashboard Statistik & Ringkasan Metrik (`DashboardController.php`):**
   - Menggunakan query database agregat cepat (`COUNT` dan `SUM`) untuk kalkulasi statistik:
     - Total unit kamar keseluruhan.
     - Jumlah kamar kosong (tersedia).
     - Jumlah kamar terisi & persentase okupansi (*occupancy rate*).
     - Estimasi pemasukan/omzet bulanan dari kamar yang sedang disewa.
   - Tabel ringkasan cepat: daftar kamar kosong siap sewa dan daftar penghuni aktif terkini.
   - Tombol shortcut aksi cepat untuk mempercepat alur kerja admin.
2. **Fitur Filter & Search Kamar:**
   - Filter dropdown instan berdasarkan status: **Semua Status**, **Tersedia**, atau **Terisi**.
   - Kolom pencarian dinamis berdasarkan nomor kamar atau tipe kamar.
   - Tombol reset pencarian yang memudahkan kembali ke daftar master.
3. **Penanganan Galat (Error Handling 404 & 422):**
   - **Halaman 404 (`views/errors/404.php`):** Menampilkan halaman ramah pengguna saat URL yang diakses tidak cocok dengan tabel rute, lengkap dengan status kode HTTP 404 dan navigasi balik.
   - **Halaman 422 (`views/errors/422.php`):** Pengaturan status kode HTTP 422 (*Unprocessable Entity*) dan visualisasi rincian pesan kesalahan saat validasi formulir gagal.
4. **Data Pengujian Siap Demo (`database.sql`):**
   - SQL dump siap pakai dengan kombinasi data riil (kamar tipe Standard, Deluxe, VIP dan penghuni aktif/selesai) sehingga dosen penguji langsung melihat visualisasi metrik tanpa harus menginput manual dari nol.

---

## 5. Daftar Lengkap Rute Aplikasi (Routing Table)

| HTTP Method | URI Endpoint | Controller & Action | Fungsi / Deskripsi |
| :---: | :--- | :--- | :--- |
| **GET** | `/` | `DashboardController@index` | Dashboard ringkasan metrik statistik operasional kost |
| **GET** | `/dashboard` | `DashboardController@index` | Rute alternatif ke dashboard statistik |
| **GET** | `/kamar` | `KamarController@index` | Menampilkan daftar kamar (mendukung query filter `?keyword=` & `?status=`) |
| **GET** | `/kamar/tambah` | `KamarController@create` | Menampilkan formulir penambahan kamar baru |
| **POST** | `/kamar/simpan` | `KamarController@store` | Menyimpan data kamar baru (Pola PRG) |
| **GET** | `/kamar/edit/{id}` | `KamarController@edit` | Menampilkan formulir edit kamar |
| **POST** | `/kamar/update/{id}`| `KamarController@update` | Menyimpan perubahan data kamar |
| **POST** | `/kamar/hapus/{id}` | `KamarController@delete` | Menghapus kamar (dilindungi proteksi status terisi) |
| **GET** | `/penghuni` | `PenghuniController@index` | Menampilkan daftar seluruh penghuni kamar aktif |
| **GET** | `/penghuni/tambah` | `PenghuniController@create` | Menampilkan formulir pendaftaran check-in penghuni |
| **POST** | `/penghuni/simpan` | `PenghuniController@store` | Menyimpan check-in & mengubah kamar jadi 'terisi' |
| **POST** | `/penghuni/checkout`| `PenghuniController@checkout` | Memproses checkout & mengembalikan kamar jadi 'tersedia' |
| *ANY* | *(URL tidak terdaftar)* | `Router@dispatch` | Mengembalikan respon HTTP 404 (`views/errors/404.php`) |

---

## 6. Panduan Alur Git & Perintah Commit Anggota 3

Bagi Anggota 3, seluruh tahapan pengerjaan branch fitur `feat/dashboard-polish` dicatat dengan perintah commit bertahap:

```bash
# 1. Pindah ke branch fitur Anggota 3
git checkout -b feat/dashboard-polish

# 2. Commit modul controller dashboard dan view analitik
git add src/Controllers/DashboardController.php views/dashboard/
git commit -m "feat: dashboard statistik ringkasan total kamar, kamar kosong dan omzet"

# 3. Commit fitur filter kamar dan penanganan error 404 & 422
git add src/Repository/KamarRepository.php src/Controllers/KamarController.php views/kamar/ views/errors/ src/Core/Router.php public/index.php views/layout/header.php
git commit -m "feat: filter status kamar dan halaman penanganan error 404 serta 422"

# 4. Commit pembaruan database dump dan dokumentasi lengkap
git add database.sql README.md
git commit -m "docs: dokumentasi instalasi proyek, identitas kelompok dan dump database awal"

# 5. Push branch ke remote GitHub
git push -u origin feat/dashboard-polish
```
