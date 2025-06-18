<?php

namespace Controller;

use Model\Rating;

class RatingController {

    public function submitRating() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            exit;
        }

        $username = $_SESSION['user'];
        
        //Вземаме ID на филма и рейтинга от POST
        $movieId = $_POST['movie_id'];
        $rating = $_POST['rating'];

        $model = new Rating;

        // Извикваме метода submitRating, който записва рейтинга за дадения потребител и филм
        $model->submitRating($username, $movieId, $rating);

        header("Location: ?target=movie&action=showMovie&id=" . $movieId);
        die();
    }
}
