<?php
get_header();
?>
<section class="custom-page">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-8">
                <section class="pt-4 pb-4">
                    <?php
                    // Start the Loop.
                    while (have_posts()) :
                        the_post();
                    ?>
                        <article>
                            <header>
                                <h1><?php the_title(); ?></h1>
                            </header>
                            <div>
                                <?php the_content(); ?>
                            </div>
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
                </section>
            </div>
            <div class="col-md-4">
                <section class="shadow-sm p-3 sidebar ">
                    <?php
                    get_sidebar();

                    ?>
                </section>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
?>