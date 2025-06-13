<?php

namespace Controller;

use Model\Genre;

class GenreController {

    public function view() {

        // Проверка дали потребителят е влязъл в системата
        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }

        // Вземаме ID-то на жанра от заявката
        $genreId = $_GET['id'];

        $genreModel = new Genre;

        // Вземаме данни за жанра, включително всички филми в него и техните оценки
        $data = $genreModel->getGenreWithMoviesAndRatings($genreId);

        // Ако не са намерени данни за жанра — показваме страница с грешка
        if (!$data) {
            require 'View/errors/error_page.php';
        } else {
            $genre = $data['genre'];
            $moviesWithRatings = $data['movies'];
            require 'View/movies/genre.php';
        }
    }
}
