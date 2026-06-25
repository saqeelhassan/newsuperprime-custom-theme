<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo esc_url( nsp_asset( 'assets/img/logo/logo.png' ) ); ?>" type="image/png">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
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
