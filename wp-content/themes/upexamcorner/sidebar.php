<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>

    <aside id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'primary-sidebar' ); ?>
    </aside>

<?php else : ?>

    <p class="no-widgets">Sidebar widgets not found</p>

<?php endif; ?>