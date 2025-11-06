<?php
/**
 * Template Name: Full Page
 * Description: A full-width page template without sidebar.
 */

get_header();
?>

<main id="primary" class="site-main" style="width:100%; max-width:100%; padding:0; margin:0;">
    <div class="fullpage-wrapper" style="width:100%; padding:0; margin:0;">
        <?php
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
