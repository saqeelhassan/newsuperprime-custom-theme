<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Our Services', 'خدماتنا' ) );
?>

<!-- Start of Service Feed section
============================================= -->
<section id="clinox-service-feed" class="clinox-service-feed-section">
	<div class="container">
		<div class="clinox-service-feed-content">
			<div class="row">
				<?php
				$si = 0;
				$svc_imgs = [ 'ic19.png', 'ic20.png', 'ic21.png' ];

				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						$_svc_title = get_the_title();
						$_svc_ar_t  = nsp_service_ar( $_svc_title, 'title' );
						$_svc_ar_d  = nsp_service_ar( $_svc_title, 'desc' );
						$icon_img   = nsp_asset( 'assets/img/icon/' . $svc_imgs[ $si % 3 ] );
						?>
						<div class="col-lg-4 col-md-6">
							<div class="clinex-service-item-2 text-center">
								<div class="inner-icon d-flex justify-content-center align-items-center">
									<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-service' );
									else : ?><img src="<?php echo esc_url( $icon_img ); ?>" alt=""><?php endif; ?>
								</div>
								<div class="inner-text headline pera-content">
									<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_svc_ar_t ?: $_svc_title ); ?></a></h3>
									<p><?php echo $_svc_ar_d ? esc_html( $_svc_ar_d ) : wp_trim_words( get_the_excerpt(), 18 ); ?></p>
									<a class="read-more d-flex justify-content-center align-items-center" href="<?php the_permalink(); ?>"><?php nsp_te( 'View Details', 'عرض التفاصيل' ); ?></a>
								</div>
							</div>
						</div>
						<?php $si++;
					endwhile;
				else :
					echo '<p>' . esc_html( nsp_t( 'No services found. Add some via the Services menu in WP Admin.', 'لا توجد خدمات. أضف من قائمة الخدمات في لوحة التحكم.' ) ) . '</p>';
				endif;
				?>
			</div>
			<?php nsp_pagination(); ?>
		</div>
	</div>
</section>
<!-- End of Service Feed section
============================================= -->

<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/contact' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
