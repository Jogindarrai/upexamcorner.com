<?php
get_header();
?>

<main>
    <?php
    // Start the Loop.
    while (have_posts()) :
        the_post();
    ?>

        <article>
            <header>
                <h1><?php the_title(); ?></h1>
                <p>Posted on <?php the_date(); ?> by <?php the_author(); ?></p>
            </header>

            <div>
                <?php the_content(); ?>
            </div>

            <footer>
                <p>Categories: <?php the_category(', '); ?></p>
                <p>Tags: <?php the_tags('', ', ', ''); ?></p>
            </footer>

            <?php
            // If comments are open or there is at least one comment, load the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </article>

    <?php
    endwhile; // End the loop.
    ?>
</main>

<?php
get_sidebar();
get_footer();
?>