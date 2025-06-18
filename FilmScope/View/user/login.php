<?php  require 'View/layouts/header.php'; ?>
<!-- Вход -->
<section class="form-section">
    <div class="form-card text-white">
        <h3 class="text-center mb-4 fw-light">LOGIN</h3>
        <p class="text-danger text-center"><?= $error; ?></p>
        <form method="POST" action="?target=user&action=login">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username"  id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 mt-3">Login</button>
            <p class="mt-3 text-center">Don't have an account? <a href="?target=user&action=registration" class="text-decoration-none text-primary">Register</a></p>
        </form>
    </div>
</section>

<?php require 'View/layouts/footer.php'; ?>