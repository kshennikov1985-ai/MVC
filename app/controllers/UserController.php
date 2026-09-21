<?php
class UserController extends Controller
{
    /** GET /user/index */
    public function indexAction(): void
    {
        $userModel = $this->model('user');
        $users = $userModel->getAll();

        $this->render('user/index', [
            'title' => 'Список пользователей',
            'users' => $users,
        ]);
    }

    /** GET /user/view/id/5 */
    public function viewAction(array $params): void
    {
        $id = (int)($params['id'] ?? 0);

        $userModel = $this->model('user');
        $user = $userModel->getById($id);

        if (!$user) {
            http_response_code(404);
            $this->render('user/view', ['title' => 'Не найдено', 'user' => null]);
            return;
        }

        $this->render('user/view', [
            'title' => 'Пользователь #' . $id,
            'user'  => $user,
        ]);
    }

    /** POST /user/create (AJAX, только для служебного примера) */
    public function createAction(): void
    {
        if (!$this->isAjax()) {
            $this->json(['ok' => false, 'error' => 'Только AJAX-запросы'], 400);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $name  = trim($input['name'] ?? '');
        $email = trim($input['email'] ?? '');

        if ($name === '' || $email === '') {
            $this->json(['ok' => false, 'error' => 'Заполните имя и email'], 422);
        }

        $userModel = $this->model('user');
        $id = $userModel->createWithPassword($name, $email, bin2hex(random_bytes(4)));

        $this->json(['ok' => true, 'id' => $id]);
    }

    /** GET /user/search/q/ivan (AJAX) */
    public function searchAction(array $params): void
    {
        $query = $params['q'] ?? '';

        $userModel = $this->model('user');
        $result = $userModel->search($query);

        $this->json(['ok' => true, 'items' => $result]);
    }
}
