<?php
require get_template_directory() . '/inc/bootstrap-mega-menu-walker.php';

function my_custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_custom_theme_setup');

function my_custom_theme_scripts() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');

function register_my_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu'),
        // Register additional menus here if needed
    ));
}
add_action('init', 'register_my_menus');

function your_theme_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'your-theme' ),
        'id'            => 'primary-sidebar',
        'description'   => __( 'Main sidebar that appears on the right.', 'your-theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'your_theme_widgets_init' );


/** breadcrumbs Custom code start here------------------------------------------------------ */

function custom_breadcrumbs() {
    $separator = ' | ';
    $home = 'Home'; // text for the 'Home' link

    // Get the query & post information
    global $post;
    $homeLink = home_url();
    echo '<nav class="breadcrumb bg-light p-3" aria-label="breadcrumb"><a class="breadcrumb-item me-2 ms-2" href="' . $homeLink . '">' . $home . '</a>';

    if (is_home() || is_front_page()) {
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">Blog</span>';
    } elseif (is_category()) {
        // Show the category name
        $category = get_queried_object();
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">' . $category->name . '</span>';
    } elseif (is_single()) {
        // Show categories for the current post
        $categories = get_the_category();
        if (!empty($categories)) {
            $category = $categories[0];
            echo ' <span>' . $separator . '</span> <a class="breadcrumb-item me-2 ms-2" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
        }
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active text-muted ms-3">' . get_the_title() . '</span>';
    } elseif (is_page()) {
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">' . get_the_title() . '</span>';
    } elseif (is_tag()) {
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">Tag: ' . single_tag_title('', false) . '</span>';
    } elseif (is_author()) {
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">Author: ' . get_the_author() . '</span>';
    } elseif (is_search()) {
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">Search results for: ' . get_search_query() . '</span>';
    } elseif (is_404()) {
        echo ' <span>' . $separator . '</span> <span class="breadcrumb-item active">Error 404</span>';
    }
    echo '</nav>';

}
/** breadcrumbs Custom code end here------------------------------------------------------ */





/** Post view counter code start here------------------------------------------------------ */

// Ensure no direct access to the file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to count post views
function count_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
    } else {
        $count = (int) $count;
    }
    $count++;
    update_post_meta($postID, $count_key, $count);
}

// Function to track post views, excluding admin views
function track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    if (!current_user_can('edit_posts')) { // Check if the user is not an admin
        count_post_views($post_id);
    }
}
add_action('wp_head', 'track_post_views');

// Function to display post views
function get_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        add_post_meta($postID, $count_key, '0');
    }
    return $count . ' Views';
}



/**Post view counter  end here------------------------------------------------------ */

// Function to display the primary sidebar via shortcode
function primary_sidebar_shortcode() {
    ob_start();
    if (is_active_sidebar('primary-sidebar')) { // Check for the correct sidebar ID
        dynamic_sidebar('primary-sidebar'); // Use the same ID here
    } else {
        echo '<p>Primary sidebar not found.</p>';
    }
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('primary_sidebar', 'primary_sidebar_shortcode');


// Display webstroy code start here-----------------------------------------

function display_web_stories_with_pagination($atts) {
    // Define arguments for query: post type `web-story`, posts per page, etc.
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'web-story',  // Replace with the custom post type for Web Stories
        'posts_per_page' => 8,       // Set the number of stories per page
        'paged' => $paged,
    );

    // Create the query
    $query = new WP_Query($args);

    // Start output buffer
    ob_start();

    if ($query->have_posts()) :
        echo '<div class="web-stories-grid">';
        while ($query->have_posts()) : $query->the_post();
            echo '<div class="web-story row shadow-sm mb-5 align-items-center">';

            // Image in col-md-4
            echo '<div class="col-md-4">';
            if (has_post_thumbnail()) {
                echo '<a href="' . get_permalink() . '">';
                echo get_the_post_thumbnail(get_the_ID(), 'medium'); // Adjust 'medium' for desired image size
                echo '</a>';
            }
            echo '</div>';

            // Title, Author, and Description in col-md-8
            echo '<div class="col-md-8">';
            echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
            echo '<p class="web-story-author">By ' . get_the_author() . '</p>';
            echo '<p class="web-story-description">' . get_the_excerpt() . '</p>';
            echo '</div>';

            echo '</div>'; // end of row
        endwhile;
        echo '</div>'; // end of web-stories-grid

        // Pagination
        echo '<div class="web-stories-pagination">';
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
        ));
        echo '</div>';

    else :
        echo '<p>No Web Stories found.</p>';
    endif;

    // Reset post data
    wp_reset_postdata();

    // Return the content
    return ob_get_clean();
}

add_shortcode('web_stories_pagination', 'display_web_stories_with_pagination');

// Display webstroy code end  here-----------------------------------------


// Function for services page pages start here -----------------------------------------

