<?php get_header(); ?>
<main>
    <?php
    if ( have_posts() ) :
        ?>
        <h1><?php single_cat_title(); ?></h1>
        <?php
        while ( have_posts() ) : the_post();
            ?>
            <article>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div><?php the_excerpt(); ?></div>
            </article>
            <?php
        endwhile;
        // Pagination (if needed)
        the_posts_pagination();
    else :
        ?>
        <p>No posts found in this category.</p>
        <?php
    endif;
    ?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
