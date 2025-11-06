<?php
// inc/class-bootstrap-navwalker.php
class Bootstrap_NavWalker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' dropdown-submenu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu\">\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        if ( !empty($args->walker) && $args->walker->has_children ) {
            $classes[] = 'dropdown';
        }
        if ($depth && !empty($args->walker) && $args->walker->has_children) {
            $classes[] = 'dropdown-submenu';
        }
        $class_names = implode(' ', array_filter($classes));
        $output .= $indent . '<li class="' . esc_attr($class_names) . '">';
        $atts = array();
        $atts['class'] = ($depth == 0) ? 'nav-link' : 'dropdown-item';
        if ( !empty($args->walker) && $args->walker->has_children && $depth == 0 ) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['role'] = 'button';
            $atts['aria-expanded'] = 'false';
        }
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= $item_output;
    }

    // allow detection of children
    public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_array( $args ) && ! empty( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        } elseif ( is_object( $args ) ) {
            $args->has_children = ! empty( $children_elements[ $element->$id_field ] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}
