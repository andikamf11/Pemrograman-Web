<?php

namespace App\Core;

/**
 * Core Router - Menangani routing HTTP GET dan POST
 * Sesuai Slide 7 Pemrograman Web
 */
class Router
{
    private array $routes = [];

    /**
     * Mendaftarkan rute HTTP GET
     */
    public function get(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Mendaftarkan rute HTTP POST
     */
    public function post(string $path, array|callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Menyimpan rute ke dalam koleksi internal
     */
    private function addRoute(string $method, string $path, array|callable $handler): void
    {
        $path = '/' . trim($path, '/');
        $this->routes[$method][$path] = $handler;
    }

    /**
     * Melakukan dispatching rute berdasarkan URI dan HTTP Method
     */
    public function dispatch(string $uri, string $method): void
    {
        // 1. Ambil path murni tanpa query string
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // 2. Normalisasi jika aplikasi berjalan dalam subfolder (misal Apache localhost/UTS/app-kost/public)
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        if ($scriptDir !== '/' && $scriptDir !== '.' && str_starts_with($path, $scriptDir)) {
            $path = substr($path, strlen($scriptDir));
        }

        $path = '/' . trim($path, '/');
        $method = strtoupper($method);

        // 3. Cek pencocokan rute persis (exact match)
        if (isset($this->routes[$method][$path])) {
            $this->executeHandler($this->routes[$method][$path]);
            return;
        }

        // 4. Cek pencocokan rute dinamis dengan parameter, misal /kamar/edit/{id}
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $handler) {
                if (str_contains($route, '{')) {
                    $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([^/]+)', $route);
                    $pattern = '#^' . $pattern . '$#';

                    if (preg_match($pattern, $path, $matches)) {
                        array_shift($matches); // Hilangkan elemen full match
                        $this->executeHandler($handler, $matches);
                        return;
                    }
                }
            }
        }

        // 5. Tampilkan respon 404 jika rute tidak ditemukan
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>404 Halaman Tidak Ditemukan</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '</head><body class="bg-light d-flex align-items-center justify-content-center vh-100 text-center">';
        echo '<div class="card p-5 border shadow-sm" style="max-width: 480px; border-radius: 8px;">';
        echo '<h1 class="display-6 fw-bold text-dark mb-2">404</h1>';
        echo '<h5 class="fw-semibold text-secondary mb-3">Halaman Tidak Ditemukan</h5>';
        echo '<p class="text-muted small mb-4">Rute <code>' . htmlspecialchars($path) . '</code> tidak terdaftar pada sistem aplikasi ini.</p>';
        echo '<a href="' . (defined('BASE_URL') ? BASE_URL : '') . '/kamar" class="btn btn-primary btn-sm">Kembali ke Daftar Kamar</a>';
        echo '</div></body></html>';
    }

    /**
     * Menjalankan handler rute (Callback atau Controller method)
     */
    private function executeHandler(array|callable $handler, array $params = []): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_array($handler)) {
            [$class, $method] = $handler;
            if (class_exists($class)) {
                $controller = new $class();
                if (method_exists($controller, $method)) {
                    call_user_func_array([$controller, $method], $params);
                    return;
                }
            }
        }

        http_response_code(500);
        echo "500 - Kesalahan Handler: Controller atau method tujuan tidak ditemukan.";
    }
}
