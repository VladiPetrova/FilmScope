<?php require 'View/layouts/header.php'; ?>
<div class="container my-5">
    <h1 class="fw-light d-flex align-items-center gap-2 mb-3">
        <img class='genre-icon' src="assets/img/star.png" alt="Genre Icon">
        Reviews
    </h1>
    <div class="row">
        <div class="col-12">
            <!-- Таб за ревюта -->
            <ul class="nav nav-tabs" id="reviewTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-warning active" id="my-reviews-tab" data-bs-toggle="tab" href="#my-reviews" role="tab" aria-controls="my-reviews" aria-selected="true">Your reviews</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-warning" id="liked-reviews-tab" data-bs-toggle="tab" href="#liked-reviews" role="tab" aria-controls="liked-reviews" aria-selected="false">Liked reviews</a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="reviewTabsContent">
                <!-- Моите Ревюта -->
                <div class="tab-pane fade show active" id="my-reviews" role="tabpanel" aria-labelledby="my-reviews-tab">
                    <?php if (empty($userReviews)) { ?>
                        <p class="text-light">You haven't written any reviews yet.</p>
                    <?php } else { ?>
                        <div class="scrollable-reviews">
                            <?php foreach ($userReviews as $review) { ?>
                                <div class="review-card card bg-secondary text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-warning"><?= $review['username'] ?></h5>
                                        <h6 class="card-subtitle my-2 text-light">Movie: <?= $review['movie_title'] ?></h6>
                                        <p class="card-text"><?= $review['review'] ?></p>
                                        <div class="d-flex align-items-center">
                                            <span class="like-count text-warning"><?= $review['like_count'] ?> likes</span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- Харесани Ревюта -->
                <div class="tab-pane fade" id="liked-reviews" role="tabpanel" aria-labelledby="liked-reviews-tab">
                    <?php if (empty($likedReviews)) { ?>
                        <p class="text-light">You haven't liked any reviews yet.</p>
                    <?php } else { ?>
                        <div class="scrollable-reviews">
                            <?php foreach ($likedReviews as $review) { ?>
                                <div class="review-card card bg-secondary text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-warning"><?= $review['username'] ?></h5>
                                        <h6 class="card-subtitle my-2 text-light">Movie: <?= $review['movie_title'] ?></h6>
                                        <p class="card-text"><?= $review['review'] ?></p>
                                        <div class="d-flex align-items-center">
                                            <span class="like-count text-warning"><?= $review['like_count'] ?> likes</span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require 'View/layouts/footer.php'; ?>