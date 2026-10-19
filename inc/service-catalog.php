<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_is_service_catalog(): bool {
    return is_post_type_archive( 'service' ) || is_page( 'services' ) || is_page_template( 'page-templates/tpl-services.php' );
}

add_action( 'wp_enqueue_scripts', function () {
    if ( ! nsp_is_service_catalog() && ! is_front_page() ) return;
    foreach ( [ 'css', 'js' ] as $ext ) {
        $file = '/assets/' . $ext . '/service-catalog.' . $ext;
        if ( 'css' === $ext ) wp_enqueue_style( 'nsp-service-catalog', NSP_THEME_URI . $file, [ 'nsp-main' ], filemtime( NSP_THEME_DIR . $file ) );
        else wp_enqueue_script( 'nsp-service-catalog', NSP_THEME_URI . $file, [ 'jquery' ], filemtime( NSP_THEME_DIR . $file ), nsp_script_args() );
    }
} );

function nsp_catalog_services(): array {
    $posts = get_posts( [ 'post_type' => 'service', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ] );
    $images = [ 'carpet' => 'Carpet-Cleaning.jpg', 'office' => 'Office-Cleaning-Service.jpg', 'car wash' => 'Car-Wash-Service.jpg', 'car washing' => 'Car-Wash-Service.jpg', 'shifting' => 'Home-Shifting-Service.jpg', 'ac ' => 'AC-Maintenance-Service.jpg', 'pest' => 'Pest-Control-Service.jpg', 'home' => 'Home-Cleaning-Service.jpg' ];
    $services = [];
    foreach ( $posts as $post ) {
        $plain_title = html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' );
        $fallback = 'Home-Cleaning-Service.jpg';
        foreach ( $images as $match => $filename ) {
            if ( false !== strpos( strtolower( $post->post_title ), $match ) ) { $fallback = $filename; break; }
        }
        foreach ( nsp_service_directory() as $entry ) {
            if ( $entry['title'] === $plain_title && 'pest' === $entry['group'] ) $fallback = 'Pest-Control-Service.jpg';
        }
        $packages = array_values( array_filter( nsp_booking_packages( $post->ID ), function ( $row ) {
            return is_array( $row ) && ! empty( $row['package_name'] ) && isset( $row['package_price'] ) && is_numeric( $row['package_price'] ) && is_finite( (float) $row['package_price'] ) && (float) $row['package_price'] >= 0;
        } ) );
        $description = get_post_meta( $post->ID, '_nsp_service_short_desc', true ) ?: ( $post->post_excerpt ?: wp_trim_words( wp_strip_all_tags( $post->post_content ), 22 ) );
        $terms = get_the_terms( $post->ID, 'service_category' );
        $categories = [];
        foreach ( is_array( $terms ) ? $terms : [] as $term ) {
            $categories[] = (int) $term->term_id;
            $categories = array_merge( $categories, get_ancestors( $term->term_id, 'service_category', 'taxonomy' ) );
        }
        $services[] = [
            'id' => $post->ID,
            'price_label' => nsp_service_price_label( $post->ID ),
            'categories' => array_values( array_unique( $categories ) ),
            'title' => nsp_service_ar( $plain_title, 'title' ) ?: $plain_title,
            'description' => nsp_service_ar( $post->post_title, 'desc' ) ?: $description,
            'image' => get_the_post_thumbnail_url( $post->ID, 'large' ) ?: nsp_service_image_url( $fallback ),
            'url' => get_permalink( $post->ID ),
            'packages' => $packages,
            'price' => $packages ? min( array_column( $packages, 'package_price' ) ) : null,
        ];
    }
    return $services;
}

function nsp_catalog_categories( array $services ): array {
    $ids = [];
    foreach ( $services as $service ) $ids = array_merge( $ids, $service['categories'] );
    if ( ! $ids ) return [];
    $terms = get_terms( [ 'taxonomy'=>'service_category', 'include'=>array_unique( $ids ), 'hide_empty'=>false ] );
    if ( is_wp_error( $terms ) ) return [];
    $order = [ 'Cleaning'=>0, 'Pest Control'=>1, 'AC Services'=>2, 'Commercial'=>3, 'Relocation'=>4, 'Maintenance'=>5 ];
    usort( $terms, function ( $a, $b ) use ( $order ) {
        return ( $order[ html_entity_decode( $a->name, ENT_QUOTES, 'UTF-8' ) ] ?? 3 ) <=> ( $order[ html_entity_decode( $b->name, ENT_QUOTES, 'UTF-8' ) ] ?? 3 );
    } );
    return $terms;
}

function nsp_catalog_category_label( string $name ): string {
    $name = html_entity_decode( $name, ENT_QUOTES, 'UTF-8' );
    $arabic = [ 'Cleaning'=>'التنظيف', 'Pest Control'=>'مكافحة الآفات', 'AC Services'=>'خدمات المكيفات', 'Commercial'=>'التجاري', 'Relocation'=>'النقل', 'Maintenance'=>'الصيانة' ];
    return nsp_t( $name, $arabic[$name] ?? $name );
}

function nsp_catalog_price( $price ): string {
    return null === $price ? nsp_t( 'Price on request', 'السعر عند الطلب' ) : number_format_i18n( (float) $price, (float) $price == floor( (float) $price ) ? 0 : 2 ) . ' ' . nsp_t( 'SAR', 'ر.س' );
}
