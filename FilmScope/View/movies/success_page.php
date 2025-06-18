<?php  require 'View/layouts/header.php'; ?>
<?php if (!$_SESSION["isAdmin"]) { ?>
    <div class = "d-flex flex-column justify-content-center align-items-center text-center" >
        <img class = "error_pic img-fluid" src = "assets/img/success.png" alt = "Success" >
        <h2 class = "fw-bold text-success">Your movie is up for approval.</h2>
    </div>
<?php } else { ?>
    <div class = "d-flex flex-column justify-content-center align-items-center text-center" >
        <img class = "error_pic img-fluid" src = "assets/img/success.png" alt = "Success" >
        <h2 class = "fw-bold">Added successfully.</h2>
    </div>
    <?php
}

 require 'View/layouts/footer.php'; 