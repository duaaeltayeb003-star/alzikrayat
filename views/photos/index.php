<?php 
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php'; 
$layoutStyle = $layoutStyle ?? ($_GET['style'] ?? 'grid-3');
?>

<!-- Hero Header & Stats Section -->
<div class="row mb-5 align-items-center g-4">
    <div class="col-lg-7">
        <div class="badge-tag mb-3">
            <i class="bi bi-stars"></i> Interactive Memory Platform
        </div>
        <h1 class="hero-title display-5 mb-3">Explore & Share Captured Moments</h1>
        <p class="text-muted lead fs-6 mb-4">
            A high-performance gallery built with Pure MVC architecture, real-time interactive filters, instant link sharing, and an engaging comment system.
        </p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= $base ?>/photo/upload" class="btn btn-modern-primary">
                <i class="bi bi-cloud-arrow-up-fill fs-5"></i> Upload New Memory
            </a>
        <?php else: ?>
            <div class="d-flex gap-2">
                <a href="<?= $base ?>/register" class="btn btn-modern-primary">
                    <i class="bi bi-person-plus-fill"></i> Get Started
                </a>
                <a href="<?= $base ?>/login" class="btn btn-modern-outline">
                    Sign In
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Live Dynamic Counter Cards -->
    <div class="col-lg-5">
        <div class="row g-3">
            <div class="col-4">
                <div class="stat-card p-3 text-center h-100">
                    <div class="stat-icon mb-2 mx-auto"><i class="bi bi-people-fill"></i></div>
                    <div class="fw-bold fs-4"><?= number_format($totalUsers ?? 0) ?></div>
                    <div class="text-muted small">Users</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card p-3 text-center h-100">
                    <div class="stat-icon mb-2 mx-auto" style="color: #ec4899; background: rgba(236,72,153,0.12);">
                        <i class="bi bi-images"></i>
                    </div>
                    <div class="fw-bold fs-4"><?= number_format($totalPhotos ?? 0) ?></div>
                    <div class="text-muted small">Photos</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card p-3 text-center h-100">
                    <div class="stat-icon mb-2 mx-auto" style="color: #10b981; background: rgba(16,185,129,0.12);">
                        <i class="bi bi-chat-quote-fill"></i>
                    </div>
                    <div class="fw-bold fs-4"><?= number_format($totalComments ?? 0) ?></div>
                    <div class="text-muted small">Comments</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar: Layout Switcher -->
<div class="toolbar-container d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center text-muted small fw-semibold">
        <i class="bi bi-sliders me-2 text-primary"></i> Gallery View Style:
    </div>
    <div class="btn-group btn-group-sm" role="group">
        <a href="<?= $base ?>/photos?style=grid-3" class="btn btn-outline-primary <?= $layoutStyle === 'grid-3' ? 'active' : '' ?>">
            <i class="bi bi-grid-3x3-gap me-1"></i> 3 Columns
        </a>
        <a href="<?= $base ?>/photos?style=grid-4" class="btn btn-outline-primary <?= $layoutStyle === 'grid-4' ? 'active' : '' ?>">
            <i class="bi bi-grid me-1"></i> 4 Columns
        </a>
        <a href="<?= $base ?>/photos?style=list" class="btn btn-outline-primary <?= $layoutStyle === 'list' ? 'active' : '' ?>">
            <i class="bi bi-view-list me-1"></i> List View
        </a>
    </div>
</div>

<!-- Gallery Grid / List -->
<?php if (empty($photos)): ?>
    <div class="card p-5 text-center border-0 shadow-sm rounded-4 my-4">
        <div class="stat-icon mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
            <i class="bi bi-camera"></i>
        </div>
        <h4 class="fw-bold text-secondary">No memories uploaded yet</h4>
        <p class="text-muted small">Be the first to share a moment with the community!</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="mt-2">
                <a href="<?= $base ?>/photo/upload" class="btn btn-modern-primary btn-sm">Upload Photo Now</a>
            </div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php if ($layoutStyle === 'list'): ?>
        <!-- List View -->
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <?php foreach ($photos as $photo): ?>
                    <div class="card gallery-card mb-4">
                        <div class="gallery-img-wrap" style="aspect-ratio: 16 / 9;">
                            <img src="<?= $base ?>/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" 
                                 alt="<?= htmlspecialchars($photo['title']) ?>">
                        </div>
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-2"><?= htmlspecialchars($photo['title']) ?></h4>
                            <p class="text-muted small mb-3"><?= nl2br(htmlspecialchars($photo['description'] ?? '')) ?></p>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="small text-muted">
                                    <i class="bi bi-person-circle text-primary me-1"></i>
                                    <strong><?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?></strong>
                                    &bull; <i class="bi bi-calendar-event me-1"></i> <?= date('M d, Y', strtotime($photo['date_time'])) ?>
                                </span>
                                <a href="<?= $base ?>/photos/<?= $photo['id'] ?>" class="btn btn-modern-outline btn-sm">
                                    View Details & Comments <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Grid View (3 or 4 Columns) -->
        <?php $colClass = ($layoutStyle === 'grid-4') ? 'col-xl-3 col-lg-4 col-md-6' : 'col-lg-4 col-md-6'; ?>
        <div class="row g-4">
            <?php foreach ($photos as $photo): ?>
                <div class="<?= $colClass ?>">
                    <div class="card gallery-card h-100">
                        <div class="gallery-img-wrap">
                            <img src="<?= $base ?>/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" 
                                 alt="<?= htmlspecialchars($photo['title']) ?>" 
                                 loading="lazy">
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-1 text-truncate" title="<?= htmlspecialchars($photo['title']) ?>">
                                <?= htmlspecialchars($photo['title']) ?>
                            </h6>
                            <p class="small text-muted mb-3">
                                <i class="bi bi-person me-1"></i> <?= htmlspecialchars($photo['first_name']) ?>
                                &bull; <i class="bi bi-clock me-1"></i> <?= date('M d, Y', strtotime($photo['date_time'])) ?>
                            </p>
                            <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                <a href="<?= $base ?>/photos/<?= $photo['id'] ?>" class="btn btn-modern-outline btn-sm py-1 px-3">
                                    View Details <i class="bi bi-chevron-right small"></i>
                                </a>
                                <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 small">
                                    <i class="bi bi-chat-dots text-primary me-1"></i> Comments
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php'; ?>