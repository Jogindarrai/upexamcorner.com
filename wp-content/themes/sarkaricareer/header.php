<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body <?php body_class(); ?>>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-xxl">

            <!-- ✅ Dynamic Logo -->
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <?php echo wp_get_attachment_image( get_theme_mod('custom_logo'), 'full', false, array('height' => '30') ); ?>
                <?php else : ?>
                    <?php bloginfo('name'); ?>
                <?php endif; ?>
            </a>

            <!-- ✅ Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- ✅ WordPress Menu -->
            <div class="collapse navbar-collapse" id="mainMenu">
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1
                    ));
                ?>
            </div>

        </div>
    </nav>
</header>
