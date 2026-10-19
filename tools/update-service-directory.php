<?php
/** Run locally: php tools/update-service-directory.php. Safe to re-run. */
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
$existing = get_posts( [ 'post_type'=>'service', 'post_status'=>'any', 'numberposts'=>-1, 'orderby'=>'ID', 'order'=>'ASC' ] );
$by_title = [];
foreach ( $existing as $post ) {
    $key = html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' );
    if ( ! isset( $by_title[$key] ) ) $by_title[$key] = $post->ID;
}
$groups = [];
foreach ( [ 'cleaning'=>'Cleaning', 'pest'=>'Pest Control', 'commercial'=>'Commercial', 'maintenance'=>'Maintenance', 'vehicle'=>'Maintenance', 'ac'=>'AC Services', 'relocation'=>'Relocation' ] as $key=>$name ) {
    $term = term_exists( $name, 'service_category' );
    if ( ! $term ) $term = wp_insert_term( $name, 'service_category' );
    if ( is_wp_error( $term ) ) throw new RuntimeException( $term->get_error_message() );
    $groups[ $key ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
}
$ids = [];
foreach ( nsp_service_directory() as $order=>$entry ) {
    $id = $by_title[ $entry['title'] ] ?? ( $by_title[ $entry['previous_title'] ?? '' ] ?? 0 );
    $data = [ 'post_type'=>'service', 'post_title'=>$entry['title'], 'post_status'=>'publish', 'menu_order'=>$order ];
    if ( $id ) $data['ID'] = $id;
    else $data['post_content'] = '<p>' . esc_html( $entry['desc'] ) . '</p>';
    $id = wp_insert_post( $data, true );
    if ( is_wp_error( $id ) ) throw new RuntimeException( $id->get_error_message() );
    update_post_meta( $id, '_nsp_service_short_desc', $entry['desc'] );
    wp_set_object_terms( $id, [ $groups[ $entry['group'] ] ], 'service_category' );
    // Continue the existing demo-package setup without replacing saved packages.
    if ( ! metadata_exists( 'post', $id, '_nsp_booking_packages' ) && ! nsp_booking_packages( $id ) ) {
        $names = 'pest' === $entry['group'] ? [ 'Single Area Treatment', 'Apartment Treatment', 'Whole Property Treatment' ] : [ 'Essential Clean', 'Deep Clean', 'Complete Clean' ];
        $packages = [];
        foreach ( [149,249,399] as $index=>$price ) {
            $packages[] = [ 'package_name'=>$names[$index], 'package_price'=>$price,
                'package_description'=>$entry['desc'],
                'package_perk'=>'Service scope confirmed with our team' ];
        }
        update_post_meta( $id, '_nsp_booking_packages', $packages );
    }
    $ids[] = [ 'id'=>$id, 'title'=>$entry['title'] ];
    echo $id, ' ', $entry['title'], PHP_EOL;
}
foreach ( [ 'AC Cleaning & Repair', 'Car Washing', 'Home Shifting Service' ] as $retired ) {
    if ( isset( $by_title[$retired] ) ) wp_update_post( [ 'ID'=>$by_title[$retired], 'post_status'=>'draft' ] );
}
// Individual services are listed on the Services page, not in navigation.
delete_transient( 'nsp_footer_services' );
echo 'Updated ', count($ids), ' services. Existing packages preserved.', PHP_EOL;
