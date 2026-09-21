<?php
/**
 * Простой автозагрузчик. Ищет классы в core/, models/, controllers/.
 * Контроллеры и модели чаще подключаются вручную (Router/Controller),
 * но автозагрузчик подстрахует любые прямые обращения к классам.
 */
spl_autoload_register(function (string $class) {
    $dirs = [
        BASE_PATH . '/core/',
        BASE_PATH . '/app/models/',
        BASE_PATH . '/app/controllers/',
    ];

    foreach ($dirs as $dir) {
        $file = $dir . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});
