<?php require __DIR__ . '/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 p-4">
            <div class="card-body">
                <h2 class="fw-bold mb-3 text-dark">About Alzikrayat</h2>
                <p class="lead text-muted">
                    Alzikrayat (الذكريات) is an academic web application developed for the <strong>Advanced Web Technologies</strong> course at <em>Sudan University of Science and Technology (SUST)</em>
                </p>
                <hr>
                <h5 class="fw-bold mt-4">Engineering Architecture</h5>
                <p class="text-secondary small">
                    This project is designed and implemented using a custom, lightweight <strong>Model-View-Controller (MVC)</strong> framework built from scratch without external libraries It features a manual regular-expression routing engine, session state isolation, prepared PDO queries, and multi-tier input sanitization
                </p>

                <h5 class="fw-bold mt-4">Key Features</h5>
                <ul class="text-secondary small">
                    <li>Session-based user authentication and Bcrypt password hashing</li>
                    <li>Persistent browser state tracking using a 7-day Last Login cookie</li>
                    <li>Dynamic photo galleries with multiple responsive view styles</li>
                    <li>Strict resource ownership verification on photo deletions</li>
                    <li>Real-time commenting engine mapping relational data schemas</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>