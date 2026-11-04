<?php
http_response_code(422);
$baseUrl = defined('BASE_URL') ? BASE_URL : '';
$errorMessage = $message ?? $_SESSION['flash_error'] ?? 'Data formulir yang Anda kirimkan tidak lengkap atau tidak valid.';
$errorList = $errors ?? [];
$backUrl = $redirectBack ?? ($_SERVER['HTTP_REFERER'] ?? $baseUrl . '/');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>422 Validasi Gagal - Kost Griya Mandiri</title>
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
            max-width: 540px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
        }
        .error-code {
            font-size: 4.5rem;
            font-weight: 700;
            color: #b45309;
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
            margin-bottom: 20px;
        }
        .validation-box {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 6px;
            padding: 16px;
            text-align: left;
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
        <div class="error-code">422</div>
        <div class="error-title">Validasi Data Input Gagal</div>
        <p class="error-desc">
            Sistem tidak dapat memproses permintaan karena terdapat data yang tidak memenuhi format atau kolom wajib yang belum diisi.
        </p>

        <div class="validation-box">
            <h6 class="fw-semibold small mb-2" style="color: #92400e;">Rincian Kendala Validasi:</h6>
            <?php if (!empty($errorList)): ?>
                <ul class="mb-0 ps-3 small" style="color: #78350f;">
                    <?php foreach ($errorList as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="small" style="color: #78350f;">
                    <?= $errorMessage ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="<?= htmlspecialchars($backUrl) ?>" class="btn btn-primary btn-custom">
                ← Kembali Perbaiki Form
            </a>
            <a href="<?= $baseUrl ?>/" class="btn btn-outline-secondary btn-custom">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
