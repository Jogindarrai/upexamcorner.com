<?php get_header(); ?>

<div class="services-wrapper pt-5 pb-5">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Our Services</h1>
                <p  class="text-center fs-5">
                    RegistrationKraft is a comprehensive portal designed to meet all the business needs of entrepreneurs. We offer a wide range of services, including company incorporation, trademark registration and renewal, IRDAI license application and renewal, legal metrology licensing and renewal, etc.
                </p>
            </div>
        </div>
        <div class="row services-list">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="col-md-3 mb-4">
                    <div class="card h-100 d-flex flex-column">
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
        </a>
    <?php endif; ?>

    <div class="card-body d-flex flex-column flex-grow-1 ">
        <h5 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h5>
        <p class="card-text">
            <?php
            $excerpt = get_the_excerpt();
            echo mb_strimwidth($excerpt, 0, 160, '...');
            ?>
        </p>
        <div class="mt-auto">
            <a href="<?php the_permalink(); ?>" class="btn btn-dark btn-deepblue btn-block w-100">Get Started</a>
        </div>
    </div>
</div>

                    </div>
                <?php endwhile;
            else : ?>
                <p>No services found.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>