function register_services_cpt() {
    $labels = array(
        'name'               => 'Services',
        'singular_name'      => 'Service',
        'menu_name'          => 'Services',
        'name_admin_bar'     => 'Service',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Service',
        'edit_item'          => 'Edit Service',
        'new_item'           => 'New Service',
        'view_item'          => 'View Service',
        'all_items'          => 'All Services',
        'search_items'       => 'Search Services',
        'not_found'          => 'No services found.',
        'not_found_in_trash' => 'No services found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array(
            'slug'       => 'service',
            'with_front' => false,
        ),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'register_services_cpt');

/**
 * Flush rewrite rules on activation to ensure custom post type permalinks work correctly.
 * Note: This should only be run once (e.g. on plugin activation or theme switch).
 */
function services_rewrite_flush() {
    // Register the CPT and then flush rewrite rules.
    register_services_cpt();
    flush_rewrite_rules();
}


// Remove service fron slug function start here-----------------------------------------
function remove_service_slug( $post_link, $post ) {
    if ( 'service' === $post->post_type && 'publish' === $post->post_status ) {
        $post_link = str_replace( '/service/', '/', $post_link );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'remove_service_slug', 10, 2 );
function add_service_to_query( $query ) {
    if ( ! $query->is_main_query() || ! isset( $query->query['name'] ) ) {
        return;
    }

    $query->set( 'post_type', array( 'post', 'page', 'service' ) );
}
add_action( 'pre_get_posts', 'add_service_to_query' );
// Remove service fron slug function end here-----------------------------------------





add_action('after_switch_theme', 'flush_rewrite_rules');

function flush_rewrite_on_theme_switch() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'flush_rewrite_on_theme_switch' );

function add_subtitle_meta_box() {
    add_meta_box(
        'service_subtitle',              // ID
        'Service Sub Title',            // Title in admin
        'render_subtitle_meta_box',     // Callback
        'service',                      // Post type
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_subtitle_meta_box');

function render_subtitle_meta_box($post) {
    $subtitle = get_post_meta($post->ID, '_service_subtitle', true);
    ?>
    <input type="text" name="service_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width:100%;" placeholder="Enter sub title here..." />
    <?php
}
function save_service_subtitle($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['service_subtitle'])) {
        update_post_meta($post_id, '_service_subtitle', sanitize_text_field($_POST['service_subtitle']));
    }
}
add_action('save_post_service', 'save_service_subtitle');

// Function for requirment text start here-----------------------------------------

// Add Metabox
add_action('add_meta_boxes', function () {
    add_meta_box(
        'service_requirements',
        'Requirements',
        'render_service_requirements_metabox',
        'service',
        'normal',
        'default'
    );
});

// Render Metabox HTML
function render_service_requirements_metabox($post) {
    wp_nonce_field('save_service_requirements', 'service_requirements_nonce');
    $image_id   = get_post_meta($post->ID, '_requirements_image_id', true);
    $editor_content = get_post_meta($post->ID, '_requirements_text', true);
    $title      = get_post_meta($post->ID, '_requirements_title', true);
    $subtitle   = get_post_meta($post->ID, '_requirements_subtitle', true);
    $image_url  = $image_id ? wp_get_attachment_url($image_id) : '';
    ?>

    <p>
        <label><strong>Requirements Title:</strong></label><br>
        <input type="text" name="requirements_title" value="<?php echo esc_attr($title); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Requirements Subtitle:</strong></label><br>
        <input type="text" name="requirements_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Upload Image:</strong></label><br>
        <input type="hidden" id="requirements_image_id" name="requirements_image_id" value="<?php echo esc_attr($image_id); ?>">
        <img id="requirements_image_preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; <?php echo $image_url ? '' : 'display:none;'; ?>"><br>
        <button type="button" class="button" id="upload_requirements_image_button">Upload Image</button>
        <button type="button" class="button" id="remove_requirements_image_button" style="<?php echo $image_url ? '' : 'display:none;'; ?>">Remove</button>
    </p>

    <p>
        <label><strong>Requirements Text:</strong></label>
        <?php
        wp_editor($editor_content, 'requirements_text', array(
            'textarea_name' => 'requirements_text',
            'media_buttons' => true,
            'textarea_rows' => 6,
        ));
        ?>
    </p>
    <?php
}

// Save Metabox Data
add_action('save_post', function ($post_id) {
    if (!isset($_POST['service_requirements_nonce']) || !wp_verify_nonce($_POST['service_requirements_nonce'], 'save_service_requirements')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['requirements_image_id'])) {
        update_post_meta($post_id, '_requirements_image_id', intval($_POST['requirements_image_id']));
    }

    if (isset($_POST['requirements_text'])) {
        update_post_meta($post_id, '_requirements_text', wp_kses_post($_POST['requirements_text']));
    }

    if (isset($_POST['requirements_title'])) {
        update_post_meta($post_id, '_requirements_title', sanitize_text_field($_POST['requirements_title']));
    }

    if (isset($_POST['requirements_subtitle'])) {
        update_post_meta($post_id, '_requirements_subtitle', sanitize_text_field($_POST['requirements_subtitle']));
    }
});

