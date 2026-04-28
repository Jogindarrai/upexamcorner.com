<?php
get_header();
?>
<section class="py-4 herosection">
    <div class="container-xxl">
        <div class="row" data-adbreak-exclude="true">
            <div class="col-md-12">
                <?php
                while (have_posts()) :
                    the_post();
                ?>
                    <article>
                        <section class="py-4">
                            <div class="container-fluid px-0">
                                <div class="row g-4">
                                    <!-- Left Side - Main Content -->
                                    <div class="col-lg-8 col-md-7">
                                        <div class="bg-white p-3 ">
                                            <!-- Heading -->
                                            <h1><?php the_title(); ?></h1>
                                            <!-- Breadcrumb -->
                                            <?php custom_breadcrumbs(); ?>
                                            <!-- Featured Image -->
                                            <div class="post-thumbnail mt-3">
                                                <?php the_post_thumbnail('full', ['class' => 'img-fluid rounded']); ?>
                                            </div>
                                            <!-- Author (hidden) -->
                                            <div class="d-flex align-items-center mt-4 d-none">
                                                <div class="flex-shrink-0">
                                                    <a class="mg-author-pic me-2" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                        <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                                                    </a>
                                                </div>
                                                <div class="flex-grow-1 d-none">
                                                    <div class="media-heading auther-tittle">
                                                        <span><?php esc_html_e('By', 'newsup'); ?></span>
                                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Date (hidden) -->
                                            <div class="extra-info mt-2 d-none">
                                                <span><i class="fa-regular fa-calendar-days"></i></span>
                                                <span><?php esc_html_e('Published on:', 'newsup'); ?></span>
                                                <span><?php echo get_the_date(); ?></span>
                                            </div>
                                            <!-- Post Content -->
                                            <div class="mt-4 blog-details">
                                                <?php the_content(); ?>
                                            </div>
                                            <!-- Post Views + Share -->
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="text-right mt-2">
                                                        <span class="btn btn-outline-dark border-1">
                                                            <?php echo get_post_views(get_the_ID()); ?>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                    $post_url   = urlencode(get_permalink());
                                                    $post_title = urlencode(get_the_title());
                                                    $facebook_url = "https://www.facebook.com/sharer/sharer.php?u=$post_url";
                                                    $linkedin_url = "https://www.linkedin.com/sharing/share-offsite/?url=$post_url";
                                                    $x_url        = "https://twitter.com/intent/tweet?text=$post_title&url=$post_url";
                                                    ?>
                                                    <div class="social-share text-md-end text-center">
                                                        <a href="<?php echo $facebook_url; ?>" target="_blank" class="btn btn-facebook" title="Share on Facebook">
                                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon/facebook.svg'); ?>" alt="<?php bloginfo('name'); ?>" height="30">
                                                        </a>
                                                        <a href="<?php echo $linkedin_url; ?>" target="_blank" class="btn btn-linkedin" title="Share on LinkedIn">
                                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon/linkedin.svg'); ?>" alt="<?php bloginfo('name'); ?>" height="30">
                                                        </a>
                                                        <a href="<?php echo $x_url; ?>" target="_blank" class="btn btn-twitter" title="Share on X">
                                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon/twitter-x.svg'); ?>" alt="<?php bloginfo('name'); ?>" height="25">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- Categories & Tags -->
                                            <section class="tagcategories">
                                                <p><strong>Categories:</strong> <?php the_category(', '); ?></p>
                                                <p><strong>Tags:</strong> <?php the_tags('', ', ', ''); ?></p>
                                            </section>

                                            <!-- Related Posts -->
                                            <section class="relatedpost">
                                                <h3>Related Post</h3>
                                                <?php
                                                $categories = wp_get_post_categories(get_the_ID());
                                                if ($categories) {
                                                    $args = array(
                                                        'category__in' => $categories,
                                                        'post__not_in' => array(get_the_ID()),
                                                        'posts_per_page' => 4,
                                                    );
                                                    $related_posts = new WP_Query($args);
                                                    if ($related_posts->have_posts()) {
                                                        echo '<div class="row">';
                                                        while ($related_posts->have_posts()) {
                                                            $related_posts->the_post();
                                                ?>
                                                            <div class="col-md-3 mb-4">
                                                                <div class="related-post-card">
                                                                    <?php if (has_post_thumbnail()) : ?>
                                                                        <a href="<?php the_permalink(); ?>">
                                                                            <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <p class="related-post-title">
                                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                <?php
                                                        }
                                                        echo '</div>';
                                                        wp_reset_postdata();
                                                    }
                                                }
                                                ?>
                                            </section>

                                            <!-- Comments -->
                                             <div class="wp-comment">
                                            <?php
                                            if (comments_open() || get_comments_number()) :
                                                comments_template();
                                            endif;
                                            ?>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Left Side End -->
                                    <!-- Right Side - Sidebar -->
                                    <div class="col-lg-4 col-md-5">
                                    <div class="post-sidebar">
                                  <?php get_sidebar(); ?>
                                     </div>
                                    </div>
                                    <!-- Right Side End -->
                                </div>
                            </div>
                        </section>
                    </article>
                <?php
                endwhile;
                ?>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
?>