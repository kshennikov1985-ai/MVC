<section class="container py-5">
    <?php if ($user === null): ?>
        <div class="alert alert-warning">Пользователь не найден.</div>
        <a href="<?= BASE_URL ?>user/index" class="btn btn-outline-secondary">&larr; К списку пользователей</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>user/index" class="text-decoration-none d-inline-block mb-3">&larr; К списку пользователей</a>

        <div class="card feature-card p-4" style="max-width: 480px;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="feature-icon"><i class="bi bi-person-fill"></i></div>
                <div>
                    <h4 class="fw-semibold mb-0"><?= htmlspecialchars($user['name']) ?></h4>
                    <span class="text-muted small">#<?= (int)$user['id'] ?></span>
                </div>
            </div>
            <p class="mb-1"><i class="bi bi-envelope me-2 text-muted"></i><?= htmlspecialchars($user['email']) ?></p>
            <p class="mb-0 text-muted small"><i class="bi bi-calendar3 me-2"></i>Зарегистрирован: <?= htmlspecialchars($user['created_at']) ?></p>
        </div>
    <?php endif; ?>
</section>
