<?php
/** Seed missing public services from the exported local catalog after deployment. */
if ( ! defined( 'ABSPATH' ) ) exit;
require_once __DIR__ . '/service-catalog-seed.php';

function nsp_seed_service_name( string $name ): string {
    return strtolower( trim( html_entity_decode( $name, ENT_QUOTES, 'UTF-8' ) ) );
}

/** Also callable by the local integration test with an isolated fixture catalog. */
function nsp_apply_service_catalog_seed( array $entries ): array {
    $existing = get_posts( [ 'post_type'=>'service', 'post_status'=>[ 'publish', 'draft' ], 'numberposts'=>-1, 'orderby'=>'ID', 'order'=>'ASC' ] );
    $names = $slugs = $keys = [];
    foreach ( $existing as $post ) {
        $name = nsp_seed_service_name( $post->post_title );
        if ( ! isset( $names[$name] ) || 'publish' === $post->post_status ) $names[$name] = $post;
        $slugs[$post->post_name] = $post;
        $key = get_post_meta( $post->ID, '_nsp_catalog_seed_key', true );
        if ( $key ) $keys[$key] = $post;
    }
    $ids = [];
    foreach ( $entries as $entry ) {
        if ( empty( $entry['key'] ) || empty( $entry['title'] ) || empty( $entry['slug'] ) ) throw new RuntimeException( 'Invalid deployment service entry.' );
        $post = $keys[$entry['key']] ?? $names[nsp_seed_service_name( $entry['title'] )] ?? $slugs[$entry['slug']] ?? null;
        if ( ! $post ) foreach ( $entry['aliases'] as $alias ) {
            if ( isset( $names[nsp_seed_service_name( $alias )] ) ) { $post = $names[nsp_seed_service_name( $alias )]; break; }
        }
        $created = ! $post;
        $already_seeded = $post && metadata_exists( 'post', $post->ID, '_nsp_catalog_seed_key' );
        $expand = static function ( $value ) {
            return str_replace( [ '{{theme_url}}', '{{site_url}}' ], [ NSP_THEME_URI, home_url() ], $value );
        };
        if ( $created ) {
            $id = wp_insert_post( wp_slash( [
                'post_type'=>'service', 'post_status'=>'publish', 'post_title'=>$entry['title'],
                'post_name'=>$entry['slug'], 'post_content'=>wp_kses_post( $expand( $entry['content'] ) ),
                'post_excerpt'=>$expand( $entry['excerpt'] ), 'menu_order'=>(int)$entry['order'],
            ] ), true );
        } else {
            $id = $post->ID;
            $changes = [ 'ID'=>$id ];
            // Recognized old service names can be restored without changing their URLs.
            if ( ! $already_seeded && in_array( nsp_seed_service_name( $post->post_title ), array_map( 'nsp_seed_service_name', $entry['aliases'] ), true ) ) $changes['post_title'] = $entry['title'];
            if ( ! $already_seeded && 'draft' === $post->post_status ) $changes['post_status'] = 'publish';
            if ( ! $already_seeded ) $changes['menu_order'] = (int)$entry['order'];
            if ( count( $changes ) > 1 ) {
                $result = wp_update_post( wp_slash( $changes ), true );
                if ( is_wp_error( $result ) ) throw new RuntimeException( $result->get_error_message() );
            }
        }
        if ( is_wp_error( $id ) || ! $id ) throw new RuntimeException( is_wp_error( $id ) ? $id->get_error_message() : 'Service creation failed.' );
        // An explicitly saved empty package list is intentional quote-only pricing.
        $has_prices = metadata_exists( 'post', $id, '_nsp_booking_packages' ) || (bool)nsp_booking_packages( $id );
        foreach ( $entry['meta'] as $key=>$value ) {
            if ( ! in_array( $key, [ '_nsp_service_short_desc', '_nsp_service_features', '_nsp_price_basis', '_nsp_booking_packages' ], true ) ) continue;
            if ( metadata_exists( 'post', $id, $key ) ) continue;
            if ( $has_prices && in_array( $key, [ '_nsp_booking_packages', '_nsp_price_basis' ], true ) ) continue;
            if ( is_string( $value ) ) $value = $expand( $value );
            if ( false === update_post_meta( $id, $key, wp_slash( $value ) ) && ! metadata_exists( 'post', $id, $key ) ) throw new RuntimeException( 'Could not save deployed service metadata.' );
        }
        foreach ( $entry['categories'] as $category ) {
            $term = term_exists( $category['name'], 'service_category' );
            if ( ! $term ) $term = wp_insert_term( $category['name'], 'service_category', [ 'slug'=>$category['slug'] ] );
            if ( is_wp_error( $term ) ) throw new RuntimeException( $term->get_error_message() );
            $term_id = (int)( is_array( $term ) ? $term['term_id'] : $term );
            $result = wp_set_object_terms( $id, [ $term_id ], 'service_category', true );
            if ( is_wp_error( $result ) ) throw new RuntimeException( $result->get_error_message() );
        }
        if ( false === update_post_meta( $id, '_nsp_catalog_seed_key', $entry['key'] ) && ! metadata_exists( 'post', $id, '_nsp_catalog_seed_key' ) ) throw new RuntimeException( 'Could not save deployed service identity.' );
        $keys[$entry['key']] = get_post( $id );
        $ids[] = (int)$id;
    }
    return $ids;
}

function nsp_migrate_service_catalog(): void {
    if ( ! post_type_exists( 'service' ) || ! taxonomy_exists( 'service_category' ) || get_option( 'nsp_service_catalog_seed_version' ) === NSP_SERVICE_CATALOG_SEED_VERSION ) return;
    $lock = 'nsp_service_catalog_seed_lock';
    $locked_at = (int)get_option( $lock );
    if ( $locked_at && $locked_at < time() - 300 ) delete_option( $lock );
    if ( ! add_option( $lock, time(), '', false ) ) return;
    try {
        $ids = nsp_apply_service_catalog_seed( nsp_deployment_service_seed() );
        update_option( 'nsp_service_catalog_seed_version', NSP_SERVICE_CATALOG_SEED_VERSION, true );
        update_option( 'nsp_service_catalog_seed_count', count( $ids ), false );
        delete_transient( 'nsp_footer_services' );
    } catch ( Throwable $error ) {
        // Do not mark incomplete imports as finished; retry safely on another request.
        error_log( 'NSP service catalog deployment: ' . $error->getMessage() );
    } finally {
        delete_option( $lock );
    }
}
add_action( 'init', 'nsp_migrate_service_catalog', 35 );
