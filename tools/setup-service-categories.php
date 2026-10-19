<?php
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
$groups = [];
foreach ( [ 'cleaning'=>'Cleaning', 'pest'=>'Pest Control', 'commercial'=>'Commercial', 'maintenance'=>'Maintenance', 'vehicle'=>'Maintenance', 'ac'=>'AC Services', 'relocation'=>'Relocation' ] as $key=>$name ) {
    $term = term_exists( $name, 'service_category' );
    if ( ! $term ) $term = wp_insert_term( $name, 'service_category' );
    if ( is_wp_error( $term ) ) throw new RuntimeException( $term->get_error_message() );
    $groups[$key] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
}
$posts = get_posts( [ 'post_type'=>'service', 'post_status'=>'publish', 'numberposts'=>-1 ] );
foreach ( nsp_service_directory() as $entry ) {
    foreach ( $posts as $post ) {
        if ( html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' ) !== $entry['title'] ) continue;
        $result = wp_set_object_terms( $post->ID, [ $groups[$entry['group']] ], 'service_category' );
        if ( is_wp_error( $result ) ) throw new RuntimeException( $result->get_error_message() );
        echo $entry['title'], ' -> ', get_term( $groups[$entry['group']] )->name, PHP_EOL;
    }
}
