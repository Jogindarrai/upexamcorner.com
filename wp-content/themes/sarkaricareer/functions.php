<?php
require_once get_template_directory() . '/inc/class-bootstrap-navwalker.php';

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


// Theme supports
function sarkaricareer_theme_setup() {
    // custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 90,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // register primary menu
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'sarkaricareer' ),
    ) );
}
add_action( 'after_setup_theme', 'sarkaricareer_theme_setup' );


// Footer Menu Register
function sarkaricareer_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'sarkaricareer'),
        'footer'  => __('Footer Menu', 'sarkaricareer')
    ));
}
add_action('after_setup_theme', 'sarkaricareer_register_menus');



// ------------------------------------------Daily Quizzes start here--------------------------------
function create_daily_quiz_post_type() {
    register_post_type('daily_quiz', array(
        'labels' => array(
            'name' => __('Daily Quizzes'),
            'singular_name' => __('Daily Quiz'),
        ),
        'public' => true,
        'menu_icon' => 'dashicons-clipboard',
        'supports' => array('title'),
    ));
}
add_action('init', 'create_daily_quiz_post_type');
function add_quiz_meta_boxes() {
    add_meta_box(
        'quiz_questions_box',
        'Quiz Questions (Up to 10)',
        'quiz_questions_callback',
        'daily_quiz',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_quiz_meta_boxes');

function quiz_questions_callback($post) {
    $questions = get_post_meta($post->ID, 'quiz_questions', true);
    if (!is_array($questions)) $questions = [];

    for ($i = 0; $i < 10; $i++) {
        $q = isset($questions[$i]) ? $questions[$i] : ['question' => '', 'a' => '', 'b' => '', 'c' => '', 'd' => '', 'correct' => ''];
        ?>
        <div style="margin-bottom:15px;padding:10px;border:1px solid #ddd;border-radius:6px;">
            <strong>Question <?php echo $i + 1; ?></strong><br>
            <input type="text" name="quiz_questions[<?php echo $i; ?>][question]" value="<?php echo esc_attr($q['question']); ?>" placeholder="Question" style="width:100%;margin-bottom:5px;">
            <input type="text" name="quiz_questions[<?php echo $i; ?>][a]" value="<?php echo esc_attr($q['a']); ?>" placeholder="Option A" style="width:48%;margin-right:2%;">
            <input type="text" name="quiz_questions[<?php echo $i; ?>][b]" value="<?php echo esc_attr($q['b']); ?>" placeholder="Option B" style="width:48%;"><br>
            <input type="text" name="quiz_questions[<?php echo $i; ?>][c]" value="<?php echo esc_attr($q['c']); ?>" placeholder="Option C" style="width:48%;margin-right:2%;">
            <input type="text" name="quiz_questions[<?php echo $i; ?>][d]" value="<?php echo esc_attr($q['d']); ?>" placeholder="Option D" style="width:48%;"><br>
            <input type="text" name="quiz_questions[<?php echo $i; ?>][correct]" value="<?php echo esc_attr($q['correct']); ?>" placeholder="Correct Answer" style="width:100%;margin-top:5px;">
        </div>
        <?php
    }
}

function save_quiz_questions($post_id) {
    if (isset($_POST['quiz_questions'])) {
        update_post_meta($post_id, 'quiz_questions', $_POST['quiz_questions']);
    }
}
add_action('save_post', 'save_quiz_questions');

// ------------------------------------------Daily Quizzes end here--------------------------------


?>
