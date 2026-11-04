<?php
http_response_code(404);
$baseUrl = defined('BASE_URL') ? BASE_URL : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Halaman Tidak Ditemukan - Kost Griya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            color: #334155;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            max-width: 520px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
        }
        .error-code {
            font-size: 4.5rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1;
            letter-spacing: -0.04em;
            margin-bottom: 8px;
        }
        .error-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .error-desc {
            color: #64748b;
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .route-badge {
            background-color: #f1f5f9;
            color: #475569;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-family: monospace;
            display: inline-block;
            margin-bottom: 24px;
        }
        .btn-custom {
            font-size: 0.875rem;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">404</div>
        <div class="error-title">Halaman Tidak Ditemukan</div>
        <p class="error-desc">
            Maaf, tautan atau alamat rute yang Anda tuju tidak terdaftar pada sistem aplikasi ini.
        </p>
        <?php if (!empty($path)): ?>
            <div class="route-badge">
                Rute: <?= htmlspecialchars($path) ?>
            </div>
        <?php endif; ?>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="<?= $baseUrl ?>/" class="btn btn-primary btn-custom">
                Kembali ke Dashboard
            </a>
            <a href="<?= $baseUrl ?>/kamar" class="btn btn-outline-secondary btn-custom">
                Daftar Kamar
            </a>
            <a href="<?= $baseUrl ?>/penghuni" class="btn btn-outline-secondary btn-custom">
                Data Penghuni
            </a>
        </div>
    </div>
</body>
</html>
