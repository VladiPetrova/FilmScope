<?php require 'View/layouts/header.php'; ?>

<div class="container my-5">
    <h1 class="fw-light fw-light d-flex align-items-center gap-2 mb-3">
        <img class='genre-icon' src="assets/img/star.png" alt="Genre Icon">
        Movies Awaiting Approval
    </h1>
    <?php if (!empty($moviesAwaitingApproval)) { ?>
        <div class="list-group">
            <?php foreach ($moviesAwaitingApproval as $movie) { ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-1"><?= $movie['title'] ?></h5>
                            <p class="mb-1">Uploaded by: <?= $movie['uploader_username'] ?></p>
                            <a href="?target=movie&action=showAddedMovie&id=<?= $movie['id'] ?>" class=" text-decoration-none btn btn-link p-0">View Details</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <form method="post" action="?target=movie&action=approveMovie" class="me-2">
                                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form method="post" action="?target=movie&action=rejectMovie">
                                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>
        <div class = "d-flex flex-column justify-content-center align-items-center text-center" >
            <p class="text-white text-center mt-4">There are no movies waiting approval.</p>
            <img class="img-fluid error_pic" src="assets/img/error.png" alt="Error Image" >
        </div>
    <?php } ?>
</div>

<?php require 'View/layouts/footer.php'; ?>