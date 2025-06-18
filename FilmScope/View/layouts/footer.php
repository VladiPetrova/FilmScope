<footer class="mt-auto">
    <div class="bg-dark text-light pt-3 pb-4">
        <div class="container text-md-left">
            <!-- Bottom -->
            <div class="row text-center">
                <div class="col">
                    <p class="mb-0 text-warning">&copy; <?= date('Y') ?> FilmScope.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<button class="btn btn-warning position-fixed bottom-0 end-0 translate-middle d-none" onclick="scrollToTop()" id="back-to-up">
    <i class="fas fa-chevron-up" aria-hidden="true"></i>
</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.onscroll = () => {
        toggleTopButton();
    };

    function scrollToTop() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function toggleTopButton() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            document.getElementById('back-to-up').classList.remove('d-none');
        } else {
            document.getElementById('back-to-up').classList.add('d-none');
        }
    }
</script>
</body> 
</html>
