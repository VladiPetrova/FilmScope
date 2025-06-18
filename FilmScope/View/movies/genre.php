<?php require 'View/layouts/header.php'; ?>
<div class="container my-5">
    <h1 class="fw-light fw-light d-flex align-items-center gap-2 mb-3"> 
        <img class='genre-icon' src="assets/img/star.png" alt="Genre Icon">
        <?= $genre['genre_name'] ?>
    </h1>
    <?php if (empty($moviesWithRatings)) { ?>
        <div class="d-flex flex-column justify-content-center align-items-center text-center" >
            <p class="text-white text-center mt-4">Тhere are no movies of this genre.</p>
            <img class="error_pic img-fluid" src="assets/img/error.png" alt="Error Image" >

        </div>
    <?php } else { ?>
        <div class="row g-3">
            <?php foreach ($moviesWithRatings as $movie) { ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="?target=movie&action=showMovie&id=<?= $movie['id'] ?>" class="text-decoration-none">
                        <div class="card movie-card text-center">
                            <img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>">
                            <div class="overlay-text text-white">
                                <span class="ms-2 h5">Rating: <?= $movie['rating'] ?>/5</span>
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
