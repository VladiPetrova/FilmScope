<?php  require 'View/layouts/header.php'; ?>
<div class="container my-5">
    <h1 class="fw-light fw-light d-flex align-items-center gap-2 mb-3">
     <img class='genre-icon' src="assets/img/star.png" alt="Genre Icon">
     Your liked movies
    </h1>
 <?php if(!empty($favourites)){ ?>
    <div class="row g-3">
        <?php foreach ($favourites as $movie) { ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="?target=movie&action=showMovie&id=<?= $movie['id'] ?>" class="text-decoration-none">
                    <div class="card movie-card text-center">
                        <img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>">
                        <div class="overlay-text text-white">
                            <span class="ms-2 h5">Rating: <?= round($movie['average_rating'], 1) ?>/5</span>
                        </div>
                        <div class="card-body p-2">
                            <h5 class="card-title"><?= $movie['title'] ?></h5>
                        </div>
                    </div>
                </a> 
            </div>
        <?php } ?>
        <?php } else { ?>
        <div class = "d-flex flex-column justify-content-center align-items-center text-center" >
            <p class="text-white text-center mt-4">There are no favourite movies yet.</p>
            <img class="img-fluid error_pic" src="assets/img/error.png" alt="Error Image" >
        </div>
    <?php } ?>

    </div>
</div>
<?php require 'View/layouts/footer.php'; ?>