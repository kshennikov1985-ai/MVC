<?php
/**
 * Базовый контроллер. Все контроллеры наследуются от него.
 */
abstract class Controller
{
    protected array $params;
    protected View $view;

    public function __construct(array $params = [])
    {
        $this->params = $params;
        $this->view   = new View();
    }

    /** Подключить модель по имени: user -> UserModel */
    protected function model(string $name): mixed
    {
        $class = ucfirst($name) . 'Model';
        $file  = BASE_PATH . '/app/models/' . $class . '.php';

        if (!is_file($file)) {
            throw new RuntimeException("Модель {$class} не найдена");
        }

        require_once $file;
        return new $class();
    }

    /** Отрисовать html-шаблон: render('user/view', ['user' => $user]) */
    protected function render(string $viewPath, array $data = []): void
    {
        $this->view->render($viewPath, $data);
    }

    /** Ответ в формате JSON (используется в AJAX-действиях) */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /** Проверка, что запрос пришёл через AJAX (fetch/XHR) */
    protected function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /** Редирект на другой url в рамках приложения */
    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . ltrim($path, '/'));
        exit;
    }

    protected function isLoggedIn(): bool
    {
        return Session::has('user_id');
    }

    /** Принудительно требовать авторизацию в action-методе */
    protected function requireAuth(): void
    {
        if (!$this->isLoggedIn()) {
            Session::flash('error', 'Сначала войдите в систему');
            $this->redirect('auth/login');
        }
    }
}
