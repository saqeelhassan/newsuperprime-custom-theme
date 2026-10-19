<?php
if (PHP_SAPI !== 'cli') exit;
require dirname(__DIR__, 4) . '/wp-load.php';
$id = wp_insert_post(['post_type'=>'service', 'post_status'=>'draft', 'post_title'=>'AC Cleaning & Repair']);
if (!$id || is_wp_error($id)) throw new RuntimeException('Fixture creation failed');
try {
    update_post_meta($id, '_nsp_booking_packages', [['package_name'=>'Preserved', 'package_price'=>321]]);
    $before = wp_count_terms(['taxonomy'=>'service_category', 'hide_empty'=>false]);
    delete_option('nsp_service_categories_version');
    nsp_migrate_service_categories();
    $names = wp_get_object_terms($id, 'service_category', ['fields'=>'names']);
    if (!in_array('AC Services', $names, true)) throw new RuntimeException('Legacy service category missing');
    if (321 !== get_post_meta($id, '_nsp_booking_packages', true)[0]['package_price']) throw new RuntimeException('Price changed');
    $version = get_option('nsp_service_categories_version');
    nsp_migrate_service_categories();
    if (!$version || $version !== get_option('nsp_service_categories_version')) throw new RuntimeException('Version missing');
    if ($before !== wp_count_terms(['taxonomy'=>'service_category', 'hide_empty'=>false])) throw new RuntimeException('Duplicate terms');
    echo "PASS: legacy service assignment, unchanged pricing, completion marker and repeat-safe terms.", PHP_EOL;
} finally {
    wp_delete_post($id, true);
}
