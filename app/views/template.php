<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'MVC App') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top main-navbar">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="<?= BASE_URL ?>">
            <i class="bi bi-hexagon-fill me-1"></i> MVC App
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>news/index">Новости</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>user/index">Пользователи</a></li>
            </ul>

            <ul class="navbar-nav align-items-lg-center gap-lg-2">
                <?php if (Session::has('user_id')): ?>
                    <li class="nav-item">
                        <span class="nav-link text-white-50">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(Session::get('user_name')) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>auth/logout">Выйти</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>auth/login">Вход</a></li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm fw-semibold" href="<?= BASE_URL ?>auth/register">Регистрация</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?php if ($msg = Session::getFlash('success')): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($msg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($msg = Session::getFlash('error')): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($msg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-hexagon-fill me-1"></i> MVC App</h5>
                <p class="text-white-50 small">
                    Учебное ядро на PHP: роутер, модели, контроллеры, шаблоны и AJAX —
                    минимальный набор для быстрого старта собственных проектов.
                </p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-semibold mb-3">Разделы</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?= BASE_URL ?>news/index" class="footer-link">Новости</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>user/index" class="footer-link">Пользователи</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>auth/register" class="footer-link">Регистрация</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="fw-semibold mb-3">Контакты</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>hello@example.com</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>+7 (000) 000-00-00</li>
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Таллин, Эстония</li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">
        <p class="text-white-50 small mb-0 text-center">© <?= date('Y') ?> MVC App. Демонстрационный проект.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/js/app.js"></script>
</body>
</html>
