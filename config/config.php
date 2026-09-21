<?php
// ==========================================
// Общая конфигурация приложения
// ==========================================

// --- База данных ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'mvc_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// --- Приложение ---
// BASE_PATH задаётся в bootstrap.php (до подключения этого файла)
define('BASE_URL', '/');                         // если сайт в подпапке, укажи '/subfolder/'

// --- Протокол (http/https) ---
// 'auto'  — работать по тому протоколу, который определит сервер (по умолчанию)
// 'http'  — принудительно работать по http (https-запросы редиректятся на http)
// 'https' — принудительно работать по https (http-запросы редиректятся на https)
define('APP_SCHEME', 'auto');

/** Определяет реальный протокол текущего запроса (учитывает reverse-proxy) */
function detectRequestScheme(): string
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return 'https';
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        return strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https' ? 'https' : 'http';
    }
    if (($_SERVER['SERVER_PORT'] ?? null) == 443) {
        return 'https';
    }
    return 'http';
}

define('CURRENT_SCHEME', detectRequestScheme());
define('SITE_SCHEME', APP_SCHEME === 'auto' ? CURRENT_SCHEME : APP_SCHEME);
define('SITE_HOST', $_SERVER['HTTP_HOST'] ?? 'localhost');
define('SITE_URL', SITE_SCHEME . '://' . SITE_HOST . BASE_URL); // полный адрес сайта, с нужным протоколом

define('DEFAULT_CONTROLLER', 'main');             // контроллер по умолчанию
define('DEFAULT_ACTION', 'index');                // action по умолчанию

// --- Отладка ---
define('DEBUG', true);

if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
