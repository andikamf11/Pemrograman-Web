<?php

/**
 * Konfigurasi Koneksi Database Menggunakan PDO
 * Sesuai Slide 9 Pemrograman Web (PHP PDO)
 */

$host = 'localhost';
$dbname = 'db_kostan';
$username = 'root';
$password = '';

try {
    return new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die('<div style="font-family: -apple-system, BlinkMacSystemFont, sans-serif; padding: 24px; max-width: 600px; margin: 40px auto; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #991b1b;">' .
        '<h3 style="margin-top: 0; font-size: 1.1rem; color: #b91c1c;">Gagal Terhubung ke Database MySQL</h3>' .
        '<p style="font-size: 0.9rem; line-height: 1.5; color: #4b5563;">' .
        'Pastikan service MySQL di Laragon / XAMPP sudah berjalan aktif, dan database <code>db_kostan</code> telah dibuat/diimpor dari file <code>database.sql</code>.' .
        '</p>' .
        '<p style="font-size: 0.8rem; background: #fee2e2; padding: 8px 12px; border-radius: 4px; font-family: monospace; color: #7f1d1d; word-break: break-all;">' .
        htmlspecialchars($e->getMessage()) .
        '</p>' .
        '</div>');
}
