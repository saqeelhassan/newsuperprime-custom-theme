<?php
/**
 * Template Name: Pricing Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Service Pricing', 'أسعار الخدمات' ) );
?>

<?php get_template_part( 'template-parts/content/content-pricing' ); ?>

<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
