<?php
/**
 * Template Name: Testimonials Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( "Our Clients' Review", 'آراء عملائنا' ) );
?>

<!-- Start of Testimonial Feed section
============================================= -->
<section id="clinox-testimonial-feed" class="clinox-testimonial-feed-section page-section-padding">
	<div class="container">
		<div class="clinox-testimonial-feed-content">
			<div class="row">
				<?php
				$tq = new WP_Query( [
					'post_type'      => 'testimonial',
					'posts_per_page' => 12,
					'post_status'    => 'publish',
				] );
				if ( $tq->have_posts() ) :
					while ( $tq->have_posts() ) :
						$tq->the_post();
						$role   = get_post_meta( get_the_ID(), '_nsp_testimonial_role',   true );
						$rating = (int) get_post_meta( get_the_ID(), '_nsp_testimonial_rating', true ) ?: 5;
						?>
						<div class="col-lg-6">
							<div class="clinox-testimonial-item">
								<div class="inner-quote-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/icon/ic3.png' ) ); ?>" alt=""></div>
								<?php nsp_star_rating( $rating ); ?>
								<p><?php echo wp_kses_post( get_the_content() ); ?></p>
								<div class="inner-author d-flex align-items-center">
									<div class="inner-img">
										<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'thumbnail' );
										else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/testimonial/av1.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>"><?php endif; ?>
									</div>
									<div class="inner-text headline">
										<h4><?php the_title(); ?></h4>
										<span><?php echo esc_html( $role ); ?></span>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile;
					wp_reset_postdata();
				else :
					echo '<p>' . esc_html( nsp_t( 'No testimonials found.', 'لا توجد تقييمات.' ) ) . '</p>';
				endif;
				?>
			</div>
		</div>
	</div>
</section>
<!-- End of Testimonial Feed section
============================================= -->

<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
