<?php
/** Replace placeholder package wording while preserving prices and inclusions. */
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
$count = 0;
foreach (get_posts(['post_type'=>'service','post_status'=>'any','numberposts'=>-1]) as $service) {
    $rows = nsp_booking_packages($service->ID);
    $changed = false;
    foreach ($rows as &$row) {
        foreach (['package_description','package_perk'] as $field) {
            $original = $row[$field] ?? '';
            $updated = preg_replace('/^(?:Demo package and price\.\s*|Sample:\s*)/i', '', $original);
            if ($updated !== $original) {
                $row[$field] = $updated;
                $changed = true;
            }
        }
    }
    unset($row);
    if ($changed) {
        update_post_meta($service->ID, '_nsp_booking_packages', $rows);
        $count++;
    }
}
echo "Updated package descriptions for $count services. Prices preserved.", PHP_EOL;
