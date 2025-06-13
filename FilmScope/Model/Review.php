<?php

namespace Model;

use Model\Dao\UserDao;
use Model\Dao\ReviewDao;

class Review {

    public function submitReview($username, $movieId, $reviewText) {
        $user_info = UserDao::getUserByUsername($username);
        $userId = $user_info['id'];

        ReviewDao::addReview($userId, $movieId, $reviewText);
    }

    // Харесване или премахване на харесване на ревю
    public function likeReview($username, $reviewId) {
        $userData = UserDao::getUserByUsername($username);
        $userId = $userData['id'];

        ReviewDao::likeorUnlikeReview($userId, $reviewId);
    }

    public function getUserReviews($username) {
        return ReviewDao::getReviewsByUsername($username);
    }

    public function getLikedReviews($username) {
        return ReviewDao::getLikedReviewsByUsername($username);
    }

    public function deleteReview($reviewId) {
        ReviewDao::deleteReviewById($reviewId);
    }

    // Връща ревюта за филм, разделени на страници
    public function getReviewsByMovieIdPaged($movieId, $page = 1, $perPage = 5) {
        $total = ReviewDao::getReviewCountByMovieId($movieId);
        $totalPages = ceil($total / $perPage);

        if ($page < 1) {
            $page = 1;
        }

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $perPage;
        $reviews = ReviewDao::getReviewsByMovieIdPaged($movieId, $perPage, $offset);

        return [
            'reviews' => $reviews,
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }
}
