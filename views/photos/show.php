<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Back Link -->
        <div class="mb-4">
            <a href="<?= $base ?>/photos" class="btn btn-modern-outline btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Memories
            </a>
        </div>

        <!-- Photo Card & Details -->
        <div class="card gallery-card mb-4 border-0">
            <!-- Filter Preview Image -->
            <div class="text-center p-3" style="background: #0f172a; border-radius: 1.35rem 1.35rem 0 0;">
                <img id="activePhoto" 
                     src="<?= $base ?>/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" 
                     class="img-fluid rounded-3 filter-normal" 
                     alt="<?= htmlspecialchars($photo['title']) ?>" 
                     style="max-height: 520px; object-fit: contain;">
                
                <!-- Live Interactive Filter Buttons (Novelty Task) -->
                <div class="d-flex justify-content-center gap-2 flex-wrap mt-3 pt-2 border-top border-secondary border-opacity-25">
                    <span class="text-light-50 small align-self-center me-2">
                        <i class="bi bi-magic me-1"></i> Visual Filters:
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 active" onclick="setFilter(this, 'filter-normal')">Original</button>
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="setFilter(this, 'filter-sepia')">Sepia</button>
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="setFilter(this, 'filter-grayscale')">B&W</button>
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="setFilter(this, 'filter-vintage')">Vintage</button>
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="setFilter(this, 'filter-cool')">Cool</button>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <h2 class="fw-bold mb-1"><?= htmlspecialchars($photo['title']) ?></h2>
                        <p class="text-muted small mb-0">
                            Shared by <strong class="text-dark"><?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?></strong> 
                            &bull; <i class="bi bi-calendar-event me-1"></i> <?= date('F j, Y, g:i a', strtotime($photo['date_time'])) ?>
                        </p>
                    </div>

                    <!-- Delete button: Only owner -->
<?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$photo['user_id']): ?>
    <form action="<?= $base ?>/photo/delete" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this memory?');">
        <input type="hidden" name="id" value="<?= $photo['id'] ?>">
        <button type="submit" class="btn btn-outline-danger btn-sm">Delete Photo</button>
    </form>
<?php endif; ?>
                </div>

                <?php if (!empty($photo['description'])): ?>
                    <p class="lead fs-6 text-secondary mt-2 mb-0"><?= nl2br(htmlspecialchars($photo['description'])) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comments Engine Section -->
        <div class="card stat-card border-0 mb-5">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div class="stat-icon" style="width: 40px; height: 40px; font-size: 1.1rem;">
                        <i class="bi bi-chat-quote-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Comments (<?= count($comments) ?>)</h4>
                </div>

                <!-- Add Comment Form -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="<?= $base ?>/comment/store" method="POST" class="mb-4">
                        <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Share your thoughts or reflections..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-modern-primary btn-sm">
                            <i class="bi bi-send-fill me-1"></i> Post Comment
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-light border rounded-3 small py-3 mb-4 d-flex align-items-center justify-content-between">
                        <span>Join the campus conversation to post a comment.</span>
                        <a href="<?= $base ?>/login" class="btn btn-modern-outline btn-sm">Sign In</a>
                    </div>
                <?php endif; ?>

                <hr class="border-light-subtle my-4">

                <!-- List of Comments -->
                <?php if (empty($comments)): ?>
                    <div class="text-center py-4">
                        <p class="text-muted small mb-0">No comments posted yet. Be the first to share your thoughts!</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($comments as $comm): ?>
                            <div class="p-3 rounded-3 bg-light bg-opacity-50 border border-light-subtle">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-dark">
                                        <i class="bi bi-person-circle text-primary me-1"></i>
                                        <?= htmlspecialchars($comm['first_name'] . ' ' . $comm['last_name']) ?>
                                    </strong>
                                    <span class="text-muted small"><?= date('M d, Y &bull; g:i a', strtotime($comm['date_time'])) ?></span>
                                </div>
                                <p class="mb-0 text-secondary small"><?= nl2br(htmlspecialchars($comm['comment'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function setFilter(button, filterClass) {
    const img = document.getElementById('activePhoto');
    img.className = 'img-fluid rounded-3 ' + filterClass;
    
    // Switch active button style
    document.querySelectorAll('.filter-buttons button, .border-top button').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}
</script>

<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php'; ?>