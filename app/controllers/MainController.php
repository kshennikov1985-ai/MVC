<?php
class MainController extends Controller
{
    public function indexAction(): void
    {
        /** @var NewsModel $newsModel */
        $newsModel = $this->model('news');

        $this->render('main/index', [
            'title'      => 'Главная страница',
            'latestNews' => $newsModel->getLatest(3),
        ]);
    }
}
