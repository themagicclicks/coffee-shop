
 <!-- ✅ JavaScript (Placed at the end for faster loading) -->
    
    <!-- ✅ jQuery CDN -->
   <!-- <script src="js/jquery-3.7.1.min.js"></script>-->

    <!-- ✅ Materialize JS CDN -->
    <script src="../js/materialize.min.js"></script>
    <script src="https://unpkg.com/pell"></script>
    <script>
        var base = '<?php echo BASE; ?>';
        var site = '<?php echo SITE; ?>';
    </script>
    <!-- ✅ Custom JS -->
    <script src="js/scripts.js"></script>
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
