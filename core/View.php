<?php
/**
 * View — рендерит файл вида из /app/views, затем подставляет
 * результат и данные контроллера в общий шаблон /app/views/template.php.
 *
 * Т.е. render('user/view', ['title' => '...', 'user' => $user]):
 *   1. подключает app/views/user/view.php с переменными $title, $user
 *      (доступ к данным контроллера прямо в виде через extract)
 *   2. результат кладёт в $content
 *   3. подключает app/views/template.php с переменными $title, $user, $content
 *      (общий шаблон сам решает, что вывести — шапку, футер, флеш-сообщения)
 */
class View
{
    private string $viewsPath;

    public function __construct()
    {
        $this->viewsPath = BASE_PATH . '/app/views/';
    }

    /**
     * @param string $viewPath относительный путь без .php, напр. 'user/view'
     * @param array  $data     ассоц. массив -> переменные внутри вида и шаблона
     */
    public function render(string $viewPath, array $data = []): void
    {
        $content = $this->renderPartial($viewPath, $data);

        $templateFile = $this->viewsPath . 'template.php';
        if (!is_file($templateFile)) {
            // если общего шаблона нет — просто выводим сам вид
            echo $content;
            return;
        }

        $templateData = array_merge($data, ['content' => $content]);
        extract($templateData, EXTR_SKIP);
        require $templateFile;
    }

    /** Рендер одного файла вида в строку, без обёртки в общий шаблон */
    public function renderPartial(string $viewPath, array $data = []): string
    {
        $file = $this->viewsPath . $viewPath . '.php';

        if (!is_file($file)) {
            if (DEBUG) {
                die("Шаблон не найден: {$file}");
            }
            die('Ошибка отображения страницы');
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
