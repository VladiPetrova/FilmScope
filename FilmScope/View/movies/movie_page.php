<?php require 'View/layouts/header.php'; ?>
<div class="container my-5">
    <div class="row">
        <!--  Постер на филма -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="d-flex flex-column align-items-center">
                <img src="<?= $movie['poster'] ?>"  alt="Movie Poster" class="movie-poster">
                <!-- Рейтинг  -->
                <div class="d-flex align-items-center mt-3">
                    <span class="star-rating">
                        <?php
                        $fullStars = floor($ratingData['average_rating']);
                        $halfStar = ($ratingData['average_rating'] - $fullStars) >= 0.5;

                        for ($i = 0; $i < $fullStars; $i++) {
                            echo '<i class="bi bi-star-fill"></i>';
                        }

                        if ($halfStar) {
                            echo '<i class="bi bi-star-half"></i>';
                        }
                        for ($i = $fullStars + $halfStar; $i < 5; $i++) {
                            echo '<i class="bi bi-star"></i>';
                        }
                        ?>
                    </span>
                    <span class="ms-2">
                        <?= round($ratingData['average_rating'], 1) ?>/5 (<?= $ratingData['total_votes'] ?> votes)
                    </span>
                </div>
            </div>
        </div>

        <!-- Информация за филма -->
        <div class="col-lg-8 col-md-6">
            <div class="movie-info p-4">
                <h2><?= $movie['title'] ?></h2>
                <p class="lead"><?= $movie['description'] ?>"</p>

                <!--  Актьорите  -->
                <h5>Actors:</h5>
                <p><?= $movie['actors'] ?></p> 

                <!-- Ревюта -->
                <?php if (!empty($reviews)) { ?>
                    <h4 class="mt-4">Reviews:</h4>
                    <?php foreach ($reviews as $review) { ?>
                        <div class="review-card card bg-secondary text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-warning"><?= $review['username'] ?></h5>
                                <p class="card-text"><?= $review['review'] ?></p>
                                <div class="d-flex align-items-center">
                                    <form action="?target=review&action=likeReview&id=<?= $movie['id'] ?>" method="POST" class="m-0 p-0 me-3">
                                        <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                        <?php if (isset($_SESSION['user'])) { ?>
                                            <button type="submit" name="like_review" value="<?= $review['id'] ?>"
                                                    class="btn btn-sm <?= in_array($review['id'], $likedReviewIds) ? 'btn-warning' : 'btn-outline-warning' ?> like-btn">
                                                <i class="bi bi-hand-thumbs-up me-1"></i>
                                                <?= in_array($review['id'], $likedReviewIds) ? 'Liked' : 'Like' ?>
                                            </button>
                                        <?php } ?>
                                    </form>
                                    <span class="like-count text-warning me-auto"><?= $review['like_count'] == 1 ? '1 like' : $review['like_count'] . ' likes' ?></span> 

                                    <?php if ($_SESSION["isAdmin"]) { ?>
                                        <form action="?target=review&action=deleteReview&review_id=<?= $review['id'] ?>&movie_id=<?= $movie['id'] ?>" method="POST" class="m-0 p-0" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($totalPages > 1) { ?>
                        <ul class="pagination justify-content-center">
                            <!-- Предишна страница -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?target=movie&action=showMovie&id=<?= $movieId ?>&page=<?= $page - 1 ?>"> Previous</a>
                            </li>

                            <?php
                            if ($start > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?target=movie&action=showMovie&id=' . $movieId . '&page=1">1</a></li>';
                                if ($start > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            for ($i = $start; $i <= $end; $i++) {
                                $active = ($i == $page) ? 'active' : '';
                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="?target=movie&action=showMovie&id=' . $movieId . '&page=' . $i . '">' . $i . '</a></li>';
                            }


                            if ($end < $totalPages) {
                                if ($end < $totalPages - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    echo '<li class="page-item"><a class="page-link" href="?target=movie&action=showMovie&id=' . $movieId . '&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                }
                            }
                            ?>

                            <!-- Следваща страница -->
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?target=movie&action=showMovie&id=<?= $movieId ?>&page=<?= $page + 1 ?>">Next</a>
                            </li>
                        </ul>
                    <?php } ?>
                <?php } ?>
                <?php if (isset($_SESSION['user'])) { ?>
                    <!-- Форма за харесване, рейтинг и ревю -->
                    <div class="card mt-4 bg-dark text-white">
                        <div class="card-body">
                            <h5>Like, rate and write a review!</h5>

                            <!-- Харесване -->
                            <form action="?target=movie&action=likeMovie" method="POST" class="mb-3">
                                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                <button type="submit" name="like" class="btn <?= $isFavourite ? 'btn-danger' : 'btn-outline-light' ?>">
                                    <i class="bi <?= $isFavourite ? 'bi-heart-fill' : 'bi-heart' ?>"></i> 
                                    <?= $isFavourite ? 'Liked' : 'Like' ?>
                                </button>
                            </form>

                            <!-- Рейтинг -->
                            <form action="?target=rating&action=submitRating" method="POST" class="d-flex align-items-end gap-2 mb-3">
                                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                <div>
                                    <label for="rating" class="form-label">Give a rating:</label>
                                    <select class="form-select" id="rating" name="rating" required>
                                        <?php if (isset($userRating) && $userRating != null) { ?>
                                            <option value="" disabled selected>
                                                <?= $userRating['rating'] === 1 ? '1 star' : $userRating['rating'] . ' stars' ?> </option>
                                        <?php } else { ?>
                                            <option value="" disabled selected>-- Choose --</option>
                                        <?php } ?>
                                        <option value="1">1 star</option>
                                        <option value="2">2 stars</option>
                                        <option value="3">3 stars</option>
                                        <option value="4">4 stars</option>
                                        <option value="5">5 stars</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Rate</button>
                                </div>
                            </form>

                            <!-- Оставяне на ревю -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">Leave a review</button>
                        </div>
                    </div>

                    <!-- Модално прозорче за оставяне на ревю -->
                    <form method="post" action="?target=review&action=submitReview">
                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-secondary text-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reviewModalLabel">Leave a review</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control" name="review" rows="5" placeholder="Your opinion..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="add_review">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="bg-warning text-dark text-center py-3 px-4 rounded mt-4">
                        <a href="?target=user&action=login" class="link-secondary link-offset-2 link-underline link-underline-opacity-0"><strong>Login to your account</strong></a> to rate this movie and leave a review.
                    </div>
                <?php } ?>
            </div> 
        </div> 
    </div> 
</div> 
<?php require 'View/layouts/footer.php'; ?>