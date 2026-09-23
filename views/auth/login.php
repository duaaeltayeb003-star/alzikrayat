<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-3">Sign In</h3>

                <!-- Last Login Cookie Alert -->
                <?php if (!empty($lastLoginCookie)): ?>
                    <div class="alert alert-info py-2 small" role="alert">
                        🕒 <strong>Last login from this computer was:</strong> <?= htmlspecialchars($lastLoginCookie) ?>
                    </div>
                <?php endif; ?>

                <!-- Server-side errors -->
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

                <form id="loginForm" action="<?= $base ?>/login" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <p class="text-center text-muted small mt-3 mb-0">
                    Don't have an account? <a href="<?= $base ?>/register">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side JS validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const errBox = document.getElementById('jsErrorAlert');

    if (!email || !password) {
        e.preventDefault();
        errBox.textContent = 'Please fill in both email and password.';
        errBox.classList.remove('d-none');
    }
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>