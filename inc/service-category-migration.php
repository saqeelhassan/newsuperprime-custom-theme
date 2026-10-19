<?php
/** Repeat-safe category setup after deployment and taxonomy registration. */
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_migrate_service_categories(): void {
    if ( ! taxonomy_exists('service_category') || ! post_type_exists('service') ) return;
    $groups = ['cleaning'=>'Cleaning', 'pest'=>'Pest Control', 'ac'=>'AC Services', 'commercial'=>'Commercial', 'relocation'=>'Relocation', 'maintenance'=>'Maintenance', 'vehicle'=>'Maintenance'];
    $directory = nsp_service_directory();
    $version = '1-' . md5(wp_json_encode([$groups, $directory]));
    if (get_option('nsp_service_categories_version') === $version) return;
    $lock = 'nsp_service_categories_lock';
    $locked_at = (int)get_option($lock);
    if ($locked_at && $locked_at < time() - 300) delete_option($lock);
    if (!add_option($lock, time(), '', false)) return;
    try {
        $terms = [];
        foreach (array_unique($groups) as $name) {
            $term = term_exists($name, 'service_category');
            if (!$term) $term = wp_insert_term($name, 'service_category', ['slug'=>sanitize_title($name)]);
            if (is_wp_error($term)) throw new RuntimeException($term->get_error_message());
            $terms[$name] = (int)(is_array($term) ? $term['term_id'] : $term);
        }
        $mapping = [];
        foreach ($directory as $entry) {
            $id = $terms[$groups[$entry['group']]];
            $mapping[strtolower($entry['title'])] = $id;
            if (!empty($entry['previous_title'])) $mapping[strtolower($entry['previous_title'])] = $id;
        }
        $services = get_posts(['post_type'=>'service', 'post_status'=>['publish','draft','pending','private','future'], 'numberposts'=>-1]);
        foreach ($services as $service) {
            $title = strtolower(trim(html_entity_decode($service->post_title, ENT_QUOTES, 'UTF-8')));
            if (!isset($mapping[$title])) continue;
            // Preserve any manually assigned categories, content and prices.
            $result = wp_set_object_terms($service->ID, [$mapping[$title]], 'service_category', true);
            if (is_wp_error($result)) throw new RuntimeException($result->get_error_message());
        }
        update_option('nsp_service_categories_version', $version, false);
        delete_transient('nsp_footer_services');
    } catch (Throwable $error) {
        // Leave version unset so the next request can safely retry.
        error_log('NSP category migration: ' . $error->getMessage());
    } finally {
        delete_option($lock);
    }
}
add_action('init', 'nsp_migrate_service_categories', 30);
