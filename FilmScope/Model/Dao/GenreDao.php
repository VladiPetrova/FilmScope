<?php

namespace Model\Dao;

class GenreDao extends DbConnection {

    public static function getAllGenres() {
        $pdo = self::getPdo();
        $stmt = $pdo->query("SELECT * FROM genres");
        return $stmt->fetchAll();
    }

    public static function getGenreById($genreId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM genres WHERE id = ?");
        $stmt->execute([$genreId]);
        return $stmt->fetch();
    }
}
