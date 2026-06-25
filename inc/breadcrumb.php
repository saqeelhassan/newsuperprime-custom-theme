<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output the breadcrumb section matching the source markup exactly.
 *
 * @param string $bg_image_url Absolute URL to the background image.
 * @param string $title        Page title shown in the breadcrumb.
 */
function nsp_breadcrumb( string $bg_image_url = '', string $title = '' ) {
    if ( '' === $bg_image_url ) {
        $bg_image_url = esc_url( nsp_asset( 'assets/img/banner/bread-bg-1920x520.jpg' ) );
    }
    if ( '' === $title ) {
        if ( is_singular() ) {
            $title = get_the_title();
        } elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title( '', false );
        } elseif ( is_tax() ) {
            $title = single_term_title( '', false );
        } elseif ( is_search() ) {
            $title = nsp_t( 'Search Results', 'نتائج البحث' );
        } elseif ( is_404() ) {
            $title = nsp_t( '404 Not Found', 'الصفحة غير موجودة' );
        } elseif ( is_home() ) {
            $title = nsp_t( 'Blog News', 'المدونة والأخبار' );
        } else {
            $title = get_the_title();
        }
    }

    $trail = nsp_breadcrumb_trail();
    ?>
    <section id="clinox-breadcrumb" class="clinox-breadcrumb-section breadcrumb_overlay position-relative top-position"
        data-background="<?php echo esc_url( $bg_image_url ); ?>">
        <div class="banner-shape position-absolute">
            <img src="<?php echo esc_url( $bg_image_url ); ?>" alt="">
        </div>
        <div class="container">
            <div class="breadcrumb-content headline ul-li position-relative">
                <h2><?php echo esc_html( $title ); ?></h2>
                <ul>
                    <?php echo $trail; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </ul>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Build the breadcrumb trail <li> items.
 */
function nsp_breadcrumb_trail(): string {
    $home = '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( nsp_t( 'Home', 'الرئيسية' ) ) . '</a></li>';

    if ( is_front_page() || is_home() ) {
        return $home;
    }

    $trail = $home;

    if ( is_singular( 'post' ) ) {
        $cats = get_the_category();
        if ( $cats ) {
            $trail .= '<li><a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a></li>';
        }
        $trail .= '<li>' . esc_html( nsp_get_post_ar( get_the_ID(), 'title' ) ?: ( nsp_is_arabic() ? nsp_missing_post_ar_text( 'title' ) : get_the_title() ) ) . '</li>';
    } elseif ( is_singular( 'service' ) ) {
        $trail .= '<li><a href="' . esc_url( nsp_post_type_archive_url( 'service', 'services' ) ) . '">' . esc_html( nsp_t( 'Services', 'خدماتنا' ) ) . '</a></li>';
        $trail .= '<li>' . esc_html( nsp_service_ar( get_the_title(), 'title' ) ?: get_the_title() ) . '</li>';
    } elseif ( is_singular( 'project' ) ) {
        $trail .= '<li><a href="' . esc_url( nsp_post_type_archive_url( 'project', 'projects' ) ) . '">' . esc_html( nsp_t( 'Projects', 'مشاريعنا' ) ) . '</a></li>';
        $trail .= '<li>' . esc_html( nsp_project_ar( get_the_title(), 'title' ) ?: get_the_title() ) . '</li>';
    } elseif ( is_singular( 'team' ) ) {
        $trail .= '<li><a href="' . esc_url( nsp_post_type_archive_url( 'team', 'team' ) ) . '">' . esc_html( nsp_t( 'Team', 'فريقنا' ) ) . '</a></li>';
        $trail .= '<li>' . esc_html( get_the_title() ) . '</li>';
    } elseif ( is_singular() ) {
        $trail .= '<li>' . esc_html( get_the_title() ) . '</li>';
    } elseif ( is_post_type_archive() ) {
        $trail .= '<li>' . esc_html( post_type_archive_title( '', false ) ) . '</li>';
    } elseif ( is_tax() ) {
        $term   = get_queried_object();
        $trail .= '<li>' . esc_html( $term->name ) . '</li>';
    } elseif ( is_category() ) {
        $trail .= '<li>' . esc_html( single_cat_title( '', false ) ) . '</li>';
    } elseif ( is_tag() ) {
        $trail .= '<li>' . esc_html( single_tag_title( '', false ) ) . '</li>';
    } elseif ( is_search() ) {
        $trail .= '<li>' . esc_html( nsp_t( 'Search Results', 'نتائج البحث' ) ) . '</li>';
    } elseif ( is_404() ) {
        $trail .= '<li>404</li>';
    } elseif ( is_page() ) {
        $trail .= '<li>' . esc_html( get_the_title() ) . '</li>';
    }

    return $trail;
}
