<?php require 'View/layouts/header.php'; ?>
<!-- Profile Settings -->
<section class="form-section my-4">
    <div class="container">
        <h3 class="text-center mb-4 fw-light text-white">PROFILE SETTINGS</h3>

        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo '<p class="text-danger text-center" >' . $error . '</p>';
                    }
                }

                if (!empty($success)) {
                    echo '<p class="text-success text-center" >' . $success . '</p>';
                }
                ?>
                <div class="form-card text-white p-4 rounded bg-dark">

                    <!-- Current Info Box -->
                    <div class="mb-4 p-3 bg-secondary text-white rounded">
                        <h5 class="mb-2">Current Information</h5>
                        <p class="mb-1"><strong>Name:</strong> <?= $user['first_name'] . " " . $user['last_name'] ?></p>
                        <p class="mb-0"><strong>Email:</strong> <?= $user['email'] ?></p>
                    </div>

                    <!-- Update Form -->
                    <form method="post" action="?target=profile&action=changeProfile">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" >
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" >
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" >
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password <small>(required to change password)</small></label>
                            <input type="password" class="form-control" name="current_password" id="current_password">
                        </div>
                        <button type="submit" name="save_changes" class="btn btn-primary w-100 mt-3">Save Changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<?php require 'View/layouts/footer.php'; ?>