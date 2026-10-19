<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_special_offer_definitions(): array {
    return [
        [ 'service'=>'Pest Control', 'name'=>'Complete Flat', 'name_ar'=>'الشقة بالكامل', 'price'=>199, 'perk'=>'FREE Pest Inspection', 'perk_ar'=>'فحص مجاني للآفات', 'description'=>'Complete flat pest control. 30-Day Warranty (1 Revisit).', 'warranty'=>true, 'image'=>'Pest-Control-Service.jpg' ],
        [ 'service'=>'Sofa Cleaning', 'name'=>'5 Seater Sofa', 'name_ar'=>'كنبة ٥ مقاعد', 'price'=>149, 'perk'=>'FREE: Up to 2 Small Cushions', 'perk_ar'=>'مجاناً: حتى وسادتين صغيرتين', 'description'=>'Deep cleaning for a 5-seater sofa. No advance payment. Pay after work.', 'warranty'=>false, 'image'=>'Carpet-Cleaning.jpg' ],
        [ 'service'=>'Sofa Cleaning', 'name'=>'7 Seater Sofa', 'name_ar'=>'كنبة ٧ مقاعد', 'price'=>199, 'perk'=>'FREE: Up to 4 Small Cushions', 'perk_ar'=>'مجاناً: حتى ٤ وسائد صغيرة', 'description'=>'Deep cleaning for a 7-seater sofa. No advance payment. Pay after work.', 'warranty'=>false, 'image'=>'Home-Cleaning-Service.jpg' ],
        [ 'service'=>'Bed Bug Treatment', 'name'=>'Complete Flat', 'name_ar'=>'الشقة بالكامل', 'price'=>199, 'perk'=>'FREE Bed Bug Preparation Guide', 'perk_ar'=>'دليل تحضير مجاني لمكافحة بق الفراش', 'description'=>'Complete flat bed bug treatment. 30-Day Warranty (1 Revisit).', 'warranty'=>true, 'image'=>'Pest-Control-Service-page.jpg' ],
    ];
}

/** Read real booking package data so the advert and booking price agree. */
function nsp_special_offer_items(): array {
    static $items;
    if ( isset( $items ) ) return $items;
    $items = [];
    $posts = get_posts( [ 'post_type'=>'service', 'post_status'=>'publish', 'numberposts'=>-1 ] );
    foreach ( nsp_special_offer_definitions() as $offer ) {
        foreach ( $posts as $post ) {
            if ( html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' ) !== $offer['service'] ) continue;
            foreach ( array_values( nsp_booking_packages( $post->ID ) ) as $index=>$package ) {
                if ( ( $package['package_name'] ?? '' ) !== $offer['name'] || ! isset( $package['package_price'] ) || ! is_numeric( $package['package_price'] ) || (float) $package['package_price'] < 0 || ! is_finite( (float) $package['package_price'] ) ) continue;
                $items[] = array_merge( $offer, [ 'id'=>$post->ID, 'index'=>$index, 'package'=>$package,
                    'image_url'=>get_the_post_thumbnail_url( $post->ID, 'large' ) ?: nsp_service_image_url( $offer['image'] ) ] );
                break;
            }
            break;
        }
    }
    return $items;
}

add_action( 'wp_enqueue_scripts', function () {
    if ( ! nsp_special_offer_items() ) return;
    wp_enqueue_style( 'nsp-special-offers', NSP_THEME_URI . '/assets/css/special-offers.css', [], filemtime( NSP_THEME_DIR . '/assets/css/special-offers.css' ) );
    wp_enqueue_script( 'nsp-special-offers', NSP_THEME_URI . '/assets/js/special-offers.js', [ 'jquery', 'nsp-service-preview' ], filemtime( NSP_THEME_DIR . '/assets/js/special-offers.js' ), nsp_script_args() );
}, 20 );
add_action( 'wp_footer', function () {
    if ( nsp_special_offer_items() ) get_template_part( 'template-parts/booking/special-offers', null, [ 'offers'=>nsp_special_offer_items() ] );
}, 11 );
