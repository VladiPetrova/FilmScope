<?php  require 'View/layouts/header.php'; ?>
<!-- Add Movie Form Section -->
<section class="form-section my-4">
    <div class="container">
        <h3 class="text-center mb-4 fw-light text-white">Add movie in FilmScope</h3>
        <?php if (isset($error)){ ?>
            <div class="text-danger text-center mb-2"><?= $error ?></div>
        <?php } ?>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="form-card text-white p-4 rounded">

                    <!-- Movie Upload Form -->
                    <form action="?target=movie&action=addMovie" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="movieTitle" class="form-label">Movie Title</label>
                            <input type="text" class="form-control" id="movieTitle" name="movieTitle" required>
                        </div>

                        <div class="mb-3">
                            <label for="movieYear" class="form-label">Release Year</label>
                            <input type="number" class="form-control" id="movieYear" name="movieYear" min="1890" max="2100" required>
                        </div>

                        <div class="mb-3">
                            <label for="actors" class="form-label">Actors</label>
                            <input type="text" class="form-control" id="actors" name="actors" placeholder="Example: Actor 1, Actor 2, Actor 3" required>
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <select class="form-select" id="genre" name="genre" required>
                                <option value="" disabled selected>Select Genre</option>
                                <?php foreach ($genres as $genre) { ?>
                                    <option value="<?= $genre['id'] ?>"><?= $genre['genre_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="moviePoster" class="form-label">Movie Poster</label>
                            <input type="file" class="form-control" id="moviePoster" name="moviePoster" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="movieDescription" class="form-label">Movie Description</label>
                            <textarea class="form-control" id="movieDescription" name="movieDescription" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3" name="add_movie">Add Movie</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<?php require 'View/layouts/footer.php'; ?>