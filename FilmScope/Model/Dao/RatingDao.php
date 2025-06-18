<?php

namespace Model\Dao;

class RatingDao extends DbConnection {

    public static function hasUserRated($userId, $movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM ratings WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetchColumn() > 0;
    }

    public static function addRating($userId, $movieId, $rating) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("INSERT INTO ratings (user_id, movie_id, rating) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $movieId, $rating]);
    }

    public static function updateRating($userId, $movieId, $rating) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("UPDATE ratings SET rating = ? WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$rating, $userId, $movieId]);
    }

    public static function getMovieRating($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT AVG(rating) as average_rating, COUNT(*) as total_votes FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        return $stmt->fetch();
    }

    public static function getUserRatingForMovie($userId, $movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT rating FROM ratings WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetch();
    }
}
