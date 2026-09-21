<?php
/**
 * Front Controller — единая точка входа для веб-сервера.
 * Все запросы направляются сюда через .htaccess.
 */

require_once __DIR__ . '/bootstrap.php';

$router = new Router();
$router->run();
