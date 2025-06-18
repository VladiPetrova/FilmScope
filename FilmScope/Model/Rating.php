<?php

namespace Model;

use Model\Dao\UserDao;
use Model\Dao\RatingDao;

class Rating {

    public function submitRating($username, $movieId, $rating) {

        $userData = UserDao::getUserByUsername($username);

        $userId = $userData['id'];

        // Проверяваме дали потребителят вече е оценявал този филм
        if (RatingDao::hasUserRated($userId, $movieId)) {
            // Ако е оценявал – обновява рейтинга
            RatingDao::updateRating($userId, $movieId, $rating);
        } else {
            // Ако не е оценявал – добавя нов рейтинг
            RatingDao::addRating($userId, $movieId, $rating);
        }
    }
}
