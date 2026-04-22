<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
    <aside id="secondary" class="widget-area  mt-4 mt-lg-0">

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <div class="card-header bg-primary text-white py-3 px-4">
                <h5 class="mb-0 fw-bold">Latest Updates</h5>
            </div>

            <div class="card-body p-4 bg-light">
                <?php dynamic_sidebar( 'primary-sidebar' ); ?>
            </div>

        </div>

    </aside>
<?php endif; ?>