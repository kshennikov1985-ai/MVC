<?php
/**
 * bootstrap.php — единая точка загрузки приложения.
 *
 * Подключает конфиг, автозагрузчик и стартует сессию.
 * Сюда же в будущем можно добавить: обработчики ошибок,
 * тайм-зону, подключение внешних библиотек и т.п.
 *
 * index.php подключает этот файл и запускает Router.
 */

define('BASE_PATH', __DIR__);

require BASE_PATH . '/config/config.php';
require BASE_PATH . '/core/Autoloader.php';

// Если в конфиге задан конкретный протокол (не 'auto') и запрос пришёл
// по другому — редиректим на нужный. Работает и в http->https, и в https->http.
if (APP_SCHEME !== 'auto' && CURRENT_SCHEME !== APP_SCHEME && PHP_SAPI !== 'cli') {
    $redirectUrl = APP_SCHEME . '://' . SITE_HOST . ($_SERVER['REQUEST_URI'] ?? '/');
    header('Location: ' . $redirectUrl, true, 301);
    exit;
}

// Сессия нужна почти везде: авторизация, флеш-сообщения между редиректами
Session::start();
