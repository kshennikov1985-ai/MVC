<?php
/**
 * Cookie — обёртка над $_COOKIE / setcookie().
 * Статический класс: не требует создания экземпляра.
 */
class Cookie
{
    public static function set(string $name, string $value, int $days = 30): bool
    {
        return setcookie($name, $value, [
            'expires'  => time() + $days * 86400,
            'path'     => '/',
            'secure'   => defined('SITE_SCHEME') ? SITE_SCHEME === 'https' : !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    public static function get(string $name, mixed $default = null): mixed
    {
        return $_COOKIE[$name] ?? $default;
    }

    public static function has(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    public static function delete(string $name): bool
    {
        unset($_COOKIE[$name]);
        return setcookie($name, '', [
            'expires' => time() - 3600,
            'path'    => '/',
        ]);
    }
}
