# Aplikasi Sistem Manajemen Kamar & Penghuni Kost (Kost Griya Mandiri)
### Modul Anggota 1 & Anggota 2: Core MVC, Master Kamar, & Relasi Bisnis Penghuni

Aplikasi berbasis PHP Native Modern dengan arsitektur MVC (Model-View-Controller), PSR-4 Autoloading via Composer, Front Controller pattern, transaksi database PDO, dan antarmuka human-crafted (clean, data-dense, professional dashboard).

---

## 1. Struktur Direktori Proyek

```text
Pemrograman-Web-main/
├─ composer.json                 # Konfigurasi PSR-4 autoloader (App\ -> src/)
├─ database.sql                  # Skrip pembuatan database db_kostan, tabel kamar, & penghuni
├─ public/
│  ├─ .htaccess                  # URL Rewrite Apache mod_rewrite
│  └─ index.php                  # Front Controller (Single Entry Point & Routing)
├─ src/
│  ├─ config/
│  │  └─ koneksi.php             # Koneksi Database PDO MySQL
│  ├─ Core/
│  │  └─ Router.php              # Dispatcher & HTTP Routing (GET & POST)
│  ├─ Model/
│  │  ├─ Kamar.php               # Entity Model Data Kamar
│  │  └─ Penghuni.php            # Entity Model Data Penghuni
│  ├─ Repository/
│  │  ├─ KamarRepository.php     # Query database PDO Kamar
│  │  └─ PenghuniRepository.php  # Query JOIN & Transaksi Check-in/Checkout Penghuni
│  └─ Controllers/
│     ├─ KamarController.php     # Controller CRUD Kamar & Proteksi Hapus
│     └─ PenghuniController.php  # Controller Check-in, Checkout, Validasi NIK & No HP
└─ views/
   ├─ layout/
   │  ├─ header.php              # Header & Navbar Bootstrap 5 (Human-Crafted)
   │  └─ footer.php              # Footer bersama
   ├─ kamar/
   │  ├─ index.php               # Tampilan Data-Dense Table Kamar & Badges
   │  ├─ create.php              # Form Tambah Kamar Baru
   │  └─ edit.php                # Form Edit Kamar & Status Ketersediaan
   └─ penghuni/
      ├─ index.php               # Tabel Riwayat Penghuni Aktif & Tombol Checkout
      └─ create.php              # Form Check-in Penghuni (Dropdown Kamar Tersedia)
```

---

## 2. Cara Menjalankan Aplikasi

### Langkah 1: Persiapan Database MySQL
1. Buka **Laragon** atau **XAMPP**, lalu nyalakan service **MySQL**.
2. Buka phpMyAdmin (`http://localhost/phpmyadmin`) atau HeidiSQL.
3. Impor file `database.sql` atau jalankan kueri SQL di dalamnya untuk membuat database `db_kostan` beserta tabel `kamar` dan `penghuni`.

### Langkah 2: Autoloading Composer
Pastikan autoloader sudah ter-generate:
```bash
composer dump-autoload
```

### Langkah 3: Menjalankan Server Web

**Opsi A: Menggunakan PHP Built-in Server (Sangat Disarankan untuk Dev / Demo)**
Buka terminal di dalam folder `Pemrograman-Web-main`, lalu jalankan:
```bash
php -S localhost:8000 -t public
```
Buka browser di alamat:
- Manajemen Kamar: [http://localhost:8000/kamar](http://localhost:8000/kamar)
- Data Penghuni: [http://localhost:8000/penghuni](http://localhost:8000/penghuni)

**Opsi B: Menggunakan Laragon / XAMPP Virtual Host atau Subfolder**
- Jika ditaruh di folder `htdocs` atau `www`:
  Akses via `http://localhost/UTS/Pemrograman-Web-main/public/kamar`
- Sistem Router sudah dilengkapi auto-detection `BASE_URL` sehingga link dan aset akan otomatis menyesuaikan lokasi subfolder tanpa error.

---

## 3. Fitur yang Diimplementasikan

### A. Modul Anggota 1 (Core MVC & Master Kamar)
1. **Arsitektur Core MVC:**
   - Front Controller (`public/index.php`) sebagai single entry point.
   - Core Router (`App\Core\Router`) yang mendukung method `GET` & `POST` serta parameter dinamis `{id}`.
   - Database Connection (`App\config\koneksi.php`) menggunakan **PHP Data Objects (PDO)** dengan exception mode aktif.
2. **Master Data Kamar (CRUD):**
   - Menampilkan data kamar dalam bentuk *data-dense table* dengan status badge.
   - Form tambah kamar dengan validasi nomor unik dan harga positif.
   - Edit kamar dan proteksi penghapusan kamar yang berstatus *terisi*.
   - Pola Post/Redirect/Get (PRG) untuk mencegah form re-submission.

### B. Modul Anggota 2 (Modul Penghuni & Relasi Bisnis)
1. **Entity & Repository Penghuni (`Penghuni.php` & `PenghuniRepository.php`):**
   - Query `allActive()` dengan `JOIN` antara tabel `penghuni` dan `kamar`.
   - Query `getAvailableRooms()` untuk memfilter hanya kamar yang berstatus `tersedia`.
   - Transaksi database atomik pada `checkIn()`: otomatis meng-insert record penghuni dan meng-update status kamar menjadi `terisi`.
   - Transaksi database atomik pada `checkOut()`: mencatat `tgl_keluar`, mengubah `status_sewa` menjadi `selesai`, dan mengembalikan status kamar menjadi `tersedia`.
2. **Controller Penghuni (`PenghuniController.php`):**
   - Validasi ketat sisi server:
     - Field wajib: `nama_lengkap`, `nik`, `no_hp`, `kamar_id`, `tgl_masuk`.
     - Validasi panjang NIK minimal 16 digit angka.
     - Validasi nomor HP/WhatsApp hanya angka.
     - Verifikasi ketersediaan kamar sebelum check-in.
   - Pola PRG (Post/Redirect/Get) dengan pesan notifikasi (flash messages).
3. **Views Penghuni (`views/penghuni/`):**
   - `create.php`: Form check-in dengan dropdown dinamis kamar berstatus *tersedia*, pesan peringatan jika seluruh kamar penuh, dan dukungan auto-select kamar dari tabel kamar.
   - `index.php`: Tabel ringkas human-crafted menampilkan penghuni aktif, nomor kamar, kontak, NIK, tarif bulanan, tanggal masuk, dan tombol konfirmasi checkout.
   - Proteksi XSS dengan fungsi `htmlspecialchars()`.

---

## 4. Alur Git & Kolaborasi GitHub untuk Anggota 2

```bash
# 1. Pindah ke branch fitur Anggota 2
git checkout -b feat/penghuni-relasi

# 2. Commit file model dan repository
git add src/Model/Penghuni.php src/Repository/PenghuniRepository.php database.sql
git commit -m "feat: query repository penghuni relasi join kamar dan transaksi check-in"

# 3. Commit controller dan rute
git add src/Controllers/PenghuniController.php public/index.php
git commit -m "feat: implementasi PenghuniController validasi input NIK dan no_hp"

# 4. Commit view penghuni dan header
git add views/penghuni/ views/layout/header.php views/kamar/index.php
git commit -m "feat: tampilan form check-in penghuni dan tabel daftar penghuni aktif"

# 5. Push ke GitHub repository
git push -u origin feat/penghuni-relasi
```
