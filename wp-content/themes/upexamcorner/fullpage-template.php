<?php

/**
 * Template Name: Full Page
 * Description: A full-width page template without sidebar.
 */

get_header();
?>

<section class="pt-4 pb-4">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12">
                                <!-- <h1 class="page-title mb-4"><?php the_title(); ?></h1> -->

                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>

            </div>
        </div>
    </div>
</section>

<?php
get_footer();
