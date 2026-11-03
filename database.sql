-- ========================================================
-- Database Schema: db_kostan
-- Proyek: Sistem Informasi Manajemen Kamar & Penghuni Kost
-- ========================================================

CREATE DATABASE IF NOT EXISTS `db_kostan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_kostan`;

-- --------------------------------------------------------
-- Struktur Tabel `kamar` (Dikerjakan oleh Anggota 1)
-- --------------------------------------------------------
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
-- Data Awal (Dummy Data) Kamar untuk Pengujian
-- --------------------------------------------------------
INSERT INTO `kamar` (`nomor`, `tipe`, `harga`, `fasilitas`, `status`) VALUES
('101', 'Standard', 800000.00, 'Kasur busa single, lemari pakaian 1 pintu, kamar mandi luar, kipas angin, Wi-Fi', 'tersedia'),
('102', 'Deluxe', 1200000.00, 'Kasur springbed single, lemari 2 pintu, kamar mandi dalam, AC, Wi-Fi 50 Mbps', 'terisi'),
('103', 'Deluxe', 1250000.00, 'Kasur springbed queen, meja belajar & kursi, kamar mandi dalam, AC, Wi-Fi', 'tersedia'),
('201', 'VIP', 1700000.00, 'Kasur king size, smart TV 32 inch, kulkas mini, water heater, AC, balkon jemuran', 'tersedia'),
('202', 'Standard', 850000.00, 'Kasur single, lemari pakaian, jendela ventilasi luas, kamar mandi luar', 'tersedia');
