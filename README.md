# Aplikasi Sistem Manajemen Kamar & Penghuni Kost (Kost Griya Mandiri)
### Modul Anggota 1: Core MVC Architecture, Layout, & CRUD Master Data Kamar

Aplikasi berbasis PHP Native Modern dengan arsitektur MVC (Model-View-Controller), PSR-4 Autoloading via Composer, Front Controller pattern, dan antarmuka human-crafted (clean, data-dense, professional dashboard).

---

## 1. Struktur Direktori Proyek

```text
app-kost/
├─ composer.json                 # Konfigurasi PSR-4 autoloader (App\ -> src/)
├─ database.sql                  # Skrip pembuatan database db_kostan & tabel kamar
├─ public/
│  ├─ .htaccess                  # URL Rewrite Apache mod_rewrite
│  └─ index.php                  # Front Controller (Single Entry Point)
├─ src/
│  ├─ config/
│  │  └─ koneksi.php             # Koneksi Database PDO MySQL
│  ├─ Core/
│  │  └─ Router.php              # Dispatcher & HTTP Routing (GET & POST)
│  ├─ Model/
│  │  └─ Kamar.php               # Entity Model Data Kamar
│  ├─ Repository/
│  │  └─ KamarRepository.php     # Query database PDO (all, find, save, update, delete)
│  └─ Controllers/
│     └─ KamarController.php     # Controller penanganan alur CRUD, validasi, dan PRG
└─ views/
   ├─ layout/
   │  ├─ header.php              # Header & Navbar Bootstrap 5 (Human-Crafted)
   │  └─ footer.php              # Footer bersama
   └─ kamar/
      ├─ index.php               # Tampilan Data-Dense Table Kamar & Badges
      ├─ create.php              # Form Tambah Kamar Baru
      └─ edit.php                # Form Edit Kamar & Status Ketersediaan
```

---

## 2. Cara Menjalankan Aplikasi

### Langkah 1: Persiapan Database MySQL
1. Buka **Laragon** atau **XAMPP**, lalu nyalakan service **MySQL**.
2. Buka phpMyAdmin (`http://localhost/phpmyadmin`) atau HeidiSQL.
3. Impor file `database.sql` atau jalankan kueri SQL di dalamnya untuk membuat database `db_kostan` beserta tabel `kamar`.

### Langkah 2: Autoloading Composer
Pastikan autoloader sudah ter-generate:
```bash
composer dump-autoload
```

### Langkah 3: Menjalankan Server Web

**Opsi A: Menggunakan PHP Built-in Server (Sangat Disarankan untuk Dev / Demo)**
Buka terminal di dalam folder `app-kost`, lalu jalankan:
```bash
php -S localhost:8000 -t public
```
Buka browser di alamat: [http://localhost:8000/kamar](http://localhost:8000/kamar)

**Opsi B: Menggunakan Laragon / XAMPP Virtual Host atau Subfolder**
- Jika ditaruh di folder `htdocs` atau `www`:
  Akses via `http://localhost/UTS/app-kost/public/kamar`
- Sistem Router sudah dilengkapi auto-detection `BASE_URL` sehingga link dan aset akan otomatis menyesuaikan lokasi subfolder tanpa error.

---

## 3. Fitur yang Diimplementasikan (Anggota 1)

1. **Arsitektur Core MVC:**
   - Front Controller (`public/index.php`) sebagai pintu masuk tunggal.
   - Core Router (`App\Core\Router`) yang mendukung method `GET` & `POST`, pencocokan rute statis maupun rute dengan parameter dinamis (`{id}`).
   - Database Connection (`App\config\koneksi.php`) menggunakan **PHP Data Objects (PDO)** dengan exception mode aktif.
2. **Master Data Kamar (CRUD Lengkap):**
   - **Read:** Menampilkan data kamar dalam bentuk *data-dense table* dengan pembeda status badge (*Tersedia* hijau pastel, *Terisi* amber lembut).
   - **Create:** Form pendaftaran kamar dengan validasi nomor unik, tipe, harga positif, dan fasilitas.
   - **Update:** Pengubahan data tipe, harga, nomor, dan status kamar.
   - **Delete:** Penghapusan kamar dengan **proteksi bisnis** (kamar yang berstatus *terisi* otomatis ditolak dari penghapusan).
   - **Pola PRG (Post/Redirect/Get):** Mencegah resubmit form saat halaman direfresh.
3. **UI Human-Crafted:**
   - Mengikuti panduan desain anti-AI (tanpa gradien ungu neon, tanpa glassmorphism berlebihan, layout rapi dengan garis tipis `#E2E8F0`, tipografi terstruktur, dan copy berbahasa Indonesia baku).

---

## 4. Alur Git & Kolaborasi GitHub

```bash
# 1. Pindah ke branch fitur Anggota 1
git checkout -b feat/core-kamar

# 2. Push ke GitHub repository
git push -u origin feat/core-kamar

# 3. Buat Pull Request di GitHub:
#    Judul: [PR] Inisialisasi Core MVC dan Fitur CRUD Kamar
#    Reviewer: Tunjuk Anggota 2
```
