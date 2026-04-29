<?php get_header(); ?>
<section class="pt-4 pb-4">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12">
                <h1>Tag: <?php single_tag_title(); ?></h1>
                <?php
                if (is_tag()) {
                    $tag = get_queried_object();
                    echo '<div class="tag-description">';
                    echo '<p>' . tag_description($tag->term_id) . '</p>'; // Display tag description
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
                        <article class="tags-list shadow-sm p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail mb-3">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); ?>
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
                    the_posts_pagination();
                else :
                    ?>
                    <p>No posts found for this tag.</p>
                <?php
                endif;
                ?>
            </main>
        </div>
        <div class="col-md-4">
            <section class="shadow-sm p-3 sidebar">
                <?php get_sidebar(); ?>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>
