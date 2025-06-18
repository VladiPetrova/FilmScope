<?php

namespace Model\Dao;

class ReviewDao extends DbConnection {

    public static function addReview($userId, $movieId, $review) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, movie_id, review, created_at) VALUES (?, ?, ?, CURDATE())");
        $stmt->execute([$userId, $movieId, $review]);
    }

    public static function getReviewsByMovieId($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("
        SELECT r.id, r.review, r.created_at, u.username,
               (SELECT COUNT(*) FROM review_likes WHERE review_id = r.id) as like_count
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        WHERE r.movie_id = ?
        ORDER BY r.created_at DESC
    ");
        $stmt->execute([$movieId]);
        return $stmt->fetchAll();
    }

    public static function likeOrUnlikeReview($userId, $reviewId) {
        $pdo = self::getPdo();

        // Проверка дали вече е харесал
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM review_likes WHERE user_id = ? AND review_id = ?");
        $stmt->execute([$userId, $reviewId]);
        $alreadyLiked = $stmt->fetchColumn() > 0;

        if (!$alreadyLiked) {
            $stmt = $pdo->prepare("INSERT INTO review_likes (user_id, review_id) VALUES (?, ?)");
            $stmt->execute([$userId, $reviewId]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM review_likes WHERE user_id = ? AND review_id = ?");
            $stmt->execute([$userId, $reviewId]);
        }
    }

    public static function getReviewsByUsername($username) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("
        SELECT r.id, r.review, r.created_at, u.username, m.title AS movie_title,
               (SELECT COUNT(*) FROM review_likes WHERE review_id = r.id) AS like_count
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        JOIN movies m ON r.movie_id = m.id
        WHERE u.username = ?
        ORDER BY r.created_at DESC
    ");
        $stmt->execute([$username]);
        return $stmt->fetchAll();
    }

    public static function getLikedReviewsByUsername($username) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("
        SELECT r.id, r.review, r.created_at, u.username, m.title AS movie_title,
               (SELECT COUNT(*) FROM review_likes WHERE review_id = r.id) AS like_count
        FROM review_likes rl
        JOIN reviews r ON rl.review_id = r.id
        JOIN users u ON r.user_id = u.id
        JOIN movies m ON r.movie_id = m.id
        WHERE rl.user_id = (SELECT id FROM users WHERE username = ?)
        ORDER BY r.created_at DESC
    ");
        $stmt->execute([$username]);
        return $stmt->fetchAll();
    }

    public static function deleteReviewById($reviewId) {
        $pdo = self::getPdo();

        // Първо изтриваме лайковете
        $stmt = $pdo->prepare("DELETE FROM review_likes WHERE review_id = ?");
        $stmt->execute([$reviewId]);

        // След това изтриваме ревюто
        $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->execute([$reviewId]);
    }

    public static function getReviewsByMovieIdPaged($movieId, $limit, $offset) {
        $pdo = self::getPdo();
        $limit = $limit;
        $offset = $offset;
        $sql = "
        SELECT r.id, r.review, r.created_at, u.username,
               (SELECT COUNT(*) FROM review_likes WHERE review_id = r.id) as like_count
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        WHERE r.movie_id = ?
        ORDER BY r.created_at DESC
        LIMIT $limit OFFSET $offset
    ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$movieId]);

        return $stmt->fetchAll();
    }

    public static function getReviewCountByMovieId($movieId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        return $stmt->fetchColumn();
    }
}
