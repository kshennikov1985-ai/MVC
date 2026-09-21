<?php
class NewsController extends Controller
{
    private const PER_PAGE = 5;

    /** GET /news/index/page/2 */
    public function indexAction(array $params): void
    {
        $page = max(1, (int)($params['page'] ?? 1));

        /** @var NewsModel $newsModel */
        $newsModel = $this->model('news');

        $total      = $newsModel->countAll();
        $totalPages = max(1, (int)ceil($total / self::PER_PAGE));
        $page       = min($page, $totalPages);

        $items = $newsModel->getPaginated($page, self::PER_PAGE);

        $this->render('news/index', [
            'title'      => 'Новости',
            'items'      => $items,
            'page'       => $page,
            'totalPages' => $totalPages,
        ]);
    }

    /** GET /news/view/slug/some-news-slug */
    public function viewAction(array $params): void
    {
        $slug = $params['slug'] ?? '';

        /** @var NewsModel $newsModel */
        $newsModel = $this->model('news');
        $item = $newsModel->getBySlug($slug);

        if (!$item) {
            http_response_code(404);
            $this->render('news/view', ['title' => 'Новость не найдена', 'item' => null]);
            return;
        }

        $this->render('news/view', [
            'title' => $item['title'],
            'item'  => $item,
        ]);
    }
}
