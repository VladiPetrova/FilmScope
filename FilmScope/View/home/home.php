
<?php  require 'View/layouts/header.php'; ?>
<!-- Hero секция -->
<section class="hero-section position-relative text-white">
    <div class="container position-relative z-1">
        <img class="img-fluid" src="assets/img/zaglavie.png" alt="Error Image" >
        <p class="lead mt-3 text-warning">Browse reviews and add your own movies.</p>

        <!-- Search bar -->
        <form class="container text-center search-bar mt-4" method="post" action="index.php?target=movie&action=searchResults">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="query" placeholder="Search for a movie..." aria-label="Search">
                <button class="btn custom-search-btn" type="submit" name="search">Search</button>
            </div>
        </form>
        <a href="index.php?target=movie&action=searchResults&showAll=1" class="btn btn-outline-light mt-3">See all movies</a>
    </div>
</section>

<?php require 'View/layouts/footer.php'; 