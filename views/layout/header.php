<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Sistem Manajemen Kost Griya Mandiri') ?></title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-body-bg: #f8fafc;
            --bs-body-color: #334155;
            --border-color: #e2e8f0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Navbar bersih dan datar (flat) */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-brand {
            font-weight: 600;
            color: #0f172a !important;
            font-size: 1.05rem;
            letter-spacing: -0.01em;
        }
        .nav-link {
            font-size: 0.875rem;
            color: #475569 !important;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            color: #0f172a !important;
        }
        /* Kartu admin tanpa bayangan lebay */
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        /* Tabel bergaya modern human-made */
        .table-custom thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
            padding: 10px 16px;
        }
        .table-custom tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.875rem;
        }
        /* Status Badge Fungsional */
        .badge-tersedia {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 4px 10px;
            font-weight: 500;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-terisi {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
            padding: 4px 10px;
            font-weight: 500;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: inline-block;
        }
        /* Form input tegas */
        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 8px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .btn {
            font-size: 0.875rem;
            border-radius: 6px;
            font-weight: 500;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8125rem;
        }
    </style>
</head>
<body>
<?php
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
if ($scriptDir !== '/' && $scriptDir !== '.' && str_starts_with($requestPath, $scriptDir)) {
    $requestPath = substr($requestPath, strlen($scriptDir));
}
$requestPath = '/' . trim($requestPath, '/');

$isPenghuni = str_starts_with($requestPath, '/penghuni');
$isKamar = str_starts_with($requestPath, '/kamar');
$isDashboard = ($requestPath === '/' || $requestPath === '/dashboard' || (!$isPenghuni && !$isKamar));
?>
<nav class="navbar navbar-expand-lg navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/">
            🏠 Kost Griya Mandiri
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto align-items-lg-center gap-1">
                <a class="nav-link px-3 <?= $isDashboard ? 'active fw-semibold text-primary' : '' ?>" href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/">Dashboard</a>
                <a class="nav-link px-3 <?= $isKamar ? 'active fw-semibold text-primary' : '' ?>" href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/kamar">Daftar Kamar</a>
                <a class="nav-link px-3 <?= $isPenghuni ? 'active fw-semibold text-primary' : '' ?>" href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/penghuni">Data Penghuni</a>
                <a class="btn btn-outline-primary btn-sm ms-lg-2" href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/penghuni/tambah">+ Check-in</a>
                <a class="btn btn-primary btn-sm ms-1" href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/kamar/tambah">+ Tambah Kamar</a>
            </div>
        </div>
    </div>
</nav>
<div class="container pb-5 flex-grow-1">
