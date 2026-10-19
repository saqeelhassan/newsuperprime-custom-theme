<?php
/** Local-only integration test; fixture services/categories are removed afterwards. */
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
if ( ! in_array( wp_parse_url( home_url(), PHP_URL_HOST ), [ 'localhost', '127.0.0.1' ], true ) ) throw new RuntimeException( 'Run this test on a local site.' );
function seed_check( $condition, $message ) { if ( ! $condition ) throw new RuntimeException( $message ); }
$prefix = 'NSP Seed Test ' . wp_generate_password( 8, false );
$ids = [];
$term_id = 0;
try {
    $term = wp_insert_term( $prefix, 'service_category' );
    seed_check( ! is_wp_error( $term ), 'Fixture category failed' );
    $term_id = (int)$term['term_id'];
    $legacy = wp_insert_post( [ 'post_type'=>'service', 'post_status'=>'draft', 'post_title'=>$prefix . ' Old', 'post_name'=>sanitize_title( $prefix . '-original-url' ), 'post_content'=>'Server-owned content' ] );
    $ids[] = $legacy;
    $original_slug = get_post_field( 'post_name', $legacy );
    update_post_meta( $legacy, '_nsp_service_short_desc', 'Server-owned summary' );
    update_post_meta( $legacy, '_nsp_booking_packages', [ [ 'package_name'=>'Server package', 'package_price'=>777 ] ] );
    wp_set_object_terms( $legacy, [ $term_id ], 'service_category' );
    $quote = wp_insert_post( [ 'post_type'=>'service', 'post_status'=>'publish', 'post_title'=>$prefix . ' Quote' ] );
    $ids[] = $quote;
    update_post_meta( $quote, '_nsp_booking_packages', [] );
    update_post_meta( $quote, '_nsp_price_basis', 'quote' );
    $missing_prices = wp_insert_post( [ 'post_type'=>'service', 'post_status'=>'publish', 'post_title'=>$prefix . ' Missing Prices', 'post_content'=>'Keep this text' ] );
    $ids[] = $missing_prices;
    $entries = [];
    foreach ( [ 'New', 'Current', 'Quote', 'Missing Prices' ] as $order=>$suffix ) {
        $entries[] = [ 'key'=>sanitize_title( $prefix . $suffix ), 'title'=>$prefix . ' ' . $suffix,
            'slug'=>sanitize_title( $prefix . $suffix ), 'aliases'=>'Current' === $suffix ? [ $prefix . ' Old' ] : [],
            'content'=>'Local content', 'excerpt'=>'Local excerpt', 'order'=>$order,
            'meta'=>[ '_nsp_service_short_desc'=>'Local summary', '_nsp_booking_packages'=>[ [ 'package_name'=>'Local package', 'package_price'=>149 ] ], '_nsp_price_basis'=>'' ],
            'categories'=>[ [ 'name'=>'Cleaning', 'slug'=>'cleaning' ] ] ];
    }
    $result = nsp_apply_service_catalog_seed( $entries );
    $ids = array_unique( array_merge( $ids, $result ) );
    seed_check( count( $result ) === 4 && count( $ids ) === 4, 'Legacy service was duplicated' );
    seed_check( 'publish' === get_post_status( $result[0] ), 'Missing service not published' );
    seed_check( 'Local content' === get_post_field( 'post_content', $result[0] ), 'New service content missing' );
    seed_check( 149 === get_post_meta( $result[0], '_nsp_booking_packages', true )[0]['package_price'], 'New prices missing' );
    seed_check( $result[1] === $legacy && 'publish' === get_post_status( $legacy ), 'Legacy draft not restored' );
    seed_check( $prefix . ' Current' === get_the_title( $legacy ), 'Legacy title not updated' );
    seed_check( $original_slug === get_post_field( 'post_name', $legacy ), 'Existing URL changed' );
    seed_check( 'Server-owned content' === get_post_field( 'post_content', $legacy ), 'Existing content overwritten' );
    seed_check( 'Server-owned summary' === get_post_meta( $legacy, '_nsp_service_short_desc', true ), 'Existing summary overwritten' );
    seed_check( 777 === get_post_meta( $legacy, '_nsp_booking_packages', true )[0]['package_price'], 'Server price overwritten' );
    seed_check( in_array( $term_id, wp_get_object_terms( $legacy, 'service_category', [ 'fields'=>'ids' ] ), true ), 'Manual category lost' );
    seed_check( [] === get_post_meta( $quote, '_nsp_booking_packages', true ) && 'quote' === get_post_meta( $quote, '_nsp_price_basis', true ), 'Intentional quote pricing overwritten' );
    seed_check( 149 === get_post_meta( $missing_prices, '_nsp_booking_packages', true )[0]['package_price'], 'Missing server packages not filled' );
    seed_check( 'Keep this text' === get_post_field( 'post_content', $missing_prices ), 'Existing body changed' );
    wp_update_post( [ 'ID'=>$result[0], 'post_title'=>$prefix . ' Manual title', 'post_status'=>'draft' ] );
    $again = nsp_apply_service_catalog_seed( $entries );
    seed_check( $result === $again, 'Repeat import created duplicate posts' );
    seed_check( 'draft' === get_post_status( $result[0] ) && $prefix . ' Manual title' === get_the_title( $result[0] ), 'Later server edits were overwritten' );
    $count = wp_count_posts( 'service' )->publish;
    nsp_migrate_service_catalog();
    seed_check( get_option( 'nsp_service_catalog_seed_version' ) === NSP_SERVICE_CATALOG_SEED_VERSION, 'Completion marker missing' );
    seed_check( $count === wp_count_posts( 'service' )->publish, 'Completed migration ran again' );
    seed_check( count( nsp_deployment_service_seed() ) === 25, 'Local snapshot should contain all 25 published services' );
    seed_check( false === strpos( file_get_contents( NSP_THEME_DIR . '/inc/service-catalog-seed.php' ), 'localhost' ), 'Environment URL leaked into snapshot' );
    echo "PASS: missing services/packages, legacy names/drafts, unchanged URLs/content/server prices/quote mode/categories, repeat safety, later edits and deployment version.\n";
} finally {
    foreach ( $ids as $id ) wp_delete_post( $id, true );
    if ( $term_id ) wp_delete_term( $term_id, 'service_category' );
}
