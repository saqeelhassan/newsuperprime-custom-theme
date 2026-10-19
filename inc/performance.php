<?php
/**
 * Front-end performance tweaks.
 *
 * Put this file in:  newsuperprime-theme/inc/performance.php
 * Then add this line to functions.php (next to the other inc/ requires):
 *   require_once get_template_directory() . '/inc/performance.php';
 *
 * @package NewSuperPrime
 */

defined( 'ABSPATH' ) || exit;
require_once __DIR__ . '/image-performance.php';
require_once __DIR__ . '/performance-round3.php';

/**
 * 1. Remove the WordPress emoji script and styles (wp-emoji-release.min.js).
 */
add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
} );

/**
 * 2. Load Contact Form 7 assets only on pages that show a CF7 form:
 *    home (estimate form), Contact and Booking templates.
 *    Add more templates here if you place a form elsewhere.
 */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

add_action( 'wp_enqueue_scripts', function () {
	$has_form = is_page_template(
		array(
			'page-templates/tpl-contact.php',
			'page-templates/tpl-booking.php',
			'page-templates/tpl-about.php',
		)
	);
	$has_form = $has_form || is_post_type_archive( 'project' ) || is_tax( 'project_category' ) || is_singular( 'project' );
	$has_form = $has_form || 0 === strpos( (string) get_page_template_slug(), 'page-templates/tpl-service-' );
	// Preserve forms added through the editor, not just the original templates.
	$post = get_queried_object();
	if ( $post instanceof WP_Post ) {
		$has_form = $has_form || has_shortcode( $post->post_content, 'contact-form-7' ) || has_block( 'contact-form-7/contact-form-selector', $post );
	}

	if ( ! $has_form ) {
		return;
	}
	if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
		wpcf7_enqueue_scripts();
	}
	if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
		wpcf7_enqueue_styles();
	}
} );

/**
 * 3. Remove the oEmbed discovery script (wp-embed) – not used by this theme.
 */
add_action( 'wp_footer', function () {
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) || ( ! has_block( 'core/embed', $post ) && false === strpos( $post->post_content, 'wp-embedded-content' ) ) ) wp_dequeue_script( 'wp-embed' );
} );

/**
 * 4. Remove small unused <head> extras.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
