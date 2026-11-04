-- ========================================================
-- Database Schema: db_kostan
-- Proyek: Sistem Informasi Manajemen Kamar & Penghuni Kost (Kost Griya Mandiri)
-- Modul: Anggota 1, Anggota 2, & Anggota 3
-- ========================================================

CREATE DATABASE IF NOT EXISTS `db_kostan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_kostan`;

-- --------------------------------------------------------
-- 1. Struktur Tabel `kamar` (Dikerjakan oleh Anggota 1)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `penghuni`;
DROP TABLE IF EXISTS `kamar`;

CREATE TABLE `kamar` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nomor` VARCHAR(50) NOT NULL UNIQUE,
    `tipe` VARCHAR(50) NOT NULL,
    `harga` DECIMAL(12, 2) NOT NULL,
    `fasilitas` TEXT NULL,
    `status` ENUM('tersedia', 'terisi') NOT NULL DEFAULT 'tersedia',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Data Awal (Dummy Data) Kamar untuk Pengujian & Demo
-- --------------------------------------------------------
INSERT INTO `kamar` (`id`, `nomor`, `tipe`, `harga`, `fasilitas`, `status`) VALUES
(1, '101', 'Standard', 800000.00, 'Kasur busa single, lemari pakaian 1 pintu, kamar mandi luar, kipas angin, Wi-Fi 50 Mbps', 'terisi'),
(2, '102', 'Standard', 850000.00, 'Kasur single empuk, lemari pakaian 2 pintu, jendela ventilasi luas, kamar mandi luar, Wi-Fi', 'tersedia'),
(3, '201', 'Deluxe', 1200000.00, 'Kasur springbed single, lemari 2 pintu, meja belajar, AC 1/2 PK, kamar mandi dalam, Wi-Fi', 'terisi'),
(4, '202', 'Deluxe', 1250000.00, 'Kasur springbed queen, meja belajar & kursi ergonomis, kamar mandi dalam, AC, Wi-Fi', 'tersedia'),
(5, '301', 'VIP', 1700000.00, 'Kasur king size, smart TV 32 inch, kulkas mini, water heater, AC 1 PK, balkon jemuran pribadi', 'terisi'),
(6, '302', 'VIP', 1800000.00, 'Kasur king size, smart TV 43 inch, kulkas mini, water heater, AC 1 PK, pantry mini, balkon', 'tersedia');

-- --------------------------------------------------------
-- 2. Struktur Tabel `penghuni` (Dikerjakan oleh Anggota 2)
-- --------------------------------------------------------
CREATE TABLE `penghuni` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `kamar_id` INT NOT NULL,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `nik` VARCHAR(20) NOT NULL,
    `no_hp` VARCHAR(20) NOT NULL,
    `tgl_masuk` DATE NOT NULL,
    `tgl_keluar` DATE NULL,
    `status_sewa` ENUM('aktif', 'selesai') NOT NULL DEFAULT 'aktif',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_penghuni_kamar` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Data Awal (Dummy Data) Penghuni untuk Pengujian & Demo
-- --------------------------------------------------------
INSERT INTO `penghuni` (`id`, `kamar_id`, `nama_lengkap`, `nik`, `no_hp`, `tgl_masuk`, `tgl_keluar`, `status_sewa`) VALUES
(1, 1, 'Budi Santoso', '3201123456780002', '082198765432', '2026-01-10', NULL, 'aktif'),
(2, 3, 'Ahmad Fauzi', '3507123456780001', '081234567890', '2026-01-15', NULL, 'aktif'),
(3, 5, 'Siti Rahmawati', '3302123456780003', '085712341234', '2026-02-01', NULL, 'aktif'),
(4, 2, 'Dimas Pratama', '3578123456780004', '081398761122', '2025-08-01', '2025-12-31', 'selesai');
