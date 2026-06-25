<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output post meta: date, author, category.
 */
function nsp_post_meta() {
    echo '<div class="post-meta ul-li">';
    echo '<ul>';
    echo '<li><i class="fal fa-calendar-alt"></i>' . esc_html( nsp_get_the_date() ) . '</li>';
    echo '<li><i class="fal fa-user"></i>' . esc_html( get_the_author() ) . '</li>';
    $cats = get_the_category();
    if ( $cats ) {
        $cat_name = nsp_cat_ar( $cats[0]->name ) ?: $cats[0]->name;
        echo '<li><i class="fal fa-tag"></i><a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cat_name ) . '</a></li>';
    }
    echo '</ul>';
    echo '</div>';
}

/**
 * Output star rating HTML (filled / empty stars).
 */
function nsp_star_rating( int $rating = 5 ) {
    $rating = min( 5, max( 1, $rating ) );
    echo '<div class="star-icon ul-li"><ul>';
    for ( $i = 1; $i <= 5; $i++ ) {
        $class = ( $i <= $rating ) ? 'fas fa-star' : 'far fa-star';
        echo '<li><i class="' . esc_attr( $class ) . '"></i></li>';
    }
    echo '</ul></div>';
}

/**
 * Render team skill progress bars from "_nsp_team_skills" meta.
 * Format per line: Label|Percent (e.g. "Commercial|92").
 */
function nsp_team_skills( int $post_id ) {
    $raw = get_post_meta( $post_id, '_nsp_team_skills', true );
    if ( ! $raw ) return;

    $lines = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
    echo '<div class="clinox-why-choose-skill-wrap headline pera-content">';
    echo '<div class="skill-progress-bar">';
    foreach ( $lines as $line ) {
        $parts   = array_map( 'trim', explode( '|', $line ) );
        $label   = $parts[0] ?? '';
        $percent = isset( $parts[1] ) ? (int) $parts[1] : 0;
        if ( ! $label ) continue;
        echo '<div class="skill-set-percent headline">';
        echo '<h4>' . esc_html( $label ) . '</h4>';
        echo '<div class="progress"><div class="progress-bar" data-percent="' . esc_attr( $percent ) . '"></div></div>';
        echo '</div>';
    }
    echo '</div></div>';
}

/**
 * Output the custom logo with a fallback to the source logo asset.
 */
function nsp_site_logo() {
    if ( has_custom_logo() && ! nsp_is_arabic() ) {
        the_custom_logo();
    } else {
        $logo_file = nsp_is_arabic() ? 'assets/img/logo/logo-ar.png' : 'assets/img/logo/logo.png';
        echo '<img src="' . esc_url( nsp_asset( $logo_file ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
    }
}

/**
 * Output the white footer logo with fallback.
 */
function nsp_footer_logo() {
    $logo = get_theme_mod( 'nsp_footer_logo', '' );
    if ( $logo && ! nsp_is_arabic() ) {
        echo '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
    } else {
        $logo_file = nsp_is_arabic()
            ? 'assets/img/logo/Footer-white -logo-ar.png'
            : 'assets/img/logo/Footer-white -logo.png';
        echo '<img src="' . esc_url( nsp_asset( $logo_file ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
    }
}
