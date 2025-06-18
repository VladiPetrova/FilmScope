<?php

namespace Model;

use Model\Dao\GenreDao;
use Model\Dao\MovieDao;
use Model\Dao\RatingDao;

class Genre {

    public function getGenreWithMoviesAndRatings($genreId) {
        $genre = GenreDao::getGenreById($genreId);

        // Ако жанрът не съществува, връща null
        if (!$genre) {
            return null;
        }

        $movies = MovieDao::getMoviesByGenreId($genreId);
        $moviesWithRatings = [];

        // За всеки филм взима рейтинга му чрез RatingDao
        foreach ($movies as $movie) {
            $ratingData = RatingDao::getMovieRating($movie['id']);
            $movie['rating'] = round($ratingData['average_rating'], 1);
            $moviesWithRatings[] = $movie;
        }

        return ['genre' => $genre, 'movies' => $moviesWithRatings];
    }
}
