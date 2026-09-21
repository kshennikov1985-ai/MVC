<section class="container py-5">
    <h1 class="section-title mb-4"><?= htmlspecialchars($title) ?></h1>

    <div class="card feature-card p-4 mb-4">
        <h6 class="fw-semibold mb-3">Быстрое добавление (AJAX)</h6>
        <form id="create-form" class="row g-2 align-items-center">
            <div class="col-sm-4">
                <input type="text" name="name" class="form-control" placeholder="Имя" required>
            </div>
            <div class="col-sm-4">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn w-100 text-white" style="background: var(--brand-1);">Добавить</button>
            </div>
        </form>
    </div>

    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Создан</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Пользователей пока нет</td></tr>
            <?php else: ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="text-muted">#<?= (int)$u['id'] ?></td>
                        <td>
                            <a class="text-decoration-none fw-medium" href="<?= BASE_URL ?>user/view/id/<?= (int)$u['id'] ?>">
                                <?= htmlspecialchars($u['name']) ?>
                            </a>
                        </td>
                        <td class="text-muted"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="text-muted small"><?= htmlspecialchars($u['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
