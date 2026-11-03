<?php

namespace App\Controllers;

use App\Repository\PenghuniRepository;
use App\Repository\KamarRepository;

/**
 * PenghuniController - Mengatur alur logika Check-in, Checkout, dan Riwayat Penghuni
 * Sesuai Tugas Anggota 2 (Business Logic & Relational Data Lead)
 */
class PenghuniController
{
    private PenghuniRepository $penghuniRepo;
    private KamarRepository $kamarRepo;

    public function __construct(?PenghuniRepository $repo = null, ?KamarRepository $kamarRepo = null)
    {
        $this->penghuniRepo = $repo ?? new PenghuniRepository();
        $this->kamarRepo = $kamarRepo ?? new KamarRepository();
    }

    /**
     * Helper untuk me-render view template
     */
    private function render(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../../views/layout/header.php';
        require_once __DIR__ . "/../../views/{$view}.php";
        require_once __DIR__ . '/../../views/layout/footer.php';
    }

    /**
     * Menampilkan daftar penghuni kost yang berstatus aktif
     */
    public function index(): void
    {
        $penghunis = $this->penghuniRepo->allActive();

        $this->render('penghuni/index', [
            'title' => 'Data Penghuni Aktif - Griya Mandiri',
            'penghunis' => $penghunis,
        ]);
    }

    /**
     * Menampilkan form pendaftaran penghuni baru (Check-in)
     * Hanya memuat daftar kamar yang statusnya 'tersedia'
     */
    public function create(): void
    {
        $availableRooms = $this->penghuniRepo->getAvailableRooms();
        $old = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);

        // Dukungan pre-selected kamar jika diarahkan dari halaman daftar kamar
        if (!isset($old['kamar_id']) && isset($_GET['kamar_id'])) {
            $old['kamar_id'] = (int)$_GET['kamar_id'];
        }

        $this->render('penghuni/create', [
            'title' => 'Check-in Penghuni Baru - Griya Mandiri',
            'availableRooms' => $availableRooms,
            'old' => $old,
        ]);
    }

    /**
     * Memproses penyimpanan data check-in penghuni baru (Pola Post/Redirect/Get)
     */
    public function store(): void
    {
        $namaLengkap = trim($_POST['nama_lengkap'] ?? '');
        $nik = trim($_POST['nik'] ?? '');
        $noHp = trim($_POST['no_hp'] ?? '');
        $kamarId = (int)($_POST['kamar_id'] ?? 0);
        $tglMasuk = trim($_POST['tgl_masuk'] ?? '');

        $errors = [];

        // 1. Validasi input wajib diisi
        if ($namaLengkap === '') {
            $errors[] = 'Nama lengkap penghuni wajib diisi.';
        }

        if ($nik === '') {
            $errors[] = 'Nomor Induk Kependudukan (NIK) wajib diisi.';
        } elseif (!preg_match('/^[0-9]{16,}$/', $nik)) {
            // Validasi panjang NIK minimal 16 digit dan hanya angka
            $errors[] = 'NIK harus berupa angka dengan panjang minimal 16 digit.';
        }

        if ($noHp === '') {
            $errors[] = 'Nomor HP/WhatsApp wajib diisi.';
        } elseif (!preg_match('/^[0-9]+$/', $noHp)) {
            // Validasi format nomor HP hanya angka
            $errors[] = 'Format nomor HP hanya boleh berisi angka (tanpa spasi atau tanda hubung).';
        }

        if ($kamarId <= 0) {
            $errors[] = 'Silakan pilih kamar yang tersedia.';
        } else {
            // Pastikan kamar yang dipilih memang ada dan berstatus 'tersedia'
            $kamar = $this->kamarRepo->find($kamarId);
            if (!$kamar || $kamar['status'] !== 'tersedia') {
                $errors[] = 'Kamar yang dipilih tidak valid atau sudah terisi.';
            }
        }

        if ($tglMasuk === '') {
            $errors[] = 'Tanggal masuk wajib diisi.';
        }

        // Jika terdapat error validasi
        if (!empty($errors)) {
            http_response_code(422);
            $_SESSION['flash_error'] = implode('<br>', $errors);
            $_SESSION['old_input'] = $_POST;
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/penghuni/tambah';
            header("Location: {$redirectUrl}");
            exit;
        }

        // Eksekusi transaksi check-in di Repository
        $success = $this->penghuniRepo->checkIn($kamarId, $namaLengkap, $noHp, $nik, $tglMasuk);

        if (!$success) {
            http_response_code(422);
            $_SESSION['flash_error'] = 'Gagal memproses check-in. Kamar yang dipilih mungkin baru saja ditempati.';
            $_SESSION['old_input'] = $_POST;
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/penghuni/tambah';
            header("Location: {$redirectUrl}");
            exit;
        }

        // Flash message sukses & redirect PRG
        $_SESSION['flash_success'] = "Check-in penghuni <strong>" . htmlspecialchars($namaLengkap) . "</strong> berhasil diproses. Status kamar otomatis diperbarui menjadi <strong>Terisi</strong>.";
        $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/penghuni';
        header("Location: {$redirectUrl}");
        exit;
    }

    /**
     * Memproses checkout penghuni dan mengembalikan status kamar menjadi tersedia
     */
    public function checkout(?string $id = null): void
    {
        $penghuniId = (int)($id ?? $_POST['penghuni_id'] ?? $_POST['id'] ?? $_GET['id'] ?? 0);
        $kamarId = isset($_POST['kamar_id']) ? (int)$_POST['kamar_id'] : null;
        $tglKeluar = !empty($_POST['tgl_keluar']) ? trim($_POST['tgl_keluar']) : date('Y-m-d');

        if ($penghuniId <= 0) {
            $_SESSION['flash_error'] = 'Identitas penghuni tidak valid untuk proses checkout.';
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/penghuni';
            header("Location: {$redirectUrl}");
            exit;
        }

        $penghuni = $this->penghuniRepo->find($penghuniId);
        if (!$penghuni || $penghuni['status_sewa'] !== 'aktif') {
            $_SESSION['flash_error'] = 'Data penghuni tidak ditemukan atau sudah tidak berstatus aktif.';
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/penghuni';
            header("Location: {$redirectUrl}");
            exit;
        }

        $kamarIdToFree = $kamarId ?? (int)$penghuni['kamar_id'];
        $success = $this->penghuniRepo->checkOut($penghuniId, $kamarIdToFree, $tglKeluar);

        if ($success) {
            $nama = htmlspecialchars($penghuni['nama_lengkap']);
            $nomorKamar = htmlspecialchars($penghuni['nomor_kamar'] ?? '');
            $_SESSION['flash_success'] = "Penghuni <strong>{$nama}</strong> berhasil di-checkout. Status Kamar <strong>{$nomorKamar}</strong> kini kembali <strong>Tersedia</strong>.";
        } else {
            $_SESSION['flash_error'] = 'Terjadi kesalahan saat memproses checkout penghuni.';
        }

        $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/penghuni';
        header("Location: {$redirectUrl}");
        exit;
    }
}

