<?php

namespace Controller;

use Model\Review;

class ReviewController {

    public function submitReview() {
        if (isset($_POST['add_review'])) {

            $movieId = $_POST['movie_id'];
            $reviewText = (htmlentities(trim($_POST['review'])));

            // Ако текстът на ревюто не е празен
            if (!empty($reviewText)) {
                $model = new Review;
                // Извиква метода за записване на ревю, подавайки текущия потребител, ID на филма и текста
                $model->submitReview($_SESSION['user'], $movieId, $reviewText);
                header("Location: ?target=movie&action=showMovie&id=" . $movieId);
                die();
            }
        }
    }

    // Метод за харесване на ревю
    public function likeReview() {
        if (isset($_POST['like_review'])) {
            $reviewId = $_POST['review_id'];
            $movieId = $_GET['id'];

            $model = new Review;
            $model->likeReview($_SESSION['user'], $reviewId);

            header("Location: ?target=movie&action=showMovie&id=" . $movieId);
            die();
        }
    }

    // Метод за показване на страницата с ревюта на текущия потребител
    public function showReviewsPage() {

        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }

        $model = new Review;
        $username = $_SESSION['user'];

        // Взима всички ревюта, които потребителят е написал
        $userReviews = $model->getUserReviews($username);
        // Взима всички ревюта, които потребителят е харесал
        $likedReviews = $model->getLikedReviews($username);

        require_once 'View/movies/reviews.php';
    }

    public function deleteReview() {

        if (isset($_GET['review_id']) && isset($_GET['movie_id'])) {
            $reviewId = $_GET['review_id'];
            $movieId = $_GET['movie_id'];

            $model = new Review;
            // Извикваме метода за изтриване на ревю по ID
            $model->deleteReview($reviewId);

            header("Location: ?target=movie&action=showMovie&id=" . $movieId);
            die();
        }
    }
}
