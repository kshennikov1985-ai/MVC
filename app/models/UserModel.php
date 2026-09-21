<?php
class UserModel extends Model
{
    public function getAll(): array
    {
        return $this->db->all('SELECT id, name, email, created_at FROM users ORDER BY id DESC');
    }

    public function getById(int $id): array|false
    {
        return $this->db->one('SELECT id, name, email, created_at FROM users WHERE id = ?', [$id]);
    }

    /** Возвращает всю строку, включая хэш пароля — используется только для логина */
    public function findByEmail(string $email): array|false
    {
        return $this->db->one('SELECT * FROM users WHERE email = ?', [$email]);
    }

    public function createWithPassword(string $name, string $email, string $plainPassword): string
    {
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);

        $this->db->execute(
            'INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())',
            [$name, $email, $hash]
        );

        return $this->db->lastInsertId();
    }

    public function search(string $query): array
    {
        $like = '%' . $query . '%';
        return $this->db->all(
            'SELECT id, name, email FROM users WHERE name LIKE ? OR email LIKE ? LIMIT 20',
            [$like, $like]
        );
    }
}
