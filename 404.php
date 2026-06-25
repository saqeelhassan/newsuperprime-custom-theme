<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', '404' );
?>

<!-- Start of 404 section
============================================= -->
<section id="clinox-404" class="clinox-404-section page-section-padding">
	<div class="container">
		<div class="clinox-404-content text-center">
			<div class="inner-img">
				<img src="<?php echo esc_url( nsp_asset( 'assets/img/blog/b1.jpg' ) ); ?>" alt="">
			</div>
			<div class="inner-text headline pera-content">
				<h2><?php echo esc_html( get_theme_mod( 'nsp_404_title', 'Page Not Found' ) ); ?></h2>
				<p><?php echo esc_html( get_theme_mod( 'nsp_404_message', 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.' ) ); ?></p>
				<div class="clinox-btn">
					<a class="d-flex align-items-center justify-content-center"
						href="<?php echo esc_url( get_theme_mod( 'nsp_404_button_url', home_url( '/' ) ) ); ?>">
						<span><?php esc_html_e( 'Back To Home', 'newsuperprime' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of 404 section
============================================= -->

<?php get_footer(); ?>
