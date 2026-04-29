<?php
// If the post is password protected and the visitor has not yet entered the password we will return early without loading the comments.
if ( post_password_required() ) {
    return;
}
?>
<section class="">
<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'your-theme' ),
                number_format_i18n( get_comments_number() )
            );
            ?>
        </h2>
        <ul class="comment-list">
            <?php
            wp_list_comments();
            ?>
        </ul>

    <?php endif; ?>

    <?php
    comment_form();
    ?>
</div>
</section>
