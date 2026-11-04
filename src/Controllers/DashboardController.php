<?php

namespace App\Controllers;

use PDO;

/**
 * DashboardController - Menghitung dan menyajikan ringkasan analitik operasional kost
 * Sesuai Tugas Anggota 3 (Dashboard Analytics, QA & UX Polish)
 */
class DashboardController
{
    private PDO $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo ?? (require __DIR__ . '/../config/koneksi.php');
    }

    /**
     * Helper untuk render view template
     */
    private function render(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../../views/layout/header.php';
        require_once __DIR__ . "/../../views/{$view}.php";
        require_once __DIR__ . '/../../views/layout/footer.php';
    }

    /**
     * Menampilkan dashboard ringkasan statistik kost
     */
    public function index(): void
    {
        // 1. Total seluruh kamar
        $stmtTotal = $this->db->query("SELECT COUNT(*) FROM kamar");
        $totalKamar = (int)$stmtTotal->fetchColumn();

        // 2. Jumlah kamar terisi
        $stmtTerisi = $this->db->query("SELECT COUNT(*) FROM kamar WHERE status = 'terisi'");
        $kamarTerisi = (int)$stmtTerisi->fetchColumn();

        // 3. Jumlah kamar tersedia / kosong
        $stmtTersedia = $this->db->query("SELECT COUNT(*) FROM kamar WHERE status = 'tersedia'");
        $kamarTersedia = (int)$stmtTersedia->fetchColumn();

        // 4. Estimasi omzet pemasukan per bulan dari kamar yang berstatus terisi
        $stmtOmzet = $this->db->query("SELECT COALESCE(SUM(harga), 0) FROM kamar WHERE status = 'terisi'");
        $estimasiOmzet = (float)$stmtOmzet->fetchColumn();

        // 5. Total penghuni aktif
        $stmtPenghuni = $this->db->query("SELECT COUNT(*) FROM penghuni WHERE status_sewa = 'aktif'");
        $totalPenghuni = (int)$stmtPenghuni->fetchColumn();

        // 6. Data penghuni aktif terkini (Maksimal 5 orang untuk ringkasan)
        $stmtPenghuniAktif = $this->db->query("
            SELECT p.*, k.nomor AS nomor_kamar, k.tipe AS tipe_kamar, k.harga AS harga_bulanan 
            FROM penghuni p 
            JOIN kamar k ON p.kamar_id = k.id 
            WHERE p.status_sewa = 'aktif'
            ORDER BY p.tgl_masuk DESC 
            LIMIT 5
        ");
        $penghuniTerbaru = $stmtPenghuniAktif->fetchAll();

        // 7. Daftar kamar kosong yang siap disewakan (Maksimal 5 kamar)
        $stmtKamarKosong = $this->db->query("
            SELECT * FROM kamar 
            WHERE status = 'tersedia' 
            ORDER BY nomor ASC 
            LIMIT 5
        ");
        $kamarKosongList = $stmtKamarKosong->fetchAll();

        // Persentase okupansi
        $okupansiPersen = $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0;

        $this->render('dashboard/index', [
            'title' => 'Dashboard Ringkasan Operasional - Kost Griya Mandiri',
            'totalKamar' => $totalKamar,
            'kamarTerisi' => $kamarTerisi,
            'kamarTersedia' => $kamarTersedia,
            'estimasiOmzet' => $estimasiOmzet,
            'totalPenghuni' => $totalPenghuni,
            'okupansiPersen' => $okupansiPersen,
            'penghuniTerbaru' => $penghuniTerbaru,
            'kamarKosongList' => $kamarKosongList,
        ]);
    }
}
