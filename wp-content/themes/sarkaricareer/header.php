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
        <!-- ✅ TOP SECTION: Logo + Heading + Subheading -->
        <div class="bg-white py-3">
            <div class="container-xxl">
                <div class="d-flex align-items-center gap-3 justify-content-center">
                    <!-- Logo -->
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php if (has_custom_logo()) : ?>
                            <?php echo wp_get_attachment_image(
                                get_theme_mod('custom_logo'),
                                'full',
                                false,
                                array('style' => 'height:100px;width:auto;')
                            ); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"
                                style="height:100px;width:auto;" alt="Logo">
                        <?php endif; ?>
                    </a>
                    <!-- Heading + Subheading -->
                    <!-- <div class="text-center w-100">
                    <h1 class="mb-0 fw-bold text-danger" style="font-size:28px;">
                        <?php bloginfo('name'); ?>
                    </h1>
                    <p class="mb-0 text-muted" style="font-size:13px;">
                        <?php bloginfo('description'); ?>
                    </p>
                </div> -->
                </div>
            </div>
        </div>
        <!-- ✅ LINE -->
        <!-- ✅ NAVIGATION -->
        <div class="site-header">
            <nav class="navbar navbar-expand-lg  py-0">
                <div class="container-xxl">

                    <!-- Mobile Toggle -->
                    <button class="navbar-toggler my-1" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#mainMenu"
                        aria-controls="mainMenu"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Menu -->
                    <div class="collapse navbar-collapse" id="mainMenu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'navbar-nav mx-auto mynav',
                            'container'      => false,
                            'fallback_cb'    => false,
                            'depth'          => 3,
                            'walker'         => new Bootstrap_NavWalker(),
                        ));
                        ?>
                    </div>

                </div>
            </nav>
        </div>
    </header>
<section class="herosection-header">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12">
                <div class="header-content">
                    <h2>★ Welcome to UP Exam Corner — #1 Government Job & Exam Portal ★</h2>
                    <p class="tagline">Latest Sarkari Jobs, Results, Admit Card, Syllabus & Study Material</p>
                    <p class="subtitle">Trusted by Lakhs of Students for UP & All India Competitive Exam Updates</p>
                    <span class="tag">All in One Place</span>
                </div>
            </div>
        </div>
    </div>
</section>