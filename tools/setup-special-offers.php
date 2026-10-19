<?php
/** Explicit setup: php tools/setup-special-offers.php. No writes on page visits. */
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
$posts = get_posts( [ 'post_type'=>'service', 'post_status'=>'publish', 'numberposts'=>-1 ] );
foreach ( nsp_special_offer_definitions() as $offer ) {
    $post_id = 0;
    foreach ( $posts as $post ) if ( html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' ) === $offer['service'] ) $post_id = $post->ID;
    if ( ! $post_id ) throw new RuntimeException( 'Missing service: ' . $offer['service'] );
    $packages = array_values( nsp_booking_packages( $post_id ) );
    $row = [ 'package_name'=>$offer['name'], 'package_price'=>$offer['price'], 'package_description'=>$offer['description'], 'package_perk'=>$offer['perk'] ];
    $found = false;
    foreach ( $packages as &$package ) {
        if ( $package['package_name'] === $offer['name'] ) { $package = $row; $found = true; break; }
    }
    unset( $package );
    if ( ! $found ) $packages[] = $row;
    update_post_meta( $post_id, '_nsp_booking_packages', $packages );
    echo $offer['service'], ' / ', $offer['name'], ': SAR ', $offer['price'], PHP_EOL;
}
