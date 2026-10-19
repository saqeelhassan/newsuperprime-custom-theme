<?php
/** Align the requested service names without replacing prices or packages. */
if ( PHP_SAPI !== 'cli' ) exit;
require dirname( __DIR__, 4 ) . '/wp-load.php';
$renames = ['Sofa Deep Cleaning'=>'Sofa Cleaning', 'Office & Commercial Cleaning'=>'Office Cleaning'];
$services = get_posts(['post_type'=>'service', 'post_status'=>'publish', 'numberposts'=>-1]);
foreach ($services as $service) {
    $title = html_entity_decode($service->post_title, ENT_QUOTES, 'UTF-8');
    if (isset($renames[$title])) {
        $result = wp_update_post(['ID'=>$service->ID, 'post_title'=>$renames[$title]], true);
        if (is_wp_error($result)) throw new RuntimeException($result->get_error_message());
        echo $title, ' -> ', $renames[$title], PHP_EOL;
    }
}
$required = ['Sofa Cleaning','Pest Control','Cockroach Treatment','Bed Bug Treatment','AC Services','Office Cleaning','Car Detailing','Home Shifting','Water Tank Cleaning'];
$titles = array_map(function($post) { return html_entity_decode($post->post_title, ENT_QUOTES, 'UTF-8'); }, get_posts(['post_type'=>'service','post_status'=>'publish','numberposts'=>-1]));
$missing = array_diff($required, $titles);
if ($missing) throw new RuntimeException('Missing services: ' . implode(', ', $missing));
delete_transient('nsp_footer_services');
echo 'Verified all nine requested services. Existing categories and packages preserved.', PHP_EOL;
