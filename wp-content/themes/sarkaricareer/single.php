<?php
get_header();
?>
<div class="container-xxl">
    <div class="row" data-adbreak-exclude="true">
        <div class="col-md-12">
            <?php
            // Start the Loop.
            while (have_posts()) :
                the_post();
            ?>
                <article>
                    <section class="pt-4 pb-4">
                        <h1><?php the_title(); ?></h1>
                        <!--Custom breadcrume code start here -->
                        <?php custom_breadcrumbs(); ?>
                        <!--Custom breadcrume code end here -->
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
                        </div>
                        <div class="d-flex align-items-center mt-4 d-none">
                            <!-- Author Picture -->
                            <div class="flex-shrink-0">
                                <a class="mg-author-pic me-2" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                                </a>
                            </div>
                            <!-- Author Name and Title -->
                            <div class="flex-grow-1 d-none">
                                <div class="media-heading auther-tittle">
                                    <span><?php esc_html_e('By', 'newsup'); ?></span>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="extra-info mt-2  d-none">
                            <span><i class="fa-regular fa-calendar-days"></i></span>
                            <span><?php esc_html_e('Published on:', 'newsup'); ?></span>
                            <span><?php echo get_the_date(); ?></span>
                        </div>


                    </section>
              <section class="py-4">
    <div class="container-fluid px-0">
        <div class="row g-4">

            <!-- Left Side - Main Content -->
            <div class="col-lg-8 col-md-7">
                <div class="post-content-left">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Right Side - Sidebar -->
            <div class="col-lg-4 col-md-5">
                <div class="post-sidebar sticky-top" style="top: 80px;">

                    <!-- Widget 1: Categories -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📂 Categories</h5>
                        </div>
                        <div class="card-body">
                            <?php wp_list_categories([
                                'show_count' => true,
                                'title_li'   => '',
                                'orderby'    => 'name'
                            ]); ?>
                        </div>
                    </div>

                    <!-- Widget 2: Recent Posts -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">📰 Recent Posts</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php
                            $recent_posts = wp_get_recent_posts([
                                'numberposts' => 5,
                                'post_status' => 'publish'
                            ]);
                            foreach ($recent_posts as $post) : ?>
                                <a href="<?php echo get_permalink($post['ID']); ?>"
                                   class="d-flex align-items-center p-3 border-bottom text-decoration-none text-dark hover-bg">
                                    <?php if (has_post_thumbnail($post['ID'])) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($post['ID'], 'thumbnail'); ?>"
                                             class="rounded me-3"
                                             style="width:60px; height:60px; object-fit:cover;"
                                             alt="">
                                    <?php endif; ?>
                                    <span class="small fw-semibold">
                                        <?php echo esc_html($post['post_title']); ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Widget 3: Tags -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">🏷️ Tags</h5>
                        </div>
                        <div class="card-body">
                            <?php the_tags('<div class="d-flex flex-wrap gap-2">', '', '</div>'); ?>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Right Side End -->

        </div>
    </div>
</section>
                    <div class="row">
                        <div class="col-md-6">
                            <!--Post view display code start here--->
                            <div class="text-right mt-2"> <span class="btn btn-outline-dark border-1"><?php echo get_post_views(get_the_ID()); ?> <i class="fa fa-eye" aria-hidden="true"></i></span></div>
                            <!--Post view display code end here--->
                        </div>
                        <div class="col-md-6">
                            <?php
                            // Get the current post URL and title
                            $post_url = urlencode(get_permalink());
                            $post_title = urlencode(get_the_title());

                            // Facebook share link
                            $facebook_url = "https://www.facebook.com/sharer/sharer.php?u=$post_url";

                            // LinkedIn share link
                            $linkedin_url = "https://www.linkedin.com/sharing/share-offsite/?url=$post_url";

                            // X (formerly Twitter) share link
                            $x_url = "https://twitter.com/intent/tweet?text=$post_title&url=$post_url";
                            ?>

                            <!-- Social Share Buttons -->
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
                    <section class="tagcategories">
                        <p><strong>Categories:</strong> <?php the_category(', '); ?></p>
                        <p><strong>Tags:</strong> <?php the_tags('', ', ', ''); ?></p>
                    </section>
                    <!-- Related post display  -->
                    <section class="relatedpost">
                        <h3>Related Post </h3>
                        <?php
                        // Related posts section
                        $categories = wp_get_post_categories(get_the_ID());
                        if ($categories) {
                            $args = array(
                                'category__in' => $categories,
                                'post__not_in' => array(get_the_ID()), // Exclude current post
                                'posts_per_page' => 4, // Only 3 related posts
                            );

                            $related_posts = new WP_Query($args);

                            if ($related_posts->have_posts()) {
                                echo '<div class="row">'; // Start of Bootstrap row

                                while ($related_posts->have_posts()) {
                                    $related_posts->the_post();
                        ?>
                                    <div class="col-md-3 mb-4"> <!-- Bootstrap col-md-3 for 3 columns -->
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

                                echo '</div>'; // End of row
                                wp_reset_postdata();
                            }
                        }
                        ?>
                    </section>
                    <!-- Related post display end here  -->
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
        </div>
    </div>
</div>
<?php
get_footer();
?>