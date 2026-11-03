<?php

namespace App\Controllers;

use App\Repository\KamarRepository;

/**
 * KamarController - Mengatur alur logika CRUD Kamar
 */
class KamarController
{
    private KamarRepository $kamarRepo;

    public function __construct(?KamarRepository $repo = null)
    {
        $this->kamarRepo = $repo ?? new KamarRepository();
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
     * Menampilkan daftar seluruh kamar
     */
    public function index(): void
    {
        $kamars = $this->kamarRepo->all();
        $this->render('kamar/index', [
            'title' => 'Daftar Kamar Kost - Griya Mandiri',
            'kamars' => $kamars,
        ]);
    }

    /**
     * Menampilkan form penambahan kamar baru
     */
    public function create(): void
    {
        $old = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);

        $this->render('kamar/create', [
            'title' => 'Tambah Kamar Baru - Griya Mandiri',
            'old' => $old,
        ]);
    }

    /**
     * Memproses penyimpanan kamar baru (Post/Redirect/Get)
     */
    public function store(): void
    {
        $nomor = trim($_POST['nomor'] ?? '');
        $tipe = trim($_POST['tipe'] ?? '');
        $harga = trim($_POST['harga'] ?? '');
        $fasilitas = trim($_POST['fasilitas'] ?? '');

        $errors = [];

        // Validasi input
        if ($nomor === '') {
            $errors[] = 'Nomor kamar tidak boleh kosong.';
        } elseif ($this->kamarRepo->existsByNomor($nomor)) {
            $errors[] = 'Nomor Kamar sudah terdaftar, silakan gunakan nomor lain.';
        }

        if ($tipe === '') {
            $errors[] = 'Tipe kamar wajib dipilih.';
        }

        if ($harga === '') {
            $errors[] = 'Harga sewa tidak boleh kosong.';
        } elseif (!is_numeric($harga) || (float)$harga <= 0) {
            $errors[] = 'Harga sewa harus berupa angka positif lebih dari 0.';
        }

        // Jika terdapat error validasi
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            $_SESSION['old_input'] = $_POST;
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar/tambah';
            header("Location: {$redirectUrl}");
            exit;
        }

        // Simpan data kamar baru
        $this->kamarRepo->save($nomor, $tipe, (float)$harga, $fasilitas);

        // Pola PRG (Post/Redirect/Get)
        $_SESSION['flash_success'] = "Data Kamar <strong>" . htmlspecialchars($nomor) . "</strong> berhasil ditambahkan.";
        $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
        header("Location: {$redirectUrl}");
        exit;
    }

    /**
     * Menampilkan form edit data kamar
     */
    public function edit(?string $id = null): void
    {
        $kamarId = (int)($id ?? $_GET['id'] ?? 0);
        $kamar = $this->kamarRepo->find($kamarId);

        if (!$kamar) {
            $_SESSION['flash_error'] = 'Data kamar yang dicari tidak ditemukan.';
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
            header("Location: {$redirectUrl}");
            exit;
        }

        $this->render('kamar/edit', [
            'title' => 'Edit Kamar ' . htmlspecialchars($kamar['nomor']) . ' - Griya Mandiri',
            'kamar' => $kamar,
        ]);
    }

    /**
     * Memproses update data kamar (Post/Redirect/Get)
     */
    public function update(?string $id = null): void
    {
        $kamarId = (int)($id ?? $_POST['id'] ?? 0);
        $kamar = $this->kamarRepo->find($kamarId);

        if (!$kamar) {
            $_SESSION['flash_error'] = 'Data kamar tidak ditemukan untuk diperbarui.';
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
            header("Location: {$redirectUrl}");
            exit;
        }

        $nomor = trim($_POST['nomor'] ?? '');
        $tipe = trim($_POST['tipe'] ?? '');
        $harga = trim($_POST['harga'] ?? '');
        $fasilitas = trim($_POST['fasilitas'] ?? '');
        $status = trim($_POST['status'] ?? $kamar['status']);

        $errors = [];

        // Validasi
        if ($nomor === '') {
            $errors[] = 'Nomor kamar tidak boleh kosong.';
        } elseif ($this->kamarRepo->existsByNomor($nomor, $kamarId)) {
            $errors[] = 'Nomor Kamar sudah terdaftar, silakan gunakan nomor lain.';
        }

        if ($tipe === '') {
            $errors[] = 'Tipe kamar wajib dipilih.';
        }

        if ($harga === '') {
            $errors[] = 'Harga sewa tidak boleh kosong.';
        } elseif (!is_numeric($harga) || (float)$harga <= 0) {
            $errors[] = 'Harga sewa harus berupa angka positif lebih dari 0.';
        }

        if (!in_array($status, ['tersedia', 'terisi'])) {
            $status = $kamar['status'];
        }

        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar/edit/' . $kamarId;
            header("Location: {$redirectUrl}");
            exit;
        }

        // Jalankan update
        $this->kamarRepo->update($kamarId, $nomor, $tipe, (float)$harga, $fasilitas, $status);

        // PRG Redirect
        $_SESSION['flash_success'] = "Perubahan data Kamar <strong>" . htmlspecialchars($nomor) . "</strong> berhasil disimpan.";
        $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
        header("Location: {$redirectUrl}");
        exit;
    }

    /**
     * Memproses penghapusan data kamar dengan proteksi status
     */
    public function delete(?string $id = null): void
    {
        $kamarId = (int)($id ?? $_POST['id'] ?? $_GET['id'] ?? 0);
        $kamar = $this->kamarRepo->find($kamarId);

        if (!$kamar) {
            $_SESSION['flash_error'] = 'Data kamar yang akan dihapus tidak ditemukan.';
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
            header("Location: {$redirectUrl}");
            exit;
        }

        // Proteksi Penting: Cek status kamar, tolak hapus jika status masih 'terisi'
        if ($kamar['status'] === 'terisi') {
            $_SESSION['flash_error'] = "Kamar <strong>" . htmlspecialchars($kamar['nomor']) . "</strong> tidak dapat dihapus karena status masih <strong>Terisi</strong>.";
            $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
            header("Location: {$redirectUrl}");
            exit;
        }

        // Hapus kamar
        $this->kamarRepo->delete($kamarId);

        // PRG Redirect
        $_SESSION['flash_success'] = "Data Kamar <strong>" . htmlspecialchars($kamar['nomor']) . "</strong> berhasil dihapus.";
        $redirectUrl = (defined('BASE_URL') ? BASE_URL : '') . '/kamar';
        header("Location: {$redirectUrl}");
        exit;
    }
}
