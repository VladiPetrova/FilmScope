<?php
$genres = \Model\Dao\GenreDao::getAllGenres();

$currentTarget = $_GET['target'];
$currentAction = $_GET['action'];
?>

<html lang="bg">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FilmScope</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="assets/css/styles.css" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    </head>


    <body>
        <!-- Навигация -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top px-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="?target=base&action=index">
                    <i class="bi bi-camera-reels-fill me-2"></i>FilmScope
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center">
                        <?php if (empty($_SESSION["user"])) { ?>
                            <li class="nav-item mt-2 mt-lg-0">
                                <a href="?target=user&action=login"  class="nav-link <?= ($currentTarget === 'user' && $currentAction === 'login') ? 'active' : '' ?>">Login</a>
                            </li>
                            <li class="nav-item mt-2 mt-lg-0">
                                <a href="?target=user&action=registration"  class="nav-link <?= ($currentTarget === 'user' && $currentAction === 'registration') ? 'active' : '' ?>">Registration</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item mt-2 mt-lg-0">
                                <a href="?target=base&action=index"  class="nav-link <?= ($currentTarget === 'base' && $currentAction === 'index') ? 'active' : '' ?>">Home</a>
                            </li>
                            <li class="nav-item dropdown mt-2 mt-lg-0">
                                <a class="nav-link dropdown-toggle <?= ($currentTarget === 'genre') ? 'active' : '' ?>" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Genres
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <!-- Показване на всички жанрове от базата -->
                                    <?php foreach ($genres as $menuGenre) { ?>
                                        <li>
                                            <a class="dropdown-item" href="?target=genre&action=view&id=<?= $menuGenre['id'] ?>">
                                                <?= $menuGenre['genre_name'] ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="nav-item dropdown mt-2 mt-lg-0">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Profile
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="?target=profile&action=changeProfile">Settings</a></li>
                                    <li><a class="dropdown-item" href="?target=movie&action=showFavourites">Likes</a></li>
                                    <li><a class="dropdown-item" href="?target=review&action=showReviewsPage">Reviews</a></li>
                                    <li><a class="dropdown-item" href="?target=movie&action=addMovie">Add Movie</a></li>
                                    <li><a class="dropdown-item" href="?target=movie&action=addedMovies">Added by Me</a></li>
                                    <?php if ($_SESSION["isAdmin"]) { ?>
                                        <li><a class="dropdown-item" href="?target=movie&action=moviesAwaitingApproval">Approve movies</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="nav-item mt-2 mt-lg-0">
                                <a href="?target=base&action=logout" class="nav-link">Log out</a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>        
            </div>
        </nav>
