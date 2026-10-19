<?php
/** Apply the approved price list: php tools/update-service-pricing.php */
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
$posts = get_posts( [ 'post_type'=>'service', 'post_status'=>'any', 'numberposts'=>-1, 'orderby'=>'ID', 'order'=>'ASC' ] );
$existing = [];
foreach ( $posts as $post ) {
    $title = html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' );
    if ( ! isset( $existing[$title] ) ) $existing[$title] = $post->ID;
}
$fixed = ['Sofa Cleaning', 'Pest Control', 'Cockroach Treatment', 'Bed Bug Treatment'];
$size = ['Carpet & Rug Cleaning', 'Majlis Cleaning'];
$quote = ['AC Services', 'Office Cleaning', 'Car Detailing', 'Home Shifting', 'Water Tank Cleaning'];
$groups = ['cleaning'=>'Cleaning', 'pest'=>'Pest Control', 'commercial'=>'Commercial', 'maintenance'=>'Maintenance', 'vehicle'=>'Maintenance', 'ac'=>'AC Services', 'relocation'=>'Relocation'];
foreach ( nsp_service_directory() as $order=>$entry ) {
    $title = $entry['title'];
    $id = $existing[$title] ?? ( $existing[$entry['previous_title'] ?? ''] ?? 0 );
    if ( ! $id ) {
        $id = wp_insert_post( ['post_type'=>'service', 'post_status'=>'publish', 'post_title'=>$title, 'post_content'=>$entry['desc'], 'menu_order'=>$order], true );
        if ( is_wp_error($id) ) throw new RuntimeException($id->get_error_message());
    } else {
        wp_update_post(['ID'=>$id, 'post_title'=>$title, 'post_status'=>'publish', 'menu_order'=>$order]);
    }
    update_post_meta($id, '_nsp_service_short_desc', $entry['desc']);
    $term = term_exists($groups[$entry['group']], 'service_category');
    if (!$term) $term = wp_insert_term($groups[$entry['group']], 'service_category');
    if (is_wp_error($term)) throw new RuntimeException($term->get_error_message());
    wp_set_object_terms($id, [(int)(is_array($term) ? $term['term_id'] : $term)], 'service_category');
    $basis = '';
    if (in_array($title, $fixed, true)) {
        // Preserve the separately advertised offer packages, replace dummy tiers.
        $offers = array_values(array_filter(nsp_booking_packages($id), function($row) {
            return in_array($row['package_name'] ?? '', ['Complete Flat', '5 Seater Sofa', '7 Seater Sofa'], true);
        }));
        $rows = array_merge([['package_name'=>'Standard Service', 'package_price'=>149, 'package_description'=>$entry['desc'], 'package_perk'=>'']], $offers);
    } elseif (in_array($title, $size, true) || in_array($title, $quote, true)) {
        $basis = in_array($title, $size, true) ? 'size' : 'quote';
        $rows = [];
    } elseif ('Hourly Home Deep Cleaning' === $title) {
        $basis = 'hourly';
        $rows = [];
        foreach ([3,4,5,6] as $hours) $rows[] = ['package_name'=>"$hours hours", 'package_price'=>$hours*45, 'package_description'=>'45 SAR per hour. Minimum booking: 3 hours.', 'package_perk'=>''];
    } else continue;
    update_post_meta($id, '_nsp_price_basis', $basis);
    update_post_meta($id, '_nsp_booking_packages', $rows);
    echo "$title: ", $basis ?: '149 SAR', PHP_EOL;
}
delete_transient('nsp_footer_services');
