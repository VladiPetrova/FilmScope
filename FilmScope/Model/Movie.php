<?php

namespace Model;

use Model\Dao\MovieDao;
use Model\Dao\UserDao;
use Model\Dao\ReviewDao;
use Model\Dao\RatingDao;
use Model\Dao\FavouriteMovieDao;

class Movie {

    public function handlePosterUpload($file) {

        if (empty($file['tmp_name'])) {
            return null; // няма файл – не е грешка, просто липсва
        }

        $uploadDir = 'assets/img/';
        $originalName = $file['name'];
        $timestamp = date("Ymd_His");
        $fileName = $timestamp . '_' . $originalName;
        $targetPath = $uploadDir . $fileName;

        // Разширение проверка
        $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($imageFileType, $allowedTypes)) {
            return false; // невалиден тип
        }

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return false; // неуспешно качване
        }

        return $targetPath;
    }

    // Създава нов филм с подадените данни
    public function create($title, $description, $releaseYear, $posterPath, $genreId, $actors, $username) {
        $user = UserDao::getUserByUsername($username);

        // Ако потребителят не съществува, връща грешка
        if (!$user || !isset($user['id'])) {
            return "invalid_user";
        }

        // Проверява дали филм със същото заглавие вече съществува
        $existingMovie = MovieDao::getMovieByTitle($title);

        if ($existingMovie) {
            return "duplicate_title";
        }

        // Проверява дали всички полета са попълнени
        if (empty($title) || empty($description) || empty($releaseYear) || empty($posterPath) || empty($genreId) || empty($actors)) {
            return "empty_entry";
        }

        // Ако потребителят е администратор, филмът се одобрява автоматично
        $isApproved = $user['is_admin'] == 1 ? 1 : 0;

        $success = MovieDao::addMovie($title, $description, $releaseYear, $posterPath, $genreId, $user['id'], $actors, $isApproved);

        // Връща true при успех, иначе съобщение за грешка
        if ($success) {
            return true;
        } else {
            return "insert_failed"; // добавено за всеки случай
        }
    }

    // Връща детайли за конкретен филм 
    public function getMovieDetails($movieId) {
        return MovieDao::getMovieByMovieId($movieId);
    }

    public function getMovieReviewsPaged($movieId, $limit, $offset) {
        return ReviewDao::getReviewsByMovieIdPaged($movieId, $limit, $offset);
    }

    // Връща общ брой ревюта за филма
    public function getTotalReviewsCount($movieId) {
        return ReviewDao::getReviewCountByMovieId($movieId);
    }

    // Проверява дали филмът е в любими на потребителя
    public function isFavouriteMovie($username, $movieId) {
        $user = UserDao::getUserByUsername($username);
        return FavouriteMovieDao::isFavourite($user['id'], $movieId);
    }

    // Връща средната оценка за филма
    public function getMovieRating($movieId) {
        return RatingDao::getMovieRating($movieId);
    }

    // Добавя или премахва филма от любими на потребителя
    public function toggleFavourite($username, $movieId) {
        $user = UserDao::getUserByUsername($username);

        $userId = $user['id'];
        $isFavourite = FavouriteMovieDao::isFavourite($userId, $movieId);

        if ($isFavourite) {
            FavouriteMovieDao::removeFromFavourites($userId, $movieId);
        } else {
            FavouriteMovieDao::addToFavourites($userId, $movieId);
        }
    }

    // Връща списък с любими филми на потребителя, заедно с рейтингите им
    public function getUserFavouritesWithRatings($username) {
        $userData = UserDao::getUserByUsername($username);

        $userId = $userData['id'];
        return FavouriteMovieDao::getFavouritesWithRatings($userId);
    }

    // Връща филми, добавени от даден потребител, с техните рейтинги
    public function getAddedMoviesWithRatings($username) {

        $userData = UserDao::getUserByUsername($username);
        $userId = $userData['id'];

        $movies = MovieDao::getMoviesAddedByUser($userId);

        $moviesWithRatings = [];

        foreach ($movies as $movie) {
            $ratingData = RatingDao::getMovieRating($movie['id']);
            $movie['rating'] = round($ratingData['average_rating'], 1);
            $moviesWithRatings[] = $movie;
        }

        return $moviesWithRatings;
    }

// Връща филми, които очакват одобрение
    public function getMoviesAwaitingApproval() {
        return MovieDao::getMoviesAwaitingApproval();
    }

    public function getNotApprovedMovieById($movieId) {
        return MovieDao::getNotApprovedMovieByMovieId($movieId);
    }

    public function getMoviesForSearch() {
        $movies = [];

        // Ако е натиснат бутона за всички филми
        if (isset($_GET['showAll']) && $_GET['showAll'] == '1') {
            $movies = MovieDao::getAllApprovedMovies();

            // Ако има въведена дума за търсене
        } elseif (isset($_GET['query']) && trim($_GET['query']) !== '') {
            $query = trim($_GET['query']);
            $movies = MovieDao::searchMoviesByTitle($query);
        }

        return $movies;
    }

    public function isLikedReviewByUser($username, $reviewId) {
        return MovieDao::isReviewLikedByUser($username, $reviewId);
    }
}
