<?php wp_footer(); ?>
<footer>

    <div class="bottom-footer pt-3 pb-2 border-top">
        <div class="container-xxl">
                      <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu ',

                            'container'      => false,
                        ));
                        ?>


                    </div>
                </div>
            </div>


        </div>
    </div>

       <div class="copyright-footer pt-3 pb-2 border-top">
        <div class="container-xxl">

            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        Copyright 2025. Sarkaricareer All rights reserved. ​
                    </div>
                </div>
            </div>

        </div>
    </div>

</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>