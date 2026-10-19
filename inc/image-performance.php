<?php
/** Add intrinsic dimensions and defer offscreen static theme images. */
if ( ! defined('ABSPATH') ) exit;

function nsp_static_image_dimensions( string $url ): array {
    static $cache = [];
    $path = rawurldecode((string)wp_parse_url($url, PHP_URL_PATH));
    if (isset($cache[$path])) return $cache[$path];
    $prefix = rtrim((string)wp_parse_url(NSP_THEME_URI, PHP_URL_PATH), '/') . '/assets/img/';
    if (0 !== strpos($path, $prefix)) return $cache[$path] = [];
    $root = realpath(NSP_THEME_DIR . '/assets/img');
    $file = realpath(NSP_THEME_DIR . '/assets/img/' . substr($path, strlen($prefix)));
    if (!$root || !$file || 0 !== strpos($file, $root . DIRECTORY_SEPARATOR) || !is_file($file)) return $cache[$path] = [];
    $size = @getimagesize($file);
    return $cache[$path] = $size ? [(int)$size[0], (int)$size[1]] : [];
}

function nsp_image_performance_markup( string $html ): string {
    if (!class_exists('WP_HTML_Tag_Processor') || false === stripos($html, '<html')) return $html;
    $processor = new WP_HTML_Tag_Processor($html);
    $stack = [];
    $first_content_image = !is_front_page();
    $void = ['AREA','BASE','BR','COL','EMBED','HR','IMG','INPUT','LINK','META','PARAM','SOURCE','TRACK','WBR'];
    while ($processor->next_tag(['tag_closers'=>'visit'])) {
        $tag = $processor->get_tag();
        if ($processor->is_tag_closer()) {
            while ($stack) {
                $entry = array_pop($stack);
                if ($entry[0] === $tag) break;
            }
            continue;
        }
        $parent_eager = $stack ? $stack[count($stack)-1][1] : false;
        $classes = (string)$processor->get_attribute('class');
        $eager = $parent_eager || 'clinox-header' === $processor->get_attribute('id') || (bool)preg_match('/\bnsp-(?:home-hero|catalog-hero)\b/', $classes);
        if ('IMG' === $tag) {
            $src = (string)$processor->get_attribute('src');
            $is_logo = (bool)preg_match('~/logo/|logo[._-]~i', $src);
            $is_decoration = (bool)preg_match('~/(?:shape|icon)/~', $src);
            $first = !$eager && !$is_logo && !$is_decoration && $src && $first_content_image;
            if ($first) $first_content_image = false;
            // Preserve explicit loading choices and never lazy-load logos/hero.
            if (!$eager && !$is_logo && !$first && null === $processor->get_attribute('loading')) $processor->set_attribute('loading', 'lazy');
            if (null === $processor->get_attribute('decoding')) $processor->set_attribute('decoding', 'async');
            $dimensions = nsp_static_image_dimensions($src);
            if ($dimensions) {
                [$width, $height] = $dimensions;
                $existing_width = $processor->get_attribute('width');
                $existing_height = $processor->get_attribute('height');
                if (null === $existing_width && null === $existing_height) {
                    $processor->set_attribute('width', $width);
                    $processor->set_attribute('height', $height);
                } elseif (null === $existing_height && is_numeric($existing_width)) {
                    $processor->set_attribute('height', (int)round($height * (float)$existing_width / $width));
                } elseif (null === $existing_width && is_numeric($existing_height)) {
                    $processor->set_attribute('width', (int)round($width * (float)$existing_height / $height));
                }
            }
        }
        if (!in_array($tag, $void, true)) $stack[] = [$tag, $eager];
    }
    return $processor->get_updated_html();
}

add_action('template_redirect', function () {
    if (is_feed() || is_trackback() || is_embed() || wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) return;
    ob_start('nsp_image_performance_markup');
});
