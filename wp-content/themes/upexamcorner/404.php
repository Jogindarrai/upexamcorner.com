<?php get_header(); ?>

<div id="primary" class="content-area pt-5 pb-5">
    <main id="main" class="site-main" role="main">
        <section class="error-404 not-found">
            <header class="page-header text-center">
                <h1 class="page-title"><?php _e( 'Oops! That page can’t be found.', 'your-textdomain' ); ?></h1>
            </header><!-- .page-header -->

            <div class="page-content text-center">
                <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'your-textdomain' ); ?></p>

                <?php get_search_form(); ?>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
