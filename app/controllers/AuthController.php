<?php
class AuthController extends Controller
{
    /** GET /auth/register — форма, POST /auth/register — обработка */
    public function registerAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->render('auth/register', ['title' => 'Регистрация']);
            return;
        }

        $name             = trim($_POST['name'] ?? '');
        $email            = trim($_POST['email'] ?? '');
        $password         = (string)($_POST['password'] ?? '');
        $passwordConfirm  = (string)($_POST['password_confirm'] ?? '');

        $errors = $this->validateRegistration($name, $email, $password, $passwordConfirm);

        /** @var UserModel $userModel */
        $userModel = $this->model('user');

        if (!$errors && $userModel->findByEmail($email)) {
            $errors[] = 'Пользователь с таким email уже зарегистрирован';
        }

        if ($errors) {
            Session::flash('error', implode('. ', $errors));
            $this->render('auth/register', [
                'title' => 'Регистрация',
                'old'   => ['name' => $name, 'email' => $email],
            ]);
            return;
        }

        $id = $userModel->createWithPassword($name, $email, $password);

        Session::set('user_id', $id);
        Session::set('user_name', $name);
        Cookie::set('last_email', $email); // просто для примера использования Cookie

        Session::flash('success', 'Регистрация прошла успешно. Добро пожаловать, ' . $name . '!');
        $this->redirect('user/index');
    }

    /** GET /auth/login — форма, POST /auth/login — обработка */
    public function loginAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->render('auth/login', [
                'title' => 'Вход',
                'old'   => ['email' => Cookie::get('last_email', '')],
            ]);
            return;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        /** @var UserModel $userModel */
        $userModel = $this->model('user');
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            Session::flash('error', 'Неверный email или пароль');
            $this->render('auth/login', ['title' => 'Вход', 'old' => ['email' => $email]]);
            return;
        }

        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['name']);
        Cookie::set('last_email', $email);

        Session::flash('success', 'Добро пожаловать, ' . $user['name'] . '!');
        $this->redirect('user/index');
    }

    /** GET /auth/logout */
    public function logoutAction(): void
    {
        Session::destroy();
        $this->redirect('');
    }

    private function validateRegistration(string $name, string $email, string $password, string $passwordConfirm): array
    {
        $errors = [];

        if (mb_strlen($name) < 2) {
            $errors[] = 'Имя должно быть не короче 2 символов';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Некорректный email';
        }
        if (mb_strlen($password) < 6) {
            $errors[] = 'Пароль должен быть не короче 6 символов';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Пароли не совпадают';
        }

        return $errors;
    }
}