// JavaScript for Media Upload
add_action('admin_footer', function () {
    global $post;
    if (!is_admin() || get_post_type($post) !== 'service') return;
    ?>
    <script>
    jQuery(document).ready(function($){
        let frame;
        $('#upload_requirements_image_button').on('click', function(e){
            e.preventDefault();
            frame = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                $('#requirements_image_id').val(attachment.id);
                $('#requirements_image_preview').attr('src', attachment.url).show();
                $('#remove_requirements_image_button').show();
            });
            frame.open();
        });

        $('#remove_requirements_image_button').on('click', function(e){
            e.preventDefault();
            $('#requirements_image_id').val('');
            $('#requirements_image_preview').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
});
// Function for requirment text end here-----------------------------------------

// Function for document requred start here -----------------------------------------
add_action('add_meta_boxes', function () {
    add_meta_box(
        'service_documents',
        'Documents',
        'render_service_documents_metabox',
        'service',
        'normal',
        'default'
    );
});

function render_service_documents_metabox($post) {
    wp_nonce_field('save_service_documents', 'service_documents_nonce');

    $image_id       = get_post_meta($post->ID, '_documents_image_id', true);
    $editor_content = get_post_meta($post->ID, '_documents_text', true);
    $title          = get_post_meta($post->ID, '_documents_title', true);
    $subtitle       = get_post_meta($post->ID, '_documents_subtitle', true);
    $image_url      = $image_id ? wp_get_attachment_url($image_id) : '';
    ?>

    <p>
        <label><strong>Title:</strong></label><br>
        <input type="text" name="documents_title" value="<?php echo esc_attr($title); ?>" class="widefat">
    </p>

    <p>
        <label><strong>Subtitle:</strong></label><br>
        <input type="text" name="documents_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="widefat">
    </p>

    <p>
        <label><strong>Upload Image:</strong></label><br>
        <input type="hidden" id="documents_image_id" name="documents_image_id" value="<?php echo esc_attr($image_id); ?>">
        <img id="documents_image_preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; <?php echo $image_url ? '' : 'display:none;'; ?>"><br>
        <button type="button" class="button" id="upload_documents_image_button">Upload Image</button>
        <button type="button" class="button" id="remove_documents_image_button" style="<?php echo $image_url ? '' : 'display:none;'; ?>">Remove</button>
    </p>

    <p>
        <label><strong>Document Requirements Text:</strong></label>
        <?php
        wp_editor($editor_content, 'documents_text', array(
            'textarea_name' => 'documents_text',
            'media_buttons' => true,
            'textarea_rows' => 6,
        ));
        ?>
    </p>
    <?php
}

add_action('save_post', function ($post_id) {
    if (!isset($_POST['service_documents_nonce']) || !wp_verify_nonce($_POST['service_documents_nonce'], 'save_service_documents')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['documents_image_id'])) {
        update_post_meta($post_id, '_documents_image_id', intval($_POST['documents_image_id']));
    }

    if (isset($_POST['documents_text'])) {
        update_post_meta($post_id, '_documents_text', wp_kses_post($_POST['documents_text']));
    }

    if (isset($_POST['documents_title'])) {
        update_post_meta($post_id, '_documents_title', sanitize_text_field($_POST['documents_title']));
    }

    if (isset($_POST['documents_subtitle'])) {
        update_post_meta($post_id, '_documents_subtitle', sanitize_text_field($_POST['documents_subtitle']));
    }
});

add_action('admin_footer', function () {
    global $post;
    if (!is_admin() || get_post_type($post) !== 'service') return;
    ?>
    <script>
    jQuery(document).ready(function($){
        let frame;
        $('#upload_documents_image_button').on('click', function(e){
            e.preventDefault();
            frame = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                $('#documents_image_id').val(attachment.id);
                $('#documents_image_preview').attr('src', attachment.url).show();
                $('#remove_documents_image_button').show();
            });
            frame.open();
        });

        $('#remove_documents_image_button').on('click', function(e){
            e.preventDefault();
            $('#documents_image_id').val('');
            $('#documents_image_preview').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
});

//Function for  document requred end here -----------------------------------------






function add_faq_meta_box() {
    add_meta_box(
        'service_faqs',             // ID
        'Service FAQs',             // Title
        'render_faq_meta_box',      // Callback
        'service',                  // Post type
        'normal',                   // Context
        'default'                   // Priority
    );
}
add_action('add_meta_boxes', 'add_faq_meta_box');

function render_faq_meta_box($post) {
    $faqs = get_post_meta($post->ID, '_service_faqs', true);
    if (!is_array($faqs)) {
        $faqs = [];
    }
    wp_nonce_field('save_service_faqs', 'service_faqs_nonce');
    ?>
    <div id="faq-fields">
        <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item" style="margin-bottom:15px;">
                <input type="text" name="service_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr($faq['question']); ?>" placeholder="Question" style="width:100%;margin-bottom:5px;" />
                <textarea name="service_faqs[<?php echo $index; ?>][answer]" placeholder="Answer" style="width:100%;height:70px;"><?php echo esc_textarea($faq['answer']); ?></textarea>
                <hr>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addFAQField()" class="button">+ Add FAQ</button>

    <script>
    let faqCount = <?php echo count($faqs); ?>;
    function addFAQField() {
        const container = document.getElementById('faq-fields');
        const index = faqCount++;
        const html = `
        <div class="faq-item" style="margin-bottom:15px;">
            <input type="text" name="service_faqs[${index}][question]" placeholder="Question" style="width:100%;margin-bottom:5px;" />
            <textarea name="service_faqs[${index}][answer]" placeholder="Answer" style="width:100%;height:70px;"></textarea>
            <hr>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    </script>
    <?php
}

function save_service_faqs($post_id) {
    if (!isset($_POST['service_faqs_nonce']) || !wp_verify_nonce($_POST['service_faqs_nonce'], 'save_service_faqs')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['service_faqs']) && is_array($_POST['service_faqs'])) {
        $cleaned_faqs = array_map(function($faq) {
            return [
                'question' => sanitize_text_field($faq['question']),
                'answer' => sanitize_textarea_field($faq['answer'])
            ];
        }, $_POST['service_faqs']);

        update_post_meta($post_id, '_service_faqs', $cleaned_faqs);
    } else {
        delete_post_meta($post_id, '_service_faqs');
    }
}
add_action('save_post_service', 'save_service_faqs');

add_action('add_meta_boxes', 'add_service_meta_boxes');

// Proces functions stsrt here

add_action('add_meta_boxes', 'add_service_meta_boxes');

function add_service_meta_boxes() {
    add_meta_box(
        'service_details_meta_box',
        'Service Details',
        'render_service_meta_box',
        'service',
        'normal',
        'high'
    );
}

function render_service_meta_box($post) {
    $process_data = get_post_meta($post->ID, '_process_data', true);

    wp_nonce_field('save_service_meta_box', 'service_meta_box_nonce');
    ?>
    <!-- Fixed Fields: Title and Subtitle (Ek hi baar) -->
    <div id="fixed-fields">
        <p>
            <label>Process Title:</label><br>
            <input type="text" name="process_title" value="<?php echo esc_attr(get_post_meta($post->ID, '_process_title', true)); ?>" class="regular-text" />
        </p>

        <p>
            <label>Process Subtitle:</label><br>
            <input type="text" name="process_subtitle" value="<?php echo esc_attr(get_post_meta($post->ID, '_process_subtitle', true)); ?>" class="regular-text" />
        </p>
    </div>

    <!-- Dynamic Process Wrapper -->
    <div id="process-wrapper">
        <?php
        if (!empty($process_data) && is_array($process_data)) {
            foreach ($process_data as $index => $process) {
                ?>
                <div class="process-group" style="margin-bottom:20px;padding:10px;border:1px solid #ccc;">
                    <p>
                        <label>Process Icon (Image):</label><br>
                        <input type="hidden" name="process_data[<?php echo $index; ?>][process_icon]" value="<?php echo esc_attr($process['process_icon'] ?? ''); ?>" class="process-icon-url" />
                        <?php if (!empty($process['process_icon'])): ?>
                            <img src="<?php echo esc_url($process['process_icon']); ?>" class="process-icon-preview" style="max-width:100px; display:block; margin-bottom:10px;" />
                        <?php else: ?>
                            <img src="" class="process-icon-preview" style="max-width:100px; display:none; margin-bottom:10px;" />
                        <?php endif; ?>
                        <button type="button" class="button upload-process-icon">Upload Image</button>
                    </p>

                    <p>
                        <label>Custom Title:</label><br>
                        <input type="text" name="process_data[<?php echo $index; ?>][custom_title]" value="<?php echo esc_attr($process['custom_title'] ?? ''); ?>" class="regular-text" />
                    </p>

                    <button type="button" class="button remove-process">Remove</button>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Button to Add More Process -->
    <button type="button" class="button" id="add-process">Add Process</button>

    <script>
    (function($){
        $(document).ready(function(){
            var processWrapper = $('#process-wrapper');
            var processIndex = <?php echo !empty($process_data) ? count($process_data) : 0; ?>;

            $('#add-process').click(function(){
                var html = `
                    <div class="process-group" style="margin-bottom:20px;padding:10px;border:1px solid #ccc;">
                        <p>
                            <label>Process Icon (Image):</label><br>
                            <input type="hidden" name="process_data[` + processIndex + `][process_icon]" class="process-icon-url" />
                            <img src="" class="process-icon-preview" style="max-width:100px; display:none; margin-bottom:10px;" />
                            <button type="button" class="button upload-process-icon">Upload Image</button>
                        </p>

                        <p>
                            <label>Custom Title:</label><br>
                            <input type="text" name="process_data[` + processIndex + `][custom_title]" class="regular-text" />
                        </p>

                        <button type="button" class="button remove-process">Remove</button>
                    </div>
                `;
                processWrapper.append(html);
                processIndex++;
            });

            $(document).on('click', '.remove-process', function(){
                $(this).closest('.process-group').remove();
            });

            // Image Upload Handling
            var mediaUploader;
            $(document).on('click', '.upload-process-icon', function(e){
                e.preventDefault();
                var button = $(this);
                var parent = button.closest('.process-group');

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media({
                    title: 'Select or Upload Icon Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function(){
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    parent.find('.process-icon-url').val(attachment.url);
                    parent.find('.process-icon-preview').attr('src', attachment.url).show();
                });

                mediaUploader.open();
            });
        });
    })(jQuery);
    </script>
    <?php
}

add_action('save_post', 'save_service_meta_box_data');

function save_service_meta_box_data($post_id) {
    if (!isset($_POST['service_meta_box_nonce']) || !wp_verify_nonce($_POST['service_meta_box_nonce'], 'save_service_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Fixed Fields (Process Title and Subtitle)
    if (isset($_POST['process_title'])) {
        update_post_meta($post_id, '_process_title', sanitize_text_field($_POST['process_title']));
    }

    if (isset($_POST['process_subtitle'])) {
        update_post_meta($post_id, '_process_subtitle', sanitize_text_field($_POST['process_subtitle']));
    }

    // Save Dynamic Process Data
    if (isset($_POST['process_data']) && is_array($_POST['process_data'])) {
        $clean_data = [];

        foreach ($_POST['process_data'] as $process) {
            $clean_data[] = [
                'process_icon' => esc_url_raw($process['process_icon'] ?? ''),
                'custom_title' => sanitize_text_field($process['custom_title'] ?? ''),
            ];
        }

        update_post_meta($post_id, '_process_data', $clean_data);
    } else {
        delete_post_meta($post_id, '_process_data');
    }
}


//Process  function ened here
// Type of content function start here -----------------------------------------
function add_service_type_metabox() {
    add_meta_box(
        'service_type_metabox',
        'Service Types',
        'render_service_type_metabox',
        'service',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_service_type_metabox');

function render_service_type_metabox($post) {
    $main_title = get_post_meta($post->ID, 'service_main_title', true);
    $main_subtitle = get_post_meta($post->ID, 'service_main_subtitle', true);
    $types = get_post_meta($post->ID, 'service_types', true);

    wp_nonce_field('save_service_types', 'service_types_nonce');
    ?>

    <p>
        <label>Main Title:</label><br>
        <input type="text" name="service_main_title" value="<?php echo esc_attr($main_title); ?>" style="width: 100%;" />
    </p>
    <p>
        <label>Main Subtitle:</label><br>
        <input type="text" name="service_main_subtitle" value="<?php echo esc_attr($main_subtitle); ?>" style="width: 100%;" />
    </p>
    <hr>

    <div id="service-types-wrapper">
        <?php if (!empty($types) && is_array($types)) : ?>
            <?php foreach ($types as $index => $type) : ?>
                <div class="type-group">
                    <p>
                        <label> Icon (Image):</label><br>
                        <input type="hidden" name="service_types[<?php echo $index; ?>][image]" value="<?php echo esc_attr($type['image'] ?? ''); ?>" class="process-icon-url" />
                        <?php if (!empty($type['image'])): ?>
                            <img src="<?php echo esc_url($type['image']); ?>" class="process-icon-preview" style="max-width:100px; display:block; margin-bottom:10px;" />
                        <?php else: ?>
                            <img src="" class="process-icon-preview" style="max-width:100px; display:none; margin-bottom:10px;" />
                        <?php endif; ?>
                        <button type="button" class="button upload-process-icon">Upload Image</button>
                    </p>
                    <p>
                        <label>Title:</label><br>
                        <input type="text" name="service_types[<?php echo $index; ?>][title]" value="<?php echo esc_attr($type['title']); ?>" />
                    </p>
                    <p>
                        <label>Subtitle:</label><br>
                        <textarea name="service_types[<?php echo $index; ?>][subtitle]" rows="4" style="width: 100%;"><?php echo esc_textarea($type['subtitle'] ?? ''); ?></textarea>
                    </p>
                    <p>
                        <button type="button" class="button remove-type-button">Remove Type</button>
                    </p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button id="add-type-button" class="button">Add Type</button>

    <script>
jQuery(document).ready(function($) {
    let typeIndex = <?php echo !empty($types) ? count($types) : 0; ?>;

    $('#add-type-button').on('click', function(e) {
        e.preventDefault();
        let html = `
            <div class="type-group">
                <p>
                    <label> Icon (Image):</label><br>
                    <input type="hidden" name="service_types[${typeIndex}][image]" class="process-icon-url" />
                    <img src="" class="process-icon-preview" style="max-width:100px; display:none; margin-bottom:10px;" />
                    <button type="button" class="button upload-process-icon">Upload Image</button>
                </p>
                <p>
                    <label>Title:</label><br>
                    <input type="text" name="service_types[${typeIndex}][title]" />
                </p>
                <p>
                    <label>Subtitle:</label><br>
                    <textarea name="service_types[${typeIndex}][subtitle]" rows="4" style="width: 100%;"></textarea>
                </p>
                <p>
                    <button type="button" class="button remove-type-button">Remove Type</button>
                </p>
                <hr>
            </div>
        `;
        $('#service-types-wrapper').append(html);
        typeIndex++;
    });

    $(document).on('click', '.remove-type-button', function() {
        if (confirm('Are you sure you want to remove this type?')) {
            $(this).closest('.type-group').remove();
        }
    });

    $(document).on('click', '.upload-process-icon', function(e) {
        e.preventDefault();
        let button = $(this);
        let input = button.siblings('.process-icon-url');
        let preview = button.siblings('.process-icon-preview');

        let custom_uploader = wp.media({
            title: 'Select Image',
            button: { text: 'Use this image' },
            multiple: false
        }).on('select', function() {
            let attachment = custom_uploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
            preview.attr('src', attachment.url).show();
        }).open();
    });
});
</script>


    <style>
        .type-group {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            position: relative;
        }
    </style>

    <?php
}

function save_service_types_meta($post_id) {
    if (!isset($_POST['service_types_nonce']) || !wp_verify_nonce($_POST['service_types_nonce'], 'save_service_types')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    update_post_meta($post_id, 'service_main_title', sanitize_text_field($_POST['service_main_title'] ?? ''));
    update_post_meta($post_id, 'service_main_subtitle', sanitize_text_field($_POST['service_main_subtitle'] ?? ''));

    if (isset($_POST['service_types']) && is_array($_POST['service_types'])) {
        $cleaned = array_map(function($item) {
            return array(
                'image' => esc_url_raw($item['image']),
                'title' => sanitize_text_field($item['title']),
                'subtitle' => sanitize_textarea_field($item['subtitle']),
            );
        }, $_POST['service_types']);

        update_post_meta($post_id, 'service_types', $cleaned);
    } else {
        delete_post_meta($post_id, 'service_types');
    }
}
add_action('save_post', 'save_service_types_meta');

//Type of content function end here -----------------------------------------
// Why choose us metabox start here -----------------------------------------
function add_why_choose_us_metabox() {
    add_meta_box(
        'why_choose_us_metabox', // Metabox ID
        'Why Choose Us',         // Metabox Title
        'render_why_choose_us_metabox', // Callback function
        'service', // Custom post type
        'normal',  // Context (normal, side, etc.)
        'default'  // Priority (default, low, high)
    );
}
add_action('add_meta_boxes', 'add_why_choose_us_metabox');

// Render the Metabox Content
function render_why_choose_us_metabox($post) {
    // Retrieve existing values if available
    $title = get_post_meta($post->ID, '_why_choose_us_title', true);
    $subtitle = get_post_meta($post->ID, '_why_choose_us_subtitle', true);
    $content = get_post_meta($post->ID, '_why_choose_us_content', true);

    // Add nonce for security
    wp_nonce_field('save_why_choose_us', 'why_choose_us_nonce');
    ?>

    <p>
        <label for="why_choose_us_title"><strong>Title:</strong></label><br>
        <input type="text" id="why_choose_us_title" name="why_choose_us_title" value="<?php echo esc_attr($title); ?>" style="width: 100%;" />
    </p>

    <p>
        <label for="why_choose_us_subtitle"><strong>Subtitle:</strong></label><br>
        <input type="text" id="why_choose_us_subtitle" name="why_choose_us_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width: 100%;" />
    </p>

    <p>
        <label for="why_choose_us_content"><strong>Content:</strong></label><br>
        <?php
        wp_editor(
            $content,
            'why_choose_us_content', // Editor ID
            array(
                'textarea_name' => 'why_choose_us_content',
                'media_buttons' => true, // Show media buttons
                'textarea_rows' => 6, // Height of the editor
            )
        );
        ?>
    </p>
    <?php
}

// Save Metabox Data
function save_why_choose_us_metabox_data($post_id) {
    // Check nonce for security
    if (!isset($_POST['why_choose_us_nonce']) || !wp_verify_nonce($_POST['why_choose_us_nonce'], 'save_why_choose_us')) {
        return;
    }

    // Check if the user has permissions to save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if user is allowed to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the values
    if (isset($_POST['why_choose_us_title'])) {
        update_post_meta($post_id, '_why_choose_us_title', sanitize_text_field($_POST['why_choose_us_title']));
    }

    if (isset($_POST['why_choose_us_subtitle'])) {
        update_post_meta($post_id, '_why_choose_us_subtitle', sanitize_text_field($_POST['why_choose_us_subtitle']));
    }

    if (isset($_POST['why_choose_us_content'])) {
        update_post_meta($post_id, '_why_choose_us_content', wp_kses_post($_POST['why_choose_us_content']));
    }
}
add_action('save_post', 'save_why_choose_us_metabox_data');

// Why choose us metabox end here--------------------------------------------






// Meta box fort testimonial start here-----------------------------------------
add_action('add_meta_boxes', 'add_testimonial_meta_box');
// Render Meta Box Content
function add_testimonial_meta_box() {
    add_meta_box(
        'service_testimonials',
        'Service Testimonials',
        'render_testimonial_meta_box',
        'service',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_testimonial_meta_box');
function render_testimonial_meta_box($post) {
    wp_nonce_field('save_testimonial_meta', 'testimonial_meta_nonce');

    $testimonials = get_post_meta($post->ID, '_service_testimonials', true);
    if (!is_array($testimonials)) {
        $testimonials = [];
    }

    echo '<div id="testimonial-repeater">';
    foreach ($testimonials as $index => $testimonial) {
        echo '<div class="testimonial-group" style="margin-bottom:20px;border:1px solid #ccc;padding:10px;">';
        echo '<p><strong>Testimonial Content:</strong><br>';
        wp_editor($testimonial['content'], 'testimonial_content_' . $index, [
            'textarea_name' => 'testimonial_content[]',
            'textarea_rows' => 6,
        ]);
        echo '</p>';
        echo '<p><strong>Name:</strong><br><input type="text" name="testimonial_name[]" value="' . esc_attr($testimonial['name']) . '" class="widefat"></p>';
        echo '<p><strong>Place:</strong><br><input type="text" name="testimonial_place[]" value="' . esc_attr($testimonial['place']) . '" class="widefat"></p>';
        echo '<button type="button" class="remove-testimonial button button-secondary">Remove</button>';
        echo '</div>';
    }

    echo '</div>';
    echo '<button type="button" class="add-testimonial button button-primary">Add Testimonial</button>';

    // JS for Add/Remove
    ?>
    <script>
        jQuery(document).ready(function($) {
            let index = <?php echo count($testimonials); ?>;
            $('.add-testimonial').on('click', function() {
                const html = `
                    <div class="testimonial-group" style="margin-bottom:20px;border:1px solid #ccc;padding:10px;">
                        <p><strong>Testimonial Content:</strong><br>
                        <textarea name="testimonial_content[]" rows="6" class="widefat"></textarea></p>
                        <p><strong>Name:</strong><br>
                        <input type="text" name="testimonial_name[]" class="widefat"></p>
                        <p><strong>Place:</strong><br>
                        <input type="text" name="testimonial_place[]" class="widefat"></p>
                        <button type="button" class="remove-testimonial button button-secondary">Remove</button>
                    </div>`;
                $('#testimonial-repeater').append(html);
            });

            $(document).on('click', '.remove-testimonial', function() {
                $(this).closest('.testimonial-group').remove();
            });
        });
    </script>
    <?php
}
function save_testimonial_meta_box($post_id) {
    if (!isset($_POST['testimonial_meta_nonce']) || !wp_verify_nonce($_POST['testimonial_meta_nonce'], 'save_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $contents = $_POST['testimonial_content'] ?? [];
    $names    = $_POST['testimonial_name'] ?? [];
    $places   = $_POST['testimonial_place'] ?? [];

    $testimonials = [];
    for ($i = 0; $i < count($contents); $i++) {
        if (trim($contents[$i]) !== '') {
            $testimonials[] = [
                'content' => wp_kses_post($contents[$i]),
                'name'    => sanitize_text_field($names[$i]),
                'place'   => sanitize_text_field($places[$i]),
            ];
        }
    }

    update_post_meta($post_id, '_service_testimonials', $testimonials);
}
add_action('save_post', 'save_testimonial_meta_box');

function service_testimonials_shortcode($atts) {
    global $post;
    $testimonials = get_post_meta($post->ID, '_service_testimonials', true);
    if (empty($testimonials)) return '';

    ob_start(); ?>
    <div class="owl-carousel owl-theme">
        <?php foreach ($testimonials as $t) : ?>
            <div class="item">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><?php echo esc_html($t['content']); ?></p>
                        <h5 class="card-title mt-3"><?php echo esc_html($t['name']); ?></h5>
                        <p class="card-subtitle text-muted"><?php echo esc_html($t['place']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('service_testimonials', 'service_testimonials_shortcode');
// Meta box for testimonials end here-----------------------------------------




// Function for services page pages end here -----------------------------------------


// SVG allow fumction start here-----------------------------------------
// Allow SVG Uploads
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Fix SVG in Media Library
function fix_svg() {
    echo '<style>
        img[src$=".svg"] {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'fix_svg');

// SVG allow fumction end here-----------------------------------------

// function for common form start here-----------------------------------------

// Custom Post Type: Leads




// Handle AJAX Lead Form Submit


function handle_submit_lead_form() {
    $name     = sanitize_text_field($_POST['name']);
    $mobile   = sanitize_text_field($_POST['mobile']);
    $email    = sanitize_email($_POST['email']);
    $comments = sanitize_textarea_field($_POST['comments']);
    $page_source = isset($_POST['page_source']) ? sanitize_text_field($_POST['page_source']) : '';

    if ( empty($name) || empty($mobile) || empty($email) ) {
        wp_send_json_error(['message' => 'All fields are required.']);
    }

    if ( !is_email($email) ) {
        wp_send_json_error(['message' => 'Invalid email address.']);
    }

    if ( !preg_match('/^[0-9]{10}$/', $mobile) ) {
        wp_send_json_error(['message' => 'Mobile number must be 10 digits.']);
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'leads'; // Table name with prefix

    $insert = $wpdb->insert(
        $table_name,
        [
            'name'        => $name,
            'mobile'      => $mobile,
            'email'       => $email,
            'comments'    => $comments,
            'page_source' => $page_source,
        ],
        ['%s', '%s', '%s', '%s', '%s']
    );

    if ($insert) {
        wp_send_json_success(['message' => 'Your lead has been submitted successfully!']);
    } else {
        wp_send_json_error(['message' => 'Failed to submit the lead.']);
    }
}


add_action('wp_ajax_submit_lead_form', 'handle_submit_lead_form');
add_action('wp_ajax_nopriv_submit_lead_form', 'handle_submit_lead_form');

function add_custom_leads_page() {
    add_menu_page(
        'Leads', // Page title
        'Leads', // Menu title
        'manage_options', // Capability
        'custom-leads', // Menu slug
        'render_custom_leads_page', // Callback function
        'dashicons-id', // Icon
        6 // Position
    );
}
add_action('admin_menu', 'add_custom_leads_page');

function render_custom_leads_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'leads';

    $leads = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );

    ?>
    <div class="wrap">
        <h1 class="mb-4">All Leads</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="leadsTable">
                <thead class="table-dark">
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Source</th>
                        <th>Comments</th>
                        <th>Submitted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( ! empty($leads) ) :
                        foreach ( $leads as $lead ) : ?>
                           <tr>
    <!-- <td><?php echo esc_html($lead->id); ?></td> -->
    <td><?php echo esc_html($lead->name); ?></td>
    <td><?php echo esc_html($lead->mobile); ?></td>
    <td><?php echo esc_html($lead->email); ?></td>
    <td><?php echo esc_html($lead->page_source); ?></td>

    <td><?php echo esc_html($lead->comments); ?></td>
<td data-order="<?php echo esc_attr((new DateTime($lead->created_at, new DateTimeZone('UTC')))
    ->setTimezone(new DateTimeZone('Asia/Kolkata'))
    ->format('Y-m-d H:i:s')); ?>">
    <?php
    $datetime = new DateTime($lead->created_at, new DateTimeZone('UTC')); 
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata')); 
    echo esc_html($datetime->format('d-m-Y h:i A'));
    ?>
</td>
    <td>
        <button class="btn btn-sm btn-danger delete-lead" data-id="<?php echo $lead->id; ?>">Delete</button>
    </td>
</tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap 5 + DataTables CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script>
    jQuery(document).ready(function($){
        $('#leadsTable').DataTable({
            "pageLength": 10,
            "order": [[5, 'desc']]
        });
    });



    // DELETE lead
    $(document).on('click', '.delete-lead', function() {
        if (confirm('Are you sure you want to delete this lead?')) {
            var leadId = $(this).data('id');

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'delete_lead',
                    lead_id: leadId
                },
                success: function(response) {
                    if (response.success) {
                        alert('Lead deleted successfully!');
                        location.reload(); // reload page to update table
                    } else {
                        alert('Failed to delete lead.');
                    }
                }
            });
        }
    });



    </script>


    <?php
}


function handle_delete_lead() {
    if (isset($_POST['lead_id'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'leads';
        $lead_id = intval($_POST['lead_id']);

        $deleted = $wpdb->delete($table_name, ['id' => $lead_id], ['%d']);

        if ($deleted) {
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_delete_lead', 'handle_delete_lead');


// functionfor common form end here-----------------------------------------



?>
