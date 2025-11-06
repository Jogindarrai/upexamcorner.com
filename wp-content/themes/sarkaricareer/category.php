<?php get_header(); ?>
<section class="pt-4 pb-4">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12">
                <h1>Category: <?php single_cat_title(); ?></h1>
                <?php
                if (is_category()) {
                    $category = get_queried_object();
                    echo '<div class="category-description">';
                    echo '<p>' . category_description($category->term_id) . '</p>'; // Display category description
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
<div class="container-xxl">
    <div class="row">
        <div class="col-md-8">
            <main class="pt-4 pb-4 ">
                <?php
                if (have_posts()) :
                ?>
                    <?php
                    while (have_posts()) : the_post();
                    ?>
                        <article class="categories-list shadow-sm p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php if (has_post_thumbnail()) : // Check if the post has a featured image
                                    ?>

                                        <div class="post-thumbnail mb-3"> <!-- Add some margin below the image -->
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); // Display the featured image with responsive class
                                                ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <div><?php the_excerpt(); ?></div>
                                </div>
                            </div>
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