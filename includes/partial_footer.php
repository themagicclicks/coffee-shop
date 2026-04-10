    <!-- Footer -->
    <footer class="page-footer black-coffee">
        <div class="container">
            <div class="row">
                <div class="col l4 m4 s12">
                    <h1 class="logo"><img src="<?php echo SITE; ?>images/willow-cup-coffee-white.svg" alt="Willow Cup Coffee"></h1>
                </div>

                <div class="col l8 m8 s12">
                    <div class="row">
                        <div class="col l4 m4 s12"></div>
                        <div class="col l4 m4 s12">
                            <ul>
                                <li><a class="white-text" href="#!">Menu</a></li>
                                <li><a class="white-text" href="#!">About</a></li>
                                <li><a class="white-text" href="#!">Shop</a></li>
                                <li><a class="white-text" href="#!">Contact</a></li>
                            </ul>
                        </div>
                        <div class="col l4 m4 s12 align-right">
                            <em class="flow-text">Willow Cup Coffee<br>
                            1427 Maple Avenue<br>
                            Brooklyn, NY 11215<br>
                            United States</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <div class="container white-text center-align">
                &copy; <?= date('Y') ?> Willow Cup coffee. All rights reserved.
            </div>
        </div>
    </footer>
</body>

    <script src="<?php echo themeAssetUrl('js/materialize.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>window.SITE_URL = <?php echo json_encode(SITE); ?>;</script>
    <script src="<?php echo themeAssetUrl('js/scripts.js'); ?>"></script>
    <script>
        if (typeof window.IntersectionObserver === "function") {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.intersectionRatio > 0) {
                        entry.target.classList.add('show');
                    }
                });
            });

            document.querySelectorAll('.container').forEach(EL => { observer.observe(EL) });
        }
    </script>
</html>
