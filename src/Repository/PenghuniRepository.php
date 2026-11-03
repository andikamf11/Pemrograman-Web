<?php

namespace App\Repository;

use PDO;
use Throwable;

/**
 * Repository Penghuni - Menangani interaksi query PDO tabel `penghuni` dan relasi dengan tabel `kamar`
 * Sesuai Tugas Anggota 2 (Business Logic & Relational Data)
 */
class PenghuniRepository
{
    private PDO $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo ?? (require __DIR__ . '/../config/koneksi.php');
    }

    /**
     * Mengambil semua penghuni yang berstatus aktif beserta informasi kamarnya
     */
    public function allActive(): array
    {
        $sql = "
            SELECT 
                p.*, 
                k.nomor AS nomor_kamar, 
                k.tipe AS tipe_kamar, 
                k.harga AS harga_bulanan 
            FROM penghuni p 
            JOIN kamar k ON p.kamar_id = k.id 
            WHERE p.status_sewa = 'aktif'
            ORDER BY p.tgl_masuk DESC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Mengambil seluruh riwayat data penghuni (aktif maupun yang sudah selesai)
     */
    public function all(): array
    {
        $sql = "
            SELECT 
                p.*, 
                k.nomor AS nomor_kamar, 
                k.tipe AS tipe_kamar, 
                k.harga AS harga_bulanan 
            FROM penghuni p 
            JOIN kamar k ON p.kamar_id = k.id 
            ORDER BY p.id DESC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Mengambil satu data penghuni berdasarkan ID
     */
    public function find(int $id): ?array
    {
        $sql = "
            SELECT 
                p.*, 
                k.nomor AS nomor_kamar, 
                k.tipe AS tipe_kamar, 
                k.harga AS harga_bulanan 
            FROM penghuni p 
            JOIN kamar k ON p.kamar_id = k.id 
            WHERE p.id = ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Mengambil daftar kamar yang statusnya masih 'tersedia' untuk dropdown form pendaftaran
     */
    public function getAvailableRooms(): array
    {
        $stmt = $this->db->query("
            SELECT * FROM kamar 
            WHERE status = 'tersedia' 
            ORDER BY nomor ASC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Transaksi Check-in Penghuni Baru:
     * 1. Memverifikasi kamar masih 'tersedia'
     * 2. Insert record baru ke tabel `penghuni`
     * 3. Update status kamar menjadi 'terisi'
     */
    public function checkIn(int $kamarId, string $namaLengkap, string $noHp, string $nik, string $tglMasuk): bool
    {
        try {
            $this->db->beginTransaction();

            // Cek ketersediaan kamar
            $stmtCek = $this->db->prepare("SELECT status FROM kamar WHERE id = ?");
            $stmtCek->execute([$kamarId]);
            $kamar = $stmtCek->fetch();

            if (!$kamar || $kamar['status'] !== 'tersedia') {
                $this->db->rollBack();
                return false;
            }

            // Simpan data penghuni baru
            $stmtPenghuni = $this->db->prepare("
                INSERT INTO penghuni (kamar_id, nama_lengkap, no_hp, nik, tgl_masuk, status_sewa)
                VALUES (?, ?, ?, ?, ?, 'aktif')
            ");
            $stmtPenghuni->execute([$kamarId, $namaLengkap, $noHp, $nik, $tglMasuk]);

            // Ubah status kamar menjadi 'terisi'
            $stmtKamar = $this->db->prepare("UPDATE kamar SET status = 'terisi' WHERE id = ?");
            $stmtKamar->execute([$kamarId]);

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    /**
     * Transaksi Checkout Penghuni:
     * 1. Validasi status sewa penghuni masih aktif
     * 2. Update status sewa penghuni menjadi 'selesai' dan catat tanggal keluar
     * 3. Kembalikan status kamar menjadi 'tersedia'
     */
    public function checkOut(int $penghuniId, ?int $kamarId = null, ?string $tglKeluar = null): bool
    {
        try {
            $this->db->beginTransaction();

            // Cari kamar_id dan pastikan penghuni aktif jika kamarId tidak disertakan
            if ($kamarId === null) {
                $stmt = $this->db->prepare("SELECT kamar_id, status_sewa FROM penghuni WHERE id = ?");
                $stmt->execute([$penghuniId]);
                $penghuni = $stmt->fetch();

                if (!$penghuni || $penghuni['status_sewa'] !== 'aktif') {
                    $this->db->rollBack();
                    return false;
                }
                $kamarId = (int)$penghuni['kamar_id'];
            }

            $tglKeluar = $tglKeluar ?? date('Y-m-d');

            // Update status penghuni
            $stmtPenghuni = $this->db->prepare("
                UPDATE penghuni 
                SET status_sewa = 'selesai', tgl_keluar = ? 
                WHERE id = ?
            ");
            $stmtPenghuni->execute([$tglKeluar, $penghuniId]);

            // Kembalikan status kamar menjadi 'tersedia'
            $stmtKamar = $this->db->prepare("UPDATE kamar SET status = 'tersedia' WHERE id = ?");
            $stmtKamar->execute([$kamarId]);

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}

