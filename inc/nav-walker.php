<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom nav walker that mirrors the class names from partials/navbar-inner.php.
 * The source uses: <ul id="main-nav" class="nav navbar-nav clearfix"> with
 * dropdown children at class="dropdown"> and <ul class="dropdown-menu clearfix">.
 */
class NSP_Nav_Walker extends Walker_Nav_Menu {

    /** Open a level (ul) */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "\n{$indent}<ul class=\"dropdown-menu clearfix\">\n";
    }

    /** Close a level (ul) */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "{$indent}</ul>\n";
    }

    /** Open a menu item (li) */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent  = $depth ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;

        // Add 'dropdown' class when item has children
        if ( in_array( 'menu-item-has-children', $classes, true ) ) {
            $classes[] = 'dropdown';
        }

        // Active state
        if ( in_array( 'current-menu-item', $classes, true )
          || in_array( 'current-menu-parent', $classes, true )
          || in_array( 'current-menu-ancestor', $classes, true ) ) {
            $classes[] = 'active';
        }

        $class_names = implode( ' ', array_filter( array_unique( $classes ) ) );
        $class_str   = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id_str      = $item->ID ? ' id="menu-item-' . absint( $item->ID ) . '"' : '';

        $output .= "{$indent}<li{$id_str}{$class_str}>";

        // Build anchor
        $atts           = [];
        $atts['href']   = ! empty( $item->url ) ? $item->url : '#';
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['class']  = '';

        $attributes = '';
        foreach ( $atts as $attr => $val ) {
            if ( '' !== $val ) {
                $val         = ( 'href' === $attr ) ? esc_url( $val ) : esc_attr( $val );
                $attributes .= ' ' . $attr . '="' . $val . '"';
            }
        }

        $title   = nsp_translate_menu_title( apply_filters( 'the_title', $item->title, $item->ID ) );
        $arrow   = in_array( 'menu-item-has-children', $classes, true )
            ? ' <i class="fal fa-chevron-down nsp-nav-arrow" aria-hidden="true"></i>'
            : '';
        $output .= "<a{$attributes}>{$title}{$arrow}</a>";
    }

    /** Close a menu item (li) */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}
