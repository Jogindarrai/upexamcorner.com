<?php get_header(); ?>
<main class="mainbg">
    <div class="container-xxl">
        <div class="row">
            <!-- Sidebar code start here------------------------------>
            <div class="col-md-4 order-lg-2 order-md-2">
                <aside class="sticky-top pt-2 pb-2 formbg mt-4">
                    <div class="p-2 p-md-4">
                        <h2 class="text-center fs-3 fw-bold">Get a Free Consultation</h2>
                        <p class="text-center">Fill out the form below to get started.</p>
                        <?php
                        echo do_shortcode('[wpcode id="7131" commonform=""]');
                        ?>
                    </div>
                </aside>
            </div>
            <!-- Sidebar code end here------------------------------>
            <!-- Main content code start here------------------------------>
            <div class="col-md-8">
                <!-- Hero section start here -->
                <section class="pt-5 pb-5">
                    <h1 class="fs-2 text-white-md fw-bold"><?php the_title(); ?></h1>
                    <?php
                    $subtitle = get_post_meta(get_the_ID(), '_service_subtitle', true);
                    if ($subtitle) {
                        echo '<p class="text-white-md">' . esc_html($subtitle) . '</p>';
                    }
                    ?>
                </section>
                <!-- Hero section end  here -->
                <!-- Proces start here  -->
                <section class="bg-light p-3 process-wrapper">
                    <?php
                    $process_title = get_post_meta(get_the_ID(), '_process_title', true);
                    $process_subtitle = get_post_meta(get_the_ID(), '_process_subtitle', true);
                    $process_data = get_post_meta(get_the_ID(), '_process_data', true);
                    // Show Title and Subtitle Once
                    if (!empty($process_title)) {
                        echo '<h2 class="fw-bold fs-4">' . esc_html($process_title) . '</h2>';
                    }
                    if (!empty($process_subtitle)) {
                        echo '<div class="fw-bold mb-3">' . esc_html($process_subtitle) . '</div>';
                    }
                    // Show each process inside Bootstrap grid
                    if (!empty($process_data) && is_array($process_data)) {
                        echo '<div class="row">';
                        foreach ($process_data as $process) {
                    ?>
                            <div class="col-md-3 col-sm-6" style="margin-bottom: 20px; text-align:center;">
                                <div class="process-item shadow-sm h-100">
                                    <?php if (!empty($process['process_icon'])): ?>
                                        <img src="<?php echo esc_url($process['process_icon']); ?>" alt="Process Icon" style="height:60px; margin-bottom:10px; margin-top:10px" />
                                    <?php endif; ?>

                                    <?php if (!empty($process['custom_title'])): ?>
                                        <p><?php echo esc_html($process['custom_title']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                    <?php
                        }
                        echo '</div>'; // Close row
                    }
                    ?>
                </section>
                <!-- Proces end  here  -->
                <!-- Cta start here -->
                <section class="border rounded ctabg ">
                    <!-- Bootstrap 5 CTA Section -->
                    <div class="container ">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <div class="p-4">
                                    <h2 class="mb-3 fs-4 fw-bold">Start Your Company with RegistrationKraft</h2>
                                    <p class="mb-4">Looking to register your company in Delhi, Noida, or Gurgaon? RegistrationKraft offers expert assistance to help you navigate the registration process smoothly.</p>
                                    <!-- <a href="https://www.registrationkraft.com/" class="btn btn-primary">Get Started Now</a> -->
                                </div>
                            </div>
                            <div class="col-md-5 d-none d-md-block">
                                <img src="https://www.registrationkraft.com/wp-content/uploads/2025/04/organic-flat-customer-support-illustration.png" alt="Company Registration Illustration" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Cta end here -->
                <!-- Overview constent start here  -->
                <section class="bg-white pt-4 pb-4">
                    <div class="container-xxl">
                        <div class="row">
                            <div class="col-md-12">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Overview content end here  -->

                <!-- Type of content start here -->
                <section class="bg-white pt-4 pb-4">
                    <div class="container-xxl">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (have_posts()) :
                                    while (have_posts()) : the_post();
                                        $main_title = get_post_meta(get_the_ID(), 'service_main_title', true);
                                        $main_subtitle = get_post_meta(get_the_ID(), 'service_main_subtitle', true);
                                        $types = get_post_meta(get_the_ID(), 'service_types', true);
                                ?>

                                        <div class="service-content">
                                            <?php if ($main_title || $main_subtitle): ?>
                                                <div class="service-main-heading">
                                                    <?php if ($main_title): ?>
                                                        <h2 class="fs-3 fw-bold"><?php echo esc_html($main_title); ?></h2>
                                                    <?php endif; ?>
                                                    <?php if ($main_subtitle): ?>
                                                        <p><?php echo esc_html($main_subtitle); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($types) && is_array($types)) : ?>
                                                <div class="service-types">
                                                    <div class="row">
                                                        <?php foreach ($types as $type): ?>
                                                            <div class="col-md-4 service-type mb-4">
                                                                <div class="customs-shadowbox h-100">
                                                                    <?php if (!empty($type['title'])): ?>
                                                                        <div class="fw-bold bghead  text-white pt-2 pb-3 text-center"><?php echo esc_html($type['title']); ?></div>
                                                                    <?php endif; ?>

                                                                    <?php if (!empty($type['image'])): ?>
                                                                        <figure class="text-center mb-2 mt-3">
                                                                            <img src="<?php echo esc_url($type['image']); ?>" alt="<?php echo esc_attr($type['title']); ?>" class="type-icon" style="height:60px;">
                                                                        </figure>
                                                                    <?php endif; ?>

                                                                    <?php if (!empty($type['subtitle'])): ?>
                                                                        <p class="p-2 text-center"><?php echo nl2br(esc_html($type['subtitle'])); ?></p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                        </div>

                                <?php
                                    endwhile;
                                endif;
                                ?>


                            </div>
                        </div>
                    </div>
                </section>
                <!-- Type of content end here -->
                <!-- Requrement code start here -->
                <section class="pt-4 pb-4 bg-light p-3">
                    <?php
                    $title    = get_post_meta(get_the_ID(), '_requirements_title', true);
                    $subtitle = get_post_meta(get_the_ID(), '_requirements_subtitle', true);
                    $image_id = get_post_meta(get_the_ID(), '_requirements_image_id', true);
                    $text     = get_post_meta(get_the_ID(), '_requirements_text', true);

                    // Bootstrap Layout (example using two columns)
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($title): ?>
                                <h2 class="fw-bold fs-4"><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>

                            <?php if ($subtitle): ?>
                                <h5><?php echo esc_html($subtitle); ?></h5>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?php if ($text): ?>
                                <div><?php echo wpautop($text); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <?php if ($image_id): ?>
                                <?php echo wp_get_attachment_image($image_id, 'medium', false, array('class' => 'img-fluid')); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <!-- Requmrent code end here -->
                <!-- Document content display  code start here  -->
                <section class="pt-4 pb-4">
                    <?php
                    $title    = get_post_meta(get_the_ID(), '_documents_title', true);
                    $subtitle = get_post_meta(get_the_ID(), '_documents_subtitle', true);
                    $image_id = get_post_meta(get_the_ID(), '_documents_image_id', true);
                    $text     = get_post_meta(get_the_ID(), '_documents_text', true);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($title): ?>
                                <h2 class="fw-bold fs-4"><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>

                            <?php if ($subtitle): ?>
                                <h5 class="mb-3"><?php echo esc_html($subtitle); ?></h5>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 d-none">
                            <?php if ($image_id): ?>
                                <?php echo wp_get_attachment_image($image_id, 'medium', false, array('class' => 'img-fluid')); ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-12">
                            <?php if ($text): ?>
                                <div><?php echo wpautop($text); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Document conent displlay code end here  -->
                </section>

                <!-- Why choose us content start here -->
                <section class="bg-white pt-4 pb-4">
                    <div class="container-xxl">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                // Make sure to call this code inside a loop or when you have a specific post ID.
                                if (have_posts()) :
                                    while (have_posts()) : the_post();
                                        // Get the title, subtitle, and content from the metabox
                                        $why_choose_us_title = get_post_meta(get_the_ID(), '_why_choose_us_title', true);
                                        $why_choose_us_subtitle = get_post_meta(get_the_ID(), '_why_choose_us_subtitle', true);
                                        $why_choose_us_content = get_post_meta(get_the_ID(), '_why_choose_us_content', true);
                                ?>
                                        <div class="service-details">
                                            <div class="why-choose-us">
                                                <?php if ($why_choose_us_title) : ?>
                                                    <h2 class="fs-3 fw-bold"><?php echo esc_html($why_choose_us_title); ?></h2>
                                                <?php endif; ?>

                                                <?php if ($why_choose_us_subtitle) : ?>
                                                    <h3 class="fs-5"><?php echo esc_html($why_choose_us_subtitle); ?></h3>
                                                <?php endif; ?>

                                                <?php if ($why_choose_us_content) : ?>
                                                    <div class="why-choose-us-content">
                                                        <?php echo wp_kses_post($why_choose_us_content); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                <?php endwhile;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Why choose us content end  here -->


                <!-- Testimonial code start here  -->
                <section>
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="mb-4 fs-4 fw-bold">What Our Clients Say</h2>
                                <?php echo do_shortcode('[service_testimonials]'); ?>
                            </div>
                        </div>
                    </div>
                    <script>
                        function setEqualHeight() {
                            var maxHeight = 0;
                            $('.owl-carousel .owl-item .card').css('height', 'auto');
                            $('.owl-carousel .owl-item .card').each(function() {
                                var thisHeight = $(this).outerHeight();
                                if (thisHeight > maxHeight) {
                                    maxHeight = thisHeight;
                                }
                            });
                            $('.owl-carousel .owl-item .card').css('height', maxHeight + 'px');
                        }
                        $(document).ready(function() {
                            setEqualHeight();

                            $(window).on('resize', function() {
                                setEqualHeight();
                            });

                            $('.owl-carousel').on('initialized.owl.carousel resized.owl.carousel refreshed.owl.carousel changed.owl.carousel', function() {
                                setEqualHeight();
                            });
                        });
                    </script>
                    <script>
                        $(document).ready(function() {
                            $(".owl-carousel").owlCarousel({
                                loop: true,
                                margin: 10,
                                nav: false,
                                dots: true,
                                autoplay: true,
                                autoplayTimeout: 5000,
                                responsive: {
                                    0: {
                                        items: 1
                                    },
                                    768: {
                                        items: 2
                                    },
                                    992: {
                                        items: 2
                                    }
                                }
                            });
                        });
                    </script>
                </section>
                <!-- Testimonial code end here  -->
                <section>
                    <?php
                    $faqs = get_post_meta(get_the_ID(), '_service_faqs', true);
                    if (!empty($faqs)) : ?>
                        <div class="faq-section my-5">
                            <h2 class="mb-4 fw-bold fs-4">Frequently Asked Questions</h2>
                            <div class="accordion" id="faqAccordion">
                                <?php foreach ($faqs as $index => $faq): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="heading<?php echo $index; ?>">
                                            <button class="accordion-button collapsed d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="false" aria-controls="collapse<?php echo $index; ?>">
                                                <?php echo esc_html($faq['question']); ?>
                                                <!-- <span class="ms-auto toggle-icon">+</span> -->
                                            </button>
                                        </div>
                                        <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <?php echo esc_html($faq['answer']); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                </section>
            </div>
            <!-- Main content code end here------------------------------>
        </div>
    </div>
</main>
<!-- Bootstrap 5 JS -->
<?php get_footer(); ?>