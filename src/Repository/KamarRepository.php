<?php

namespace App\Repository;

use PDO;

/**
 * Repository Kamar - Menangani interaksi langsung dengan database tabel `kamar`
 */
class KamarRepository
{
    private PDO $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo ?? (require __DIR__ . '/../config/koneksi.php');
    }

    /**
     * Mengambil seluruh data kamar dari database
     */
    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM kamar ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    /**
     * Mengambil satu data kamar berdasarkan ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM kamar WHERE id = ?");
        $stmt->execute([$id]);
        $kamar = $stmt->fetch();
        return $kamar ?: null;
    }

    /**
     * Memeriksa apakah nomor kamar sudah pernah terdaftar
     */
    public function existsByNomor(string $nomor, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM kamar WHERE nomor = ? AND id != ?");
            $stmt->execute([$nomor, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM kamar WHERE nomor = ?");
            $stmt->execute([$nomor]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Menyimpan data kamar baru ke dalam database
     */
    public function save(string $nomor, string $tipe, float $harga, ?string $fasilitas): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO kamar (nomor, tipe, harga, fasilitas, status)
            VALUES (?, ?, ?, ?, 'tersedia')
        ");
        return $stmt->execute([$nomor, $tipe, $harga, $fasilitas]);
    }

    /**
     * Memperbarui data kamar yang sudah ada
     */
    public function update(int $id, string $nomor, string $tipe, float $harga, ?string $fasilitas, ?string $status = null): bool
    {
        if ($status !== null) {
            $stmt = $this->db->prepare("
                UPDATE kamar 
                SET nomor = ?, tipe = ?, harga = ?, fasilitas = ?, status = ?
                WHERE id = ?
            ");
            return $stmt->execute([$nomor, $tipe, $harga, $fasilitas, $status, $id]);
        }

        $stmt = $this->db->prepare("
            UPDATE kamar 
            SET nomor = ?, tipe = ?, harga = ?, fasilitas = ?
            WHERE id = ?
        ");
        return $stmt->execute([$nomor, $tipe, $harga, $fasilitas, $id]);
    }

    /**
     * Menghapus record kamar berdasarkan ID
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM kamar WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
