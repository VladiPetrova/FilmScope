<?php  require 'View/layouts/header.php'; ?>
<!-- Регистрация -->
<section class="form-section">
    <div class="form-card text-white">
        <h3 class="text-center mb-4 fw-light">REGISTRATION</h3>
        <p class="text-danger text-center"><?= $error; ?></p>
        <form method="POST" action="?target=user&action=registration">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username"  name="username"  required>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control"  name="first_name"  id="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last name </label>
                <input type="text" class="form-control" name="last_name" id="last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email"  name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100 mt-3">Register</button>
            <p class="mt-3 text-center">You have an account? <a href="?target=user&action=login" class="text-decoration-none text-primary">Login</a></p>
        </form>
    </div>
</section>

<?php require 'View/layouts/footer.php'; ?>