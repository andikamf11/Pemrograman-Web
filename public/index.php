<?php

/**
 * Front Controller - Single Entry Point
 * Sesuai Slide 6 Pemrograman Web
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\KamarController;

// Inisialisasi session untuk flash message / notifikasi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi BASE_URL otomatis agar fleksibel dijalankan di root virtualhost maupun sub-folder Apache
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseUrl = ($scriptDir === '/' || $scriptDir === '\\' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');
define('BASE_URL', $baseUrl);

$router = new Router();

// ==========================================
// Rute Modul Kamar (Tugas Anggota 1)
// ==========================================
$router->get('/', [KamarController::class, 'index']);
$router->get('/kamar', [KamarController::class, 'index']);

// Form tambah & simpan data kamar (PRG pattern)
$router->get('/kamar/tambah', [KamarController::class, 'create']);
$router->post('/kamar/simpan', [KamarController::class, 'store']);
$router->post('/kamar/tambah', [KamarController::class, 'store']);

// Form edit & update data kamar
$router->get('/kamar/edit/{id}', [KamarController::class, 'edit']);
$router->get('/kamar/edit', [KamarController::class, 'edit']);
$router->post('/kamar/update/{id}', [KamarController::class, 'update']);
$router->post('/kamar/update', [KamarController::class, 'update']);

// Hapus data kamar dengan proteksi status 'terisi'
$router->post('/kamar/hapus/{id}', [KamarController::class, 'delete']);
$router->post('/kamar/hapus', [KamarController::class, 'delete']);
$router->get('/kamar/hapus/{id}', [KamarController::class, 'delete']);

// ==========================================
// Rute Placeholder Modul Anggota 2
// ==========================================
$router->get('/penghuni', function () {
    $title = 'Data Penghuni Kost';
    require_once __DIR__ . '/../views/layout/header.php';
    ?>
    <div class="card card-custom p-5 text-center my-4">
        <h4 class="fw-semibold text-dark mb-2">Modul Data Penghuni</h4>
        <p class="text-secondary small mb-3">Modul ini akan dikembangkan oleh <strong>Anggota 2</strong> (Check-in, Checkout, Riwayat).</p>
        <div>
            <a href="<?= BASE_URL ?>/kamar" class="btn btn-outline-primary btn-sm">Kembali ke Daftar Kamar</a>
        </div>
    </div>
    <?php
    require_once __DIR__ . '/../views/layout/footer.php';
});

// Jalankan Dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
