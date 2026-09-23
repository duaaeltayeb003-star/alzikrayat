<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-3">Create New Account</h3>

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

                <form id="registerForm" action="<?= $base ?>/register" method="POST" novalidate>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" maxlength="50" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name *</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" maxlength="50" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password * (Min 6 characters)</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location (Optional)</label>
                            <input type="text" class="form-control" id="location" name="location" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label for="occupation" class="form-label">Occupation (Optional)</label>
                            <input type="text" class="form-control" id="occupation" name="occupation" maxlength="100">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Bio / Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>

                <p class="text-center text-muted small mt-3 mb-0">
                    Already registered? <a href="<?= $base ?>/login">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side JS validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const fName = document.getElementById('first_name').value.trim();
    const lName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const pwd   = document.getElementById('password').value;
    const errBox = document.getElementById('jsErrorAlert');

    const nameRegex = /^[A-Za-z\s]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!nameRegex.test(fName) || !nameRegex.test(lName)) {
        e.preventDefault();
        errBox.textContent = 'First and last name must contain letters only.';
        errBox.classList.remove('d-none');
        return;
    }

    if (!emailRegex.test(email)) {
        e.preventDefault();
        errBox.textContent = 'Please enter a valid email address.';
        errBox.classList.remove('d-none');
        return;
    }

    if (pwd.length < 6) {
        e.preventDefault();
        errBox.textContent = 'Password must be at least 6 characters.';
        errBox.classList.remove('d-none');
        return;
    }
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>