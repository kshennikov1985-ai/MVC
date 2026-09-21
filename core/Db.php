<?php
/**
 * Db — обёртка над PDO (singleton).
 * Все модели работают через этот класс.
 */
class Db
{
    private static ?Db $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            if (DEBUG) {
                die('Ошибка подключения к БД: ' . $e->getMessage());
            }
            die('Ошибка подключения к базе данных.');
        }
    }

    public static function getInstance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /** Универсальный запрос с подготовленными параметрами */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /** Вернуть все строки */
    public function all(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /** Вернуть одну строку */
    public function one(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    /** INSERT/UPDATE/DELETE, вернёт число задетых строк */
    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
