<?php get_header(); ?>
<div class="container-xxl">
    <div class="row">
        <div class="col-md-12">
            <div class="author-info">
                <h1>Author: <?php the_author(); ?></h1>
                <p><?php the_author_meta('description'); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl">
    <div class="row">
        <div class="col-md-8">
            <main class="pt-4 pb-4 ">
                <div class="categories-list shadow-sm p-3">
                    <h2>Posts by <?php the_author(); ?>:</h2>
                    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="post mb-4">
            <div class="row">
                <div class="col-md-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?> <!-- Add 'img-fluid' class for responsiveness -->
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="post-excerpt"><?php the_excerpt(); ?></div>
                </div>
            </div>
            <hr>
        </div>

    <?php endwhile; ?>

    <!-- Pagination -->
    <div class="pagination">
        <?php
        echo paginate_links( array(
            'prev_text'    => '&laquo; Prev',  // Previous page text
            'next_text'    => 'Next &raquo;',  // Next page text
            'mid_size'     => 2,  // Number of pages to show around current page
            'end_size'     => 1,  // Number of pages to show at the beginning and end
        ) );
        ?>
    </div>

<?php else : ?>
    <p>No posts found.</p>
<?php endif; ?>

                </div>
            </main>
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
<?php get_footer(); ?>