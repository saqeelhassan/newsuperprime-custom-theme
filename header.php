<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <script>window.dataLayer=window.dataLayer||[];window.gtag=window.gtag||function(){dataLayer.push(arguments);};</script>
    <script src="<?php echo esc_url( nsp_asset( 'assets/js/tracking-delay.min.js' ) ); ?>?ver=<?php echo esc_attr( nsp_asset_version( '/assets/js/tracking-delay.min.js' ) ); ?>" defer></script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo esc_url( nsp_asset( 'assets/img/logo/logo.png' ) ); ?>" type="image/png">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5Z27DP4H"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/header/loader' ); ?>
<?php
// Home page gets the transparent sticky header; all other pages get the full header with topbar
if ( is_front_page() ) {
	get_template_part( 'template-parts/header/navbar', 'home' );
} else {
	get_template_part( 'template-parts/header/navbar', 'inner' );
}
?>
