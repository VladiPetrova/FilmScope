<?php

namespace Controller;

use Model\Dao\MovieDao;
use Model\Dao\GenreDao;
use Model\Movie;

class MovieController {

// Метод за добавяне на нов филм
    public function addMovie() {

// Проверка дали потребителят е логнат
        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }


// Взимаме всички жанрове за попълване на падащо меню във формата
        $genres = GenreDao::getAllGenres();
        $error = null;

// Ако е изпратена форма за добавяне на филм
        if (isset($_POST["add_movie"])) {

            $movieModel = new Movie;

            $posterPath = $movieModel->handlePosterUpload($_FILES['moviePoster']);

            if ($posterPath === false) {
                $error = "Error uploading poster or invalid format.";
            }

            $movieTitle = htmlentities($_POST['movieTitle']);
            $movieDescription = htmlentities($_POST['movieDescription']);
            $movieYear = htmlentities($_POST['movieYear']);
            $genre = htmlentities($_POST['genre']);
            $actors = htmlentities($_POST['actors']);

// Добавяме минимална проверка тук:
            if (!$error) {
                if (empty($movieTitle) || empty($movieDescription) || empty($movieYear) || empty($genre) || empty($actors)) {
                    $error = "All fields are required.";
                } elseif (!is_numeric($movieYear) || $movieYear < 1890 || $movieYear > 2100) {
                    $error = "Year must be a number between 1800 and 3000.";
                } elseif (strlen($movieTitle) > 50) {
                    $error = "Title must be less than 50 characters.";
                } elseif (strpos($actors, ',') === false) {
                    $error = "Actors' names must be separated by commas.";
                }
            }

            if (!$error) {
                $result = $movieModel->create($movieTitle, $movieDescription, $movieYear, $posterPath, $genre, $actors, $_SESSION['user']);

                if ($result === true) {
                    require 'View/movies/success_page.php';
                    return;
                } else {
                    switch ($result) {
                        case "duplicate_title":
                            $error = "A movie with this title already exists.";
                            break;
                        case "invalid_user":
                            $error = "User not found or not authorized.";
                            break;
                        case "insert_failed":
                            $error = "Something went wrong while saving the movie.";
                            break;
                        case "empty_entry":
                            $error = "All fields are required.";
                            break;
                        default:
                            $error = "An unknown error occurred.";
                    }
                }
            }
        }

// Ако не е успешно, показваме формата отново
        require_once 'View/movies/add_movie.php';
    }

// Метод за показване на детайлна страница на филм
    public function showMovie() {

// Проверка дали е подаден параметър id
        if (!isset($_GET['id'])) {
            require 'View/errors/error_page.php';
            return;
        }

        $movieId = $_GET['id'];
        $movieModel = new Movie;

// Вземаме детайлите за филма и оценките му
        $movie = $movieModel->getMovieDetails($movieId);
        $ratingData = $movieModel->getMovieRating($movieId);

// Ако филмът не съществува, зареждаме страница с грешка
        if (!$movie) {
            require 'View/errors/error_page.php';
            return;
        }

// Странициране
        $limit = 3;
        $totalReviews = $movieModel->getTotalReviewsCount($movieId);
        $totalPages = max(1, ceil($totalReviews / $limit));

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Ако исканата страница е по-малка от 1, вземаме първата страница
        if ($page < 1) {
            $page = 1;
            header("Location: ?target=movie&action=showMovie&id=$movieId&page=$page");
            die();
        }
// Ако исканата страница е по-голяма от последната, вземаме последната
        elseif ($page > $totalPages) {
            $page = $totalPages;
            header("Location: ?target=movie&action=showMovie&id=$movieId&page=$page");
            die();
        }

        $offset = ($page - 1) * $limit;

// Вземаме рецензиите за текущата страница
        $reviews = $movieModel->getMovieReviewsPaged($movieId, $limit, $offset);

        $range = 2; // Колко страници да се показват около текущата
        $start = max(1, $page - $range);
        $end = min($totalPages, $page + $range);

// Проверяваме дали филмът е вече любим на текущия потребител
        $isFavourite = false;

        if (isset($_SESSION['user'])) {
            $isFavourite = $movieModel->isFavouriteMovie($_SESSION['user'], $movieId);
        }

        $userRating = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $userData = \Model\Dao\UserDao::getUserByUsername($user);
            $userRating = \Model\Dao\RatingDao::getUserRatingForMovie($userData['id'], $movieId);
        }

        // Проверяваме дали ревюто е вече харесано от текущия потребител
        $likedReviewIds = [];

        if (isset($_SESSION['user'])) {
            foreach ($reviews as $review) {
                if ($movieModel->isLikedReviewByUser($_SESSION['user'], $review['id'])) {
                    $likedReviewIds[] = $review['id'];
                }
            }
        }



        require_once 'View/movies/movie_page.php';
    }

// Метод за добавяне или премахване на филм от любими
    public function likeMovie() {
        $movieId = $_POST['movie_id'];
        $username = $_SESSION['user'];

        $movieModel = new Movie;
        $movieModel->toggleFavourite($username, $movieId);

        header("Location: ?target=movie&action=showMovie&id=" . $movieId);
        die();
    }

    public function showFavourites() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }
// Показва списъка с любими филми на потребителя
        $movieModel = new Movie;
        $favourites = $movieModel->getUserFavouritesWithRatings($_SESSION['user']);

        require 'View/movies/likes.php';
    }

// Показва филмите, които текущият потребител е добавил
    public function addedMovies() {

        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }

        $movieModel = new Movie;
        $moviesWithRatings = $movieModel->getAddedMoviesWithRatings($_SESSION['user']);

        require 'View/movies/added_movies.php';
    }

// Показва филми, чакащи одобрение от администратора
    public function moviesAwaitingApproval() {

        if (!isset($_SESSION['user']) || !$_SESSION["isAdmin"]) {
            header("Location: ?target=user&action=login");
            die();
        }

        $movieModel = new Movie;
        $moviesAwaitingApproval = $movieModel->getMoviesAwaitingApproval();

        require 'View/admin/approve_movies.php';
    }

// Показва детайли на добавен, но не одобрен филм
    public function showAddedMovie() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }

        $movieId = $_GET['id'];

        $movieModel = new Movie;
        $movie = $movieModel->getNotApprovedMovieById($movieId);

        if ($movie) {
            require 'View/movies/added_movie_info.php';
        } else {
            require 'View/errors/error_page.php';
        }
    }

// Одобрява филм (администраторско действие)
    public function approveMovie() {

        $movieId = $_POST['movie_id'];

        MovieDao::approveMovie($movieId);

        header("Location: ?target=movie&action=moviesAwaitingApproval");
        die();
    }

// Отхвърля филм (администраторско действие)
    public function rejectMovie() {

        $movieId = $_POST['movie_id'];

        MovieDao::deleteMovie($movieId);

        header("Location: ?target=movie&action=moviesAwaitingApproval");
        die();
    }

// Показва резултати от търсене на филма
    public function searchResults() {
        if (isset($_POST['query'])) {
            $query = (htmlentities(trim($_POST['query'])));

//Ако е празно търсенето 
            if ($query == '') {
                header("Location: index.php?target=base&action=index");
                die();
            }

            header("Location: index.php?target=movie&action=searchResults&query=" . $query);
            die();
        }

        $movieModel = new Movie;
        $movies = $movieModel->getMoviesForSearch();

        require_once 'View/movies/searchResults.php';
    }
}
