<!-- ===== Hero ===== -->
<section class="hero-section text-center">
    <div class="container">
        <span class="hero-badge mb-3">PHP · MySQL · AJAX · Bootstrap</span>
        <h1 class="display-5 fw-bold mt-3 mb-3">Лёгкое MVC-ядро для быстрого старта</h1>
        <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 640px;">
            Минимальный, но продуманный фундамент для веб-проекта: понятный роутинг,
            разделение на модели, контроллеры и виды, готовая авторизация
            и раздел новостей с пагинацией — чтобы не начинать каждый проект с нуля.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?= BASE_URL ?>news/index" class="btn btn-light btn-lg fw-semibold px-4">Смотреть новости</a>
            <a href="<?= BASE_URL ?>auth/register" class="btn btn-outline-light btn-lg px-4">Создать аккаунт</a>
        </div>
    </div>
</section>

<!-- ===== Преимущества ===== -->
<section class="container py-5">
    <h2 class="section-title mb-4">Что внутри</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card p-4">
                <div class="feature-icon mb-3"><i class="bi bi-signpost-split"></i></div>
                <h5 class="fw-semibold">Понятный роутинг</h5>
                <p class="text-muted mb-0">
                    Адреса вида <code>/controller/action/param/value</code> разбираются
                    автоматически — не нужно писать конфиг маршрутов для каждой страницы.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card p-4">
                <div class="feature-icon mb-3"><i class="bi bi-shield-lock"></i></div>
                <h5 class="fw-semibold">Готовая авторизация</h5>
                <p class="text-muted mb-0">
                    Регистрация, вход и выход уже реализованы: пароли хэшируются,
                    сессии и cookie обёрнуты в удобные классы.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card p-4">
                <div class="feature-icon mb-3"><i class="bi bi-lightning-charge"></i></div>
                <h5 class="fw-semibold">AJAX из коробки</h5>
                <p class="text-muted mb-0">
                    Часть действий возвращает JSON и легко подключается к fetch —
                    примеры поиска и отправки формы уже в проекте.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ===== Тизер новостей ===== -->
<section class="container pb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h2 class="section-title mb-0">Последние новости</h2>
        <a href="<?= BASE_URL ?>news/index" class="text-decoration-none fw-semibold">Все новости &rarr;</a>
    </div>

    <?php if (empty($latestNews)): ?>
        <p class="text-muted">Пока нет ни одной новости.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($latestNews as $news): ?>
                <div class="col-md-4">
                    <div class="card news-card p-4">
                        <div class="news-date mb-2">
                            <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($news['created_at']) ?>
                        </div>
                        <h5 class="fw-semibold">
                            <a class="text-decoration-none text-dark" href="<?= BASE_URL ?>news/view/slug/<?= urlencode($news['slug']) ?>">
                                <?= htmlspecialchars($news['title']) ?>
                            </a>
                        </h5>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($news['excerpt']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- ===== CTA ===== -->
<section class="container pb-5">
    <div class="p-5 rounded-4 text-center text-white" style="background: linear-gradient(120deg, var(--brand-2), var(--brand-3));">
        <h3 class="fw-semibold mb-2">Готовы попробовать AJAX-поиск пользователей?</h3>
        <p class="mb-4 text-white-50">Небольшой пример без перезагрузки страницы — введите имя и нажмите «Искать».</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group input-group-lg">
                    <input type="text" id="search-input" class="form-control" placeholder="Введите имя...">
                    <button id="search-btn" class="btn btn-light fw-semibold">Искать</button>
                </div>
                <div id="search-result" class="mt-3 text-start"></div>
            </div>
        </div>
    </div>
</section>
