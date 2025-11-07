<?php
// inc/class-bootstrap-navwalker.php

class Bootstrap_NavWalker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth >= 1) ? ' dropdown-submenu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu\">\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = !empty($args->walker->has_children);

        $classes[] = 'nav-item';
        if ($has_children) $classes[] = 'dropdown';
        if ($depth >= 1) $classes[] = 'dropdown-submenu';

        $class_names = implode(' ', array_filter($classes));
        $output .= $indent . '<li class="' . esc_attr($class_names) . '">';

        $atts = array();
        $atts['class'] = ($depth === 0) ? 'nav-link' : 'dropdown-item';

        if ($has_children && $depth === 0) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['aria-expanded'] = 'false';
        }

        $atts['href'] = !empty($item->url) ? $item->url : '#';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
        }

        $output .= '<a' . $attributes . '>';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';
    }
public function display_element($element, &$children, $max_depth, $depth, $args, &$output) {

    $id = $this->db_fields['id'];

    // ✅ Check if $args is array or object
    if (is_array($args)) {

        if (isset($children[$element->$id])) {
            $args[0]->has_children = true;
        }

    } elseif (is_object($args)) {

        if (isset($children[$element->$id])) {
            $args->has_children = true;
        }
    }

    return parent::display_element($element, $children, $max_depth, $depth, $args, $output);
}

}
