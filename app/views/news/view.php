<section class="container py-5">
    <?php if ($item === null): ?>
        <div class="alert alert-warning">Новость не найдена.</div>
        <a href="<?= BASE_URL ?>news/index" class="btn btn-outline-secondary">&larr; Ко всем новостям</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>news/index" class="text-decoration-none d-inline-block mb-3">&larr; Ко всем новостям</a>

        <article class="card feature-card p-4 p-md-5" style="max-width: 760px;">
            <div class="news-date mb-2">
                <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($item['created_at']) ?>
            </div>
            <h1 class="h3 fw-bold mb-4"><?= htmlspecialchars($item['title']) ?></h1>
            <p class="fs-5" style="line-height: 1.7;"><?= nl2br(htmlspecialchars($item['content'])) ?></p>
        </article>
    <?php endif; ?>
</section>
