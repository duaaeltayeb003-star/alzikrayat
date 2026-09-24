<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="card-title mb-3">Upload Memory</h3>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div id="jsErrorAlert" class="alert alert-warning py-2 small d-none"></div>

                <form id="uploadForm" action="<?= $base ?>/photo/store" method="POST" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label for="title" class="form-label">Photo Title *</label>
                        <input type="text" class="form-control" id="title" name="title" maxlength="200" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Story / Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tell the story behind this photo..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Choose Image * (JPG, PNG, WEBP - Max 5MB)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="<?= $base ?>/photos" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Upload Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side JS Validation
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const imageInput = document.getElementById('image');
    const errBox = document.getElementById('jsErrorAlert');

    if (!title) {
        e.preventDefault();
        errBox.textContent = 'Photo title is required.';
        errBox.classList.remove('d-none');
        return;
    }

    if (!imageInput.files || imageInput.files.length === 0) {
        e.preventDefault();
        errBox.textContent = 'Please choose an image file to upload.';
        errBox.classList.remove('d-none');
        return;
    }

    const file = imageInput.files[0];
    if (file.size > 5 * 1024 * 1024) {
        e.preventDefault();
        errBox.textContent = 'Selected image size must be less than 5MB.';
        errBox.classList.remove('d-none');
        return;
    }
});
</script>

<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php'; ?>