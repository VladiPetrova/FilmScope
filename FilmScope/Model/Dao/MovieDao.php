<?php

namespace Model\Dao;

class MovieDao extends DbConnection {

    public static function getMoviesByGenreId($genreId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE genre_id = ? AND is_approved=1");
        $stmt->execute([$genreId]);
        return $stmt->fetchAll();
    }

    public static function addMovie($title, $description, $release_year, $poster, $genre_id, $user_id, $actors, $is_approved = 0) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("INSERT INTO movies (title, description, release_year, poster, genre_id, user_id, actors, date_added, is_approved) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), ?)");
        return $stmt->execute([$title, $description, $release_year, $poster, $genre_id, $user_id, $actors, $is_approved]);
    }

    public static function getMovieByMovieId($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ? AND is_approved=1");
        $stmt->execute([$movieId]);
        return $stmt->fetch();
    }

    public static function getNotApprovedMovieByMovieId($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ? AND is_approved=0");
        $stmt->execute([$movieId]);
        return $stmt->fetch();
    }

    public static function getMoviesAddedByUser($userId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE user_id=?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Взимаме всички филми, които все още не са одобрени,
    // като също така взимаме потребителското име на човека, който ги е качил.
    public static function getMoviesAwaitingApproval() {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("
        SELECT m.*, u.username as uploader_username
        FROM movies m 
        JOIN users u ON m.user_id = u.id 
        WHERE m.is_approved = 0
    ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function approveMovie($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("UPDATE movies SET is_approved = 1 WHERE id = ?");
        $stmt->execute([$movieId]);
    }

    public static function deleteMovie($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$movieId]);
    }

    public static function searchMoviesByTitle($searchTerm) {
        $pdo = self::getPdo();

        $stmt = $pdo->prepare("
        SELECT 
            m.id,
            m.title,
            m.poster,
            m.release_year,
            AVG(r.rating) AS rating
        FROM movies m
        LEFT JOIN ratings r ON m.id = r.movie_id
        WHERE m.title LIKE ? AND m.is_approved = 1
        GROUP BY m.id
    ");

        $stmt->execute([$searchTerm . '%']);
        return $stmt->fetchAll();
    }

    // Връщаме всички одобрени филми с техните средни оценки
    public static function getAllApprovedMovies() {
        $pdo = self::getPdo();

        $stmt = $pdo->prepare("
        SELECT 
            m.id,
            m.title,
            m.poster,
            m.release_year,
            AVG(r.rating) AS rating
        FROM movies m
        LEFT JOIN ratings r ON m.id = r.movie_id
        WHERE m.is_approved = 1
        GROUP BY m.id
    ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getMovieByTitle($title) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE LOWER(title) = LOWER(?) LIMIT 1");
        $stmt->execute([$title]);
        return $stmt->fetch();
    }

    public static function isReviewLikedByUser($username, $reviewId) {
        $pdo = self::getPdo();

        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        $userId = $user['id'];

        // Проверяваме дали съществува запис в review_likes таблицата
        $stmt = $pdo->prepare("SELECT * FROM review_likes WHERE user_id = ? AND review_id = ?");
        $stmt->execute([$userId, $reviewId]);

        return $stmt->fetch();
    }
}
