<section class="container">
    <div class="card auth-card p-4 p-md-5">
        <h3 class="fw-semibold mb-1"><?= htmlspecialchars($title) ?></h3>
        <p class="text-muted mb-4">Создайте аккаунт за пару секунд</p>

        <form method="post" action="<?= BASE_URL ?>auth/register">
            <div class="mb-3">
                <label class="form-label small fw-medium">Имя</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-medium">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-medium">Пароль</label>
                <input type="password" name="password" class="form-control" minlength="6" required>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-medium">Повтор пароля</label>
                <input type="password" name="password_confirm" class="form-control" minlength="6" required>
            </div>

            <button type="submit" class="btn w-100 text-white fw-semibold" style="background: var(--brand-1);">
                Зарегистрироваться
            </button>
        </form>

        <p class="text-center text-muted small mt-4 mb-0">
            Уже есть аккаунт? <a href="<?= BASE_URL ?>auth/login" class="fw-semibold text-decoration-none">Войти</a>
        </p>
    </div>
</section>
