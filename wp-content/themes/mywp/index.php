<?php get_header(); ?>

<main>
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // Get the post title and permalink
        $title = get_the_title();
        $permalink = get_the_permalink();

        // Output the title with a link
        echo '<h1><a href="' . esc_url($permalink) . '">' . esc_html($title) . '</a></h1>';

        // Output the post content
        the_content();
    endwhile;
else :
    echo '<p>No content found</p>';
endif;
?>

</main>

<?php get_footer(); ?>
