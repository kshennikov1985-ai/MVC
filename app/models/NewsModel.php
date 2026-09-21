<?php
class NewsModel extends Model
{
    /**
     * @param int $page    номер страницы (с 1)
     * @param int $perPage кол-во новостей на страницу
     */
    public function getPaginated(int $page, int $perPage = 5): array
    {
        $page    = max(1, $page);
        $perPage = max(1, $perPage);
        $offset  = ($page - 1) * $perPage;

        // LIMIT/OFFSET подставляются напрямую (не через bind), т.к. это
        // проверенные целые числа — так надёжнее работает с PDO в режиме
        // "родных" prepared statements (ATTR_EMULATE_PREPARES = false).
        $sql = "SELECT id, title, slug, excerpt, created_at
                FROM news
                ORDER BY created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        return $this->db->all($sql);
    }

    public function countAll(): int
    {
        $row = $this->db->one('SELECT COUNT(*) AS cnt FROM news');
        return (int)($row['cnt'] ?? 0);
    }

    public function getBySlug(string $slug): array|false
    {
        return $this->db->one('SELECT * FROM news WHERE slug = ?', [$slug]);
    }

    public function getLatest(int $limit = 3): array
    {
        $limit = max(1, $limit);
        return $this->db->all("SELECT id, title, slug, excerpt, created_at FROM news ORDER BY created_at DESC LIMIT {$limit}");
    }
}
