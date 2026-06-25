<!-- Start of Footer section
============================================= -->
<footer id="clinox-footer-1" class="clinox-footer-section-1" data-background="<?php echo esc_url( nsp_asset( 'assets/img/bg/footer-bg.jpg' ) ); ?>">
	<div class="container">
		<div class="clinox-footer-widget-wrapper">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="clinox-footer-widget headline pera-content ul-li-block">
						<div class="logo-widget">
							<div class="footer-logo">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php nsp_footer_logo(); ?></a>
							</div>
							<p><?php echo esc_html( nsp_t(
								get_theme_mod( 'nsp_footer_about', 'Your trusted cleaning partner in the Eastern Province since 1997. Serving Dammam, Khobar, Jubail, Qatif, Al-Ahsa and beyond.' ),
								get_theme_mod( 'nsp_footer_about_ar', 'نسعى دائماً لتقديم أفضل خدمات التنظيف باستخدام أحدث الأساليب والمواد الآمنة، لنمنح عملاءنا بيئة نظيفة وصحية.' )
							) ); ?></p>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-3">
					<div class="clinox-footer-widget headline pera-content ul-li-block">
						<div class="menu-widget">
							<h3 class="widget-title"><?php nsp_te( 'Services', 'خدماتنا' ); ?></h3>
							<ul>
								<?php
								$_footer_svcs = get_transient( 'nsp_footer_services' );
								if ( false === $_footer_svcs ) {
									$_footer_svcs = [];
									$_svc_q = new WP_Query( [
										'post_type'      => 'service',
										'posts_per_page' => 6,
										'post_status'    => 'publish',
										'no_found_rows'  => true,
										'fields'         => 'ids',
									] );
									foreach ( $_svc_q->posts as $_svc_id ) {
										$_footer_svcs[] = [
											'title' => get_the_title( $_svc_id ),
											'url'   => get_permalink( $_svc_id ),
										];
									}
									set_transient( 'nsp_footer_services', $_footer_svcs, HOUR_IN_SECONDS );
								}
								foreach ( $_footer_svcs as $_svc ) {
									echo '<li><a href="' . esc_url( $_svc['url'] ) . '">' . esc_html( nsp_service_ar( $_svc['title'], 'title' ) ?: $_svc['title'] ) . '</a></li>';
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="clinox-footer-widget headline pera-content ul-li-block">
						<div class="newsleter-widget">
							<h3 class="widget-title"><?php nsp_te( 'Newsletter', 'النشرة البريدية' ); ?></h3>
							<div class="newsleter-form">
								<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
									<input type="hidden" name="action" value="nsp_subscribe">
									<?php wp_nonce_field( 'nsp_newsletter_subscribe', 'nsp_newsletter_nonce' ); ?>
									<input type="email" name="nsp_email" placeholder="<?php nsp_ta( 'Email', 'البريد الإلكتروني' ); ?>">
									<button type="submit"><?php nsp_te( 'Subscribe Now', 'اشترك الآن' ); ?></button>
								</form>
							</div>
							<div class="footer-social ul-li">
								<?php nsp_social_links_html(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clinox-copyright-wrap text-center">
			<div class="container">
				<span>
					<?php
					$copyright_text = get_theme_mod( 'nsp_copyright_text', 'Copyright &copy; 2024 New Super Prime. All rights reserved. | Crafted by De Weboo' );
					if ( strpos( $copyright_text, 'href="https://deweboo.com/"' ) === false ) {
						$copyright_text = str_replace( 'De Weboo', '<a href="https://deweboo.com/" target="_blank">De Weboo</a>', $copyright_text );
					}
					echo wp_kses_post( $copyright_text );
					?>
				</span>
			</div>
		</div>
	</div>
</footer>
<!-- End of Footer section
============================================= -->
<?php wp_footer(); ?>
</body>
</html>
