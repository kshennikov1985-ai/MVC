<section class="container py-5">
    <h1 class="section-title mb-4"><?= htmlspecialchars($title) ?></h1>

    <?php if (empty($items)): ?>
        <p class="text-muted">Новостей пока нет.</p>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($items as $news): ?>
                <div class="col-md-6">
                    <div class="card news-card p-4 h-100">
                        <div class="news-date mb-2">
                            <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($news['created_at']) ?>
                        </div>
                        <h5 class="fw-semibold">
                            <a class="text-decoration-none text-dark" href="<?= BASE_URL ?>news/view/slug/<?= urlencode($news['slug']) ?>">
                                <?= htmlspecialchars($news['title']) ?>
                            </a>
                        </h5>
                        <p class="text-muted small mb-3"><?= htmlspecialchars($news['excerpt']) ?></p>
                        <a href="<?= BASE_URL ?>news/view/slug/<?= urlencode($news['slug']) ?>" class="fw-semibold text-decoration-none mt-auto">
                            Читать далее &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav aria-label="Навигация по страницам новостей">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= BASE_URL ?>news/index/page/<?= max(1, $page - 1) ?>">&laquo;</a>
                    </li>

                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= BASE_URL ?>news/index/page/<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= BASE_URL ?>news/index/page/<?= min($totalPages, $page + 1) ?>">&raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</section>
