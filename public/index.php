<?php

/**
 * Front Controller - Single Entry Point
 * Sesuai Slide 6 Pemrograman Web
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\KamarController;
use App\Controllers\PenghuniController;

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
// Rute Modul Dashboard (Tugas Anggota 3)
// ==========================================
$router->get('/', [DashboardController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);

// ==========================================
// Rute Modul Kamar (Tugas Anggota 1)
// ==========================================
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
// Rute Modul Penghuni (Tugas Anggota 2)
// ==========================================
$router->get('/penghuni', [PenghuniController::class, 'index']);
$router->get('/penghuni/tambah', [PenghuniController::class, 'create']);
$router->post('/penghuni/simpan', [PenghuniController::class, 'store']);
$router->post('/penghuni/tambah', [PenghuniController::class, 'store']);
$router->post('/penghuni/checkout/{id}', [PenghuniController::class, 'checkout']);
$router->post('/penghuni/checkout', [PenghuniController::class, 'checkout']);

// Jalankan Dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
