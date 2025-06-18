<?php  require 'View/layouts/header.php'; ?>
<div class="container mt-5 mb-5">
    <h1 class="mb-3 d-flex align-items-center gap-2 fw-light"> 
        <img class='genre-icon' src="assets/img/star.png" alt="Genre Icon">
        Added movies by you
    </h1>
    <?php if (!empty($moviesWithRatings)) { ?>
        <div class="row g-3">
            <?php foreach ($moviesWithRatings as $movie) { ?>
                <!-- Филм, който е одобрен -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <?php if ($movie['is_approved'] == 1) { ?>
                        <a href="?target=movie&action=showMovie&id=<?= $movie['id'] ?>" class="text-decoration-none">
                        <?php } ?>
                        <div class="card movie-card text-center">
                            <?php if ($movie['is_approved'] == 1) { ?>
                                <img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>">
                                <div class="overlay-text text-white"><span class="ms-2 h5">Rating: <?= $movie['rating'] ?>/5</span></div>
                            <?php } else { ?>
                                <!-- Филм, който чака одобрение -->
                                <div class="card movie-card text-center waiting-for-approval">
                                    <img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>">
                                    <div class="overlay-text">Waiting for Approval</div>
                                </div>
                            <?php } ?>
                            <div class="card-body p-2">
                                <h5 class="card-title"><?= $movie['title'] ?></h5>
                            </div>
                        </div>
                    </a> 
                </div>
            <?php } ?>
        <?php } else { ?>
           <div class = "d-flex flex-column justify-content-center align-items-center text-center" >
            <p class="text-white text-center mt-4">You haven't added any movies.</p>
            <img class="img-fluid error_pic" src="assets/img/error.png" alt="Error Image" >
        </div>
        <?php } ?>

    </div>
</div>

<?php require 'View/layouts/footer.php'; ?>