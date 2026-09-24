<?php require __DIR__ . '/layout/header.php'; ?>

<!-- Hero Section -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border text-center">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold text-primary">Capture & Share Your Best Moments</h1>
        <p class="col-md-8 fs-5 mx-auto text-muted">
            Welcome to <strong>Alzikrayat</strong>, a pure MVC photo-sharing platform crafted to bring memories back to life. Join our community, upload your photos, and engage with meaningful stories.
        </p>
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="<?= $base ?>/photos" class="btn btn-primary btn-lg px-4">Browse Gallery</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="<?= $base ?>/register" class="btn btn-outline-secondary btn-lg px-4">Create Account</a>
            <?php else: ?>
                <a href="<?= $base ?>/photo/upload" class="btn btn-success btn-lg px-4">+ Upload Memory</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Key Highlights / Statistics Section -->
<div class="row g-4 text-center mt-2">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="display-6 text-primary mb-2">📸</div>
                <h5 class="card-title fw-bold">Preserve Moments</h5>
                <p class="card-text text-muted small">Store high-resolution memories with unique captions and timeless dates.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="display-6 text-success mb-2">💬</div>
                <h5 class="card-title fw-bold">Active Conversations</h5>
                <p class="card-text text-muted small">Engage in genuine community dialogue on shared photos via direct commenting.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="display-6 text-warning mb-2">🛡️</div>
                <h5 class="card-title fw-bold">Safe & Controlled</h5>
                <p class="card-text text-muted small">Robust ownership protection ensuring only uploaders can modify or purge their content.</p>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>