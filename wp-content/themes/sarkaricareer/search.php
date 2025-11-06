<?php get_header(); ?>
<section class="serch-wrapper pt-4 pb-4">
<div class="container-xxl">
    <h1 class="my-4">Search Results for: <?php echo get_search_query(); ?></h1>
    <?php if (have_posts()) : ?>
        <div class="row">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-md-4 mb-4">
                    <article class="card shadow-sm">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        <!-- Pagination -->
        <nav>
            <?php
            the_posts_pagination(array(
                'prev_text' => '<span >Previous</span>',
                'next_text' => '<span >Next</span>',
            ));
            ?>
        </nav>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            <?php _e('Sorry, no results were found.', 'your-text-domain'); ?>
        </div>
    <?php endif; ?>
</div>
</section>
<?php get_footer(); ?>