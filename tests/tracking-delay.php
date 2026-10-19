<?php
/** Read-only check of the script filter using the live WordPress hook stack. */
require dirname( __DIR__, 4 ) . '/wp-load.php';
$src = 'https://www.googletagmanager.com/gtag/js?id=GT-EXAMPLE';
$html = '<script id="google_gtagjs-js" src="' . esc_url( $src ) . '" async></script>';
$filtered = apply_filters( 'script_loader_tag', $html, 'google_gtagjs', $src );
$tag = new WP_HTML_Tag_Processor( $filtered );
$tag->next_tag( 'SCRIPT' );
if ( null !== $tag->get_attribute( 'src' ) || 'text/plain' !== $tag->get_attribute( 'type' ) || $src !== $tag->get_attribute( 'data-nsp-tracking-src' ) ) {
    throw new RuntimeException( 'The Site Kit Google tag must remain inert until interaction or timeout.' );
}
$local = '<script id="example" src="/local.js"></script>';
if ( apply_filters( 'script_loader_tag', $local, 'local', '/local.js' ) !== $local ) {
    throw new RuntimeException( 'The tracking gate must not alter normal scripts.' );
}
echo "PASS: Site Kit markup is delayed; inline queue configuration and other scripts remain intact.\n";
