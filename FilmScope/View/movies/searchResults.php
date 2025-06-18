<?php  require 'View/layouts/header.php'; ?>
<div class="container my-5">
    <h2 class="mb-4">Search results: </h2>
    <?php if (count($movies) == 0) { ?>
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
            <p class="text-white text-center mt-4">No movies found.</p>
            <img class="error_pic img-fluid" src="assets/img/error.png" alt="Error Image" >
        </div>
    <?php } else { ?>
        <div class="row g-3">
            <?php foreach ($movies as $movie) { ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="?target=movie&action=showMovie&id=<?= $movie['id'] ?>" class="text-decoration-none">
                        <div class="card movie-card text-center h-100">
                            <img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>" class="card-img-top">
                            <div class="overlay-text text-white">
                                <span class="ms-2 h5">Rating: <?= round($movie['rating'], 1) ?>/5</span>
                            </div>
                            <div class="card-body p-2">
                                <h5 class="card-title"><?= $movie['title'] ?></h5>
                            </div>
                        </div>
                    </a> 
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php require 'View/layouts/footer.php'; ?>