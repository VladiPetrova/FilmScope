<?php

namespace Model\Dao;

class FavouriteMovieDao extends DbConnection {

    public static function addToFavourites($userId, $movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("INSERT INTO favourite_films (user_id, movie_id) VALUES (?, ?)");
        $stmt->execute([$userId, $movieId]);
    }

    public static function isFavourite($userId, $movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM favourite_films WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetchColumn() > 0;
    }

    public static function removeFromFavourites($userId, $movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("DELETE FROM favourite_films WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
    }

    //Връща списък с всички любими филми за даден потребител, включително средна оценка и брой гласове за всеки филм.
    //Coalesce осигурява, че ако няма оценки, ще върне 0 вместо NULL.
    public static function getFavouritesWithRatings($userId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("
        SELECT 
            m.*, 
            COALESCE(AVG(r.rating), 0) AS average_rating,
            COUNT(r.rating) AS total_votes
        FROM favourite_films fm
        JOIN movies m ON m.id = fm.movie_id
        LEFT JOIN ratings r ON r.movie_id = m.id
        WHERE fm.user_id = ?
        GROUP BY m.id
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
