
    <!-- ✅ Footer -->
    <footer class="page-footer black-coffee">
 
  <div class="container">
    <div class="row">
      <!-- Logo Section -->
      <div class="col l4 m4 s12">
        <h1 class="logo"><img src="<?php echo SITE; ?>images/willow-cup-coffee-white.svg" alt="Willow Cup Coffee"></h1>
      </div>

      <!-- Menu Columns -->
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
          <div class="col  l4 m4 s12 align-right">
              <em class="flow-text">Willow Cup Coffee<br>
              1427 Maple Avenue<br>
              Brooklyn, NY 11215<br>
              United States</em>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Copyright -->
  <div class="footer-copyright">
    <div class="container white-text center-align">
      © <?= date('Y') ?> Willow Cup coffee. All rights reserved.
    </div>
  </div>
</footer>


    <!-- ✅ JavaScript (Placed at the end for faster loading) -->
    
    <!-- ✅ jQuery CDN -->
   <!-- <script src="js/jquery-3.7.1.min.js"></script>-->

    <!-- ✅ Materialize JS CDN -->
    <script src="<?php echo themeAssetUrl('js/materialize.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <!-- ✅ Custom JS -->
    <script>window.SITE_URL = <?php echo json_encode(SITE); ?>;</script>
    <script src="<?php echo themeAssetUrl('js/scripts.js'); ?>"></script>
    <script>
        //the intersection observer script must be at the foot to work it seems
        if(typeof(window.IntersectionObserver) == "function"){
            console.log("IntersectionObserver available");
            let observer = new IntersectionObserver(
            (entries, observer) => { 
            entries.forEach(entry => {
                if (entry.intersectionRatio > 0) {
                    entry.target.classList.add('show');
                    //if($(entry.target).is('img')){
                    //   entry.target.src = entry.target.dataset.src;
                    //   entry.target.classList.add('is-loaded'); 
                    //}
                }else {
                    //entry.target.classList.remove('show');
                }
            
                
                //observer.unobserve(entry.target);
              });
            });
            
            //document.querySelectorAll('.img-to-load').forEach(EL => { observer.observe(EL) });
            document.querySelectorAll('.container').forEach(EL => { observer.observe(EL) });
            
            
            /*let iobserver = new IntersectionObserver(
            (entries, iobserver) => { 
            entries.forEach(entry => {
                console.log("here");
                entry.target.src = entry.target.dataset.src;
                iobserver.unobserve(entry.target);
                
              });
            });
            document.querySelectorAll('.img-to-load').forEach(EL => { iobserver.observe(EL) });*/
        }else{
            console.log("IntersectionObserver not available");
        } 
    </script>

</body>
</html>

