<?php  require 'View/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row mb-5">
        
        <!-- POSTER -->
        <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center">
            <img src="<?= $movie['poster'] ?>" alt="Movie Poster" class="movie-poster">
        </div>

        <!-- MOVIE INFO -->
        <div class="col-lg-8 col-md-6">
            <h2><?= $movie['title'] ?></h2>
            <p class="lead"><?= $movie['description'] ?></p>

            <h5>Release Year: <?= $movie['release_year'] ?></h5>

            <h5 class="mt-3">Actors:</h5>
            <p><?= $movie['actors'] ?></p>

            <h5 class="mt-3">Genre:</h5>
            <p>
                <?php
                $genre = Model\Dao\GenreDao::getGenreById($movie['genre_id']);
                echo $genre['genre_name'];
                ?>
            </p>

          
            <div class="mt-4 d-flex justify-content-start ps-3">
                <a href="?target=movie&action=moviesAwaitingApproval" class="btn btn-warning">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>
<?php require 'View/layouts/footer.php'; ?>