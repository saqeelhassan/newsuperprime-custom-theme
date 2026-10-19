<?php
/** Local integration check. Creates a temporary draft and removes it afterwards. */
require dirname( __DIR__, 4 ) . '/wp-load.php';
$admins = get_users( [ 'role' => 'administrator', 'number' => 1 ] );
if ( ! $admins ) throw new RuntimeException( 'An administrator is required for this local check.' );
wp_set_current_user( $admins[0]->ID );
$post_id = wp_insert_post( [ 'post_type' => 'service', 'post_title' => 'Temporary booking editor check', 'post_status' => 'draft' ], true );
if ( is_wp_error( $post_id ) ) throw new RuntimeException( $post_id->get_error_message() );
function booking_check( $condition, $message ) {
    if ( ! $condition ) throw new RuntimeException( $message );
}
try {
    $_POST = [
        'nsp_booking_packages_nonce' => wp_create_nonce( 'nsp_booking_packages_save' ),
        'nsp_booking_packages' => [ [ 'package_name' => '<b>Deep clean</b>', 'package_price' => '499.99', 'package_description' => 'Kitchen & living room', 'package_perk' => 'Supplies included' ] ],
    ];
    nsp_save_booking_packages( $post_id );
    $saved = nsp_booking_packages( $post_id );
    booking_check( count( $saved ) === 1 && $saved[0]['package_name'] === 'Deep clean' && $saved[0]['package_price'] === 499.99, 'Valid packages should be saved and sanitized.' );
    ob_start(); nsp_booking_button( $post_id ); $button = ob_get_clean();
    preg_match( '/data-packages="([^"]*)"/', $button, $matches );
    $payload = json_decode( html_entity_decode( $matches[1], ENT_QUOTES, 'UTF-8' ), true );
    booking_check( $payload === $saved, 'The frontend trigger must use packages saved in admin.' );
    $_POST['nsp_booking_packages'][0]['package_price'] = '-1';
    nsp_save_booking_packages( $post_id );
    booking_check( nsp_booking_packages( $post_id ) === $saved, 'Invalid prices must preserve saved packages.' );
    $_POST['nsp_booking_packages'][0]['package_price'] = [ 'malformed' ];
    nsp_save_booking_packages( $post_id );
    booking_check( nsp_booking_packages( $post_id ) === $saved, 'Malformed values must be rejected.' );
    $_POST['nsp_booking_packages'] = [];
    $_POST['nsp_booking_packages_nonce'] = 'invalid';
    nsp_save_booking_packages( $post_id );
    booking_check( nsp_booking_packages( $post_id ) === $saved, 'Invalid nonces must not save.' );
    $_POST['nsp_booking_packages_nonce'] = wp_create_nonce( 'nsp_booking_packages_save' );
    wp_set_current_user( 0 );
    nsp_save_booking_packages( $post_id );
    booking_check( nsp_booking_packages( $post_id ) === $saved, 'Unauthenticated users must not save.' );
    wp_set_current_user( $admins[0]->ID );
    $_POST['nsp_booking_packages_nonce'] = wp_create_nonce( 'nsp_booking_packages_save' );
    nsp_save_booking_packages( $post_id );
    booking_check( nsp_booking_packages( $post_id ) === [] && metadata_exists( 'post', $post_id, '_nsp_booking_packages' ), 'Removing all rows must save an empty override.' );
    if ( in_array( '--markup', $argv ?? [], true ) ) {
        update_post_meta( $post_id, '_nsp_booking_packages', $saved );
        nsp_booking_packages_editor( get_post( $post_id ) );
    } else {
        echo "PASS: admin save, sanitization, frontend payload, invalid price/shape, nonce, permissions, and empty packages.\n";
    }
} finally {
    $_POST = [];
    delete_transient( 'nsp_packages_error_' . $admins[0]->ID );
    wp_delete_post( $post_id, true );
}
