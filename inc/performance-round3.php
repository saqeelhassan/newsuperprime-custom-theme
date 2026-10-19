<?php
if (!defined('ABSPATH')) exit;

add_action('wp_head', function () {
    if (!nsp_is_arabic()) {
        foreach (['dm-sans-normal-latin.woff2','poppins-700-normal-latin.woff2'] as $font) {
            echo '<link rel="preload" as="font" type="font/woff2" crossorigin href="' . esc_url(NSP_THEME_URI . '/assets/fonts/' . $font) . '">' . "\n";
        }
    }
    if (is_front_page() || nsp_is_service_catalog()) {
        $services = nsp_catalog_services();
        if ($services) echo '<link rel="preload" as="image" fetchpriority="high" href="' . esc_url($services[0]['image']) . '">' . "\n";
    }
}, 2);

function nsp_critical_css_path(): string {
    $view = is_front_page() ? 'home' : (nsp_is_service_catalog() ? 'catalog' : 'inner');
    return NSP_THEME_DIR . '/assets/css/critical-' . $view . '-' . (nsp_is_arabic() ? 'ar' : 'en') . '.css';
}

add_action('wp_head', function () {
    if (!class_exists('WP_HTML_Tag_Processor')) return;
    $file = nsp_critical_css_path();
    if (is_file($file)) {
        // Small cacheable first-screen stylesheet keeps the HTML and inline budget small.
        $url = NSP_THEME_URI . '/assets/css/' . basename( $file ) . '?ver=' . filemtime( $file );
        echo '<link rel="stylesheet" id="nsp-critical-styles" href="' . esc_url( $url ) . '">' . "\n";
        echo '<style id="nsp-critical-css">' . file_get_contents( NSP_THEME_DIR . '/assets/css/accessibility.css' ) . '</style>' . "\n";
        // Layout-measuring plugins must initialize after deferred styles apply.
        echo '<script>window.nspStylesReady=new Promise(function(resolve){function check(){var links=Array.from(document.querySelectorAll("link[data-nsp-deferred]" )).filter(function(link){return link.media==="print";});if(!links.length)return resolve();var remaining=links.length;function done(){if(--remaining===0)resolve();}links.forEach(function(link){link.addEventListener("load",done,{once:true});link.addEventListener("error",done,{once:true});});}if(document.readyState==="loading")document.addEventListener("DOMContentLoaded",check,{once:true});else check();});</script>' . "\n";
    }
}, 7);

add_filter('style_loader_tag', function ($html, $handle) {
    if (is_admin() || 'nsp-fonts' === $handle || 0 !== strpos($handle, 'nsp-') || !class_exists('WP_HTML_Tag_Processor') || !is_file(nsp_critical_css_path())) return $html;
    $tag = new WP_HTML_Tag_Processor($html);
    if (!$tag->next_tag('LINK')) return $html;
    $tag->set_attribute('media', 'print');
    $tag->set_attribute('data-nsp-deferred', '');
    $tag->set_attribute('onload', "this.media='all';this.onload=null;");
    return $tag->get_updated_html() . '<noscript>' . $html . '</noscript>';
}, 10, 2);
