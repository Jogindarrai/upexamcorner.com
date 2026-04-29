<?php
require_once get_template_directory() . '/inc/class-bootstrap-navwalker.php';

/*--------------------------------------------------------------
# Theme Setup
--------------------------------------------------------------*/
function upexamcorner_theme_setup() {

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_theme_support('custom-logo', array(
        'height'      => 90,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'upexamcorner'),
        'footer'  => __('Footer Menu', 'upexamcorner'),
    ));
}
add_action('after_setup_theme', 'upexamcorner_theme_setup');


/*--------------------------------------------------------------
# Enqueue Styles
--------------------------------------------------------------*/
function upexamcorner_scripts() {
    wp_enqueue_style('upexamcorner-style', get_stylesheet_uri(), array(), '1.0');
}
add_action('wp_enqueue_scripts', 'upexamcorner_scripts');


/*--------------------------------------------------------------
# Sidebar
--------------------------------------------------------------*/
function upexamcorner_widgets_init() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'upexamcorner'),
        'id'            => 'primary-sidebar',
        'description'   => __('Main sidebar area.', 'upexamcorner'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'upexamcorner_widgets_init');


/*--------------------------------------------------------------
# Sidebar Shortcode
--------------------------------------------------------------*/
function primary_sidebar_shortcode() {
    ob_start();

    if (is_active_sidebar('primary-sidebar')) {
        dynamic_sidebar('primary-sidebar');
    }

    return ob_get_clean();
}
add_shortcode('primary_sidebar', 'primary_sidebar_shortcode');


/*--------------------------------------------------------------
# Breadcrumbs
--------------------------------------------------------------*/
function custom_breadcrumbs() {

    $separator = ' / ';
    $home_link = home_url('/');

    echo '<nav class="breadcrumb bg-light p-2 mb-3">';
    echo '<a href="' . esc_url($home_link) . '">Home</a>';

    if (is_category()) {
        echo $separator . single_cat_title('', false);

    } elseif (is_single()) {

        $categories = get_the_category();

        if (!empty($categories)) {
            echo $separator . '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
        }

        echo $separator . get_the_title();

    } elseif (is_page()) {

        echo $separator . get_the_title();

    } elseif (is_search()) {

        echo $separator . 'Search: ' . get_search_query();

    } elseif (is_404()) {

        echo $separator . '404 Error';
    }

    echo '</nav>';
}


/*--------------------------------------------------------------
# Post Views Counter
--------------------------------------------------------------*/
function count_post_views($postID) {

    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    $count = ($count == '') ? 0 : (int) $count;
    $count++;

    update_post_meta($postID, $count_key, $count);
}

function track_post_views() {

    if (is_single()) {

        global $post;

        if (!current_user_can('edit_posts')) {
            count_post_views($post->ID);
        }
    }
}
add_action('wp_head', 'track_post_views');

function get_post_views($postID) {

    $count = get_post_meta($postID, 'post_views_count', true);

    return ($count) ? $count . ' Views' : '0 Views';
}


/*--------------------------------------------------------------
# Allow SVG Upload
--------------------------------------------------------------*/
function upexamcorner_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'upexamcorner_mime_types');

function upexamcorner_fix_svg() {
    echo '<style>
        img[src$=".svg"]{
            width:100% !important;
            height:auto !important;
        }
    </style>';
}
add_action('admin_head', 'upexamcorner_fix_svg');


/*--------------------------------------------------------------
# Daily Quiz Custom Post Type
--------------------------------------------------------------*/
function create_daily_quiz_post_type() {

    register_post_type('daily_quiz', array(
        'labels' => array(
            'name'          => __('Daily Quizzes', 'upexamcorner'),
            'singular_name' => __('Daily Quiz', 'upexamcorner'),
        ),
        'public'      => true,
        'menu_icon'   => 'dashicons-welcome-learn-more',
        'supports'    => array('title'),
        'show_in_rest'=> true,
    ));
}
add_action('init', 'create_daily_quiz_post_type');


/*--------------------------------------------------------------
# Quiz Meta Box
--------------------------------------------------------------*/
function add_quiz_meta_boxes() {

    add_meta_box(
        'quiz_questions_box',
        'Quiz Questions',
        'quiz_questions_callback',
        'daily_quiz',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_quiz_meta_boxes');


function quiz_questions_callback($post) {

    $questions = get_post_meta($post->ID, 'quiz_questions', true);
    if (!is_array($questions)) {
        $questions = array();
    }

    for ($i = 0; $i < 10; $i++) {

        $q = isset($questions[$i]) ? $questions[$i] : array(
            'question' => '',
            'a' => '',
            'b' => '',
            'c' => '',
            'd' => '',
            'correct' => ''
        );
?>
<div style="border:1px solid #ddd;padding:10px;margin-bottom:10px;">
    <strong>Question <?php echo $i + 1; ?></strong><br><br>

    <input type="text" name="quiz_questions[<?php echo $i; ?>][question]" value="<?php echo esc_attr($q['question']); ?>" placeholder="Question" style="width:100%;margin-bottom:8px;">

    <input type="text" name="quiz_questions[<?php echo $i; ?>][a]" value="<?php echo esc_attr($q['a']); ?>" placeholder="Option A" style="width:48%;">
    <input type="text" name="quiz_questions[<?php echo $i; ?>][b]" value="<?php echo esc_attr($q['b']); ?>" placeholder="Option B" style="width:48%;float:right;"><br><br>

    <input type="text" name="quiz_questions[<?php echo $i; ?>][c]" value="<?php echo esc_attr($q['c']); ?>" placeholder="Option C" style="width:48%;">
    <input type="text" name="quiz_questions[<?php echo $i; ?>][d]" value="<?php echo esc_attr($q['d']); ?>" placeholder="Option D" style="width:48%;float:right;"><br><br>

    <input type="text" name="quiz_questions[<?php echo $i; ?>][correct]" value="<?php echo esc_attr($q['correct']); ?>" placeholder="Correct Answer" style="width:100%;">
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

?>