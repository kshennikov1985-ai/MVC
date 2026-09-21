<?php
/**
 * Базовая модель. Даёт доступ к БД через $this->db.
 */
abstract class Model
{
    protected Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }
}
