<?php
/**
 * Template Name: Contact Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Contact Us', 'تواصل معنا' ) );
?>

<?php get_template_part( 'template-parts/sections/contact' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
