<?php
/**
 * Router
 *
 * Формат URL:  /[controller]/[action]/[param]/[value]/[param]/[value]/...
 * Примеры:
 *   /user/view/id/5                -> UserController::view(['id' => '5'])
 *   /user/list/page/2/sort/name    -> UserController::listAction(['page'=>'2','sort'=>'name'])
 *   /                              -> MainController::index([])
 *
 * Если сегментов нечётное число (параметр без значения) — значению
 * присваивается null.
 */
class Router
{
    private string $controllerName = DEFAULT_CONTROLLER;
    private string $actionName     = DEFAULT_ACTION;
    private array  $params         = [];

    public function __construct()
    {
        $this->parseUri();
    }

    private function parseUri(): void
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // убираем query string (?foo=bar)
        $uri = parse_url($uri, PHP_URL_PATH) ?? '/';

        // убираем базовый путь (если сайт не в корне)
        if (BASE_URL !== '/' && str_starts_with($uri, BASE_URL)) {
            $uri = substr($uri, strlen(BASE_URL));
        } else {
            $uri = ltrim($uri, '/');
        }

        $uri = trim($uri, '/');

        if ($uri === '') {
            return; // используем DEFAULT_CONTROLLER / DEFAULT_ACTION
        }

        $segments = explode('/', $uri);
        $segments = array_map('urldecode', $segments);

        // [0] controller
        if (!empty($segments[0])) {
            $this->controllerName = $segments[0];
        }
        // [1] action
        if (!empty($segments[1])) {
            $this->actionName = $segments[1];
        }

        // [2..] пары param/value
        $rest = array_slice($segments, 2);
        for ($i = 0; $i < count($rest); $i += 2) {
            $key   = $rest[$i];
            $value = $rest[$i + 1] ?? null;
            if ($key !== '') {
                $this->params[$key] = $value;
            }
        }
    }

    /** Собрать имя класса контроллера: user -> UserController */
    private function controllerClass(): string
    {
        $name = preg_replace('/[^a-zA-Z0-9_]/', '', $this->controllerName);
        return ucfirst($name) . 'Controller';
    }

    /** Собрать имя метода action: view -> viewAction (list зарезервировано в PHP, поэтому суффикс) */
    private function actionMethod(): string
    {
        $name = preg_replace('/[^a-zA-Z0-9_]/', '', $this->actionName);
        return lcfirst($name) . 'Action';
    }

    public function run(): void
    {
        $controllerClass = $this->controllerClass();
        $controllerFile  = BASE_PATH . '/app/controllers/' . $controllerClass . '.php';

        if (!is_file($controllerFile)) {
            $this->notFound("Контроллер '{$this->controllerName}' не найден");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerClass)) {
            $this->notFound("Класс '{$controllerClass}' не объявлен в файле контроллера");
            return;
        }

        /** @var Controller $controller */
        $controller = new $controllerClass($this->params);

        $method = $this->actionMethod();

        if (!method_exists($controller, $method)) {
            $this->notFound("Action '{$this->actionName}' не найден в '{$controllerClass}'");
            return;
        }

        $controller->$method($this->params);
    }

    private function notFound(string $reason): void
    {
        http_response_code(404);
        if (DEBUG) {
            echo "404 — " . $reason;
        } else {
            echo "Страница не найдена";
        }
    }

    // Геттеры — на случай если понадобится доступ извне
    public function getController(): string { return $this->controllerName; }
    public function getAction(): string { return $this->actionName; }
    public function getParams(): array { return $this->params; }
}
