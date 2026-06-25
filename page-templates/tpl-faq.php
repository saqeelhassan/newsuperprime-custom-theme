<?php
/**
 * Template Name: FAQ Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Frequently Asked Questions', 'الأسئلة الشائعة' ) );
?>

<!-- Start of FAQ section
============================================= -->
<section id="clinox-faq" class="clinox-faq-section page-section-padding">
	<div class="container">
		<div class="clinox-faq-content">
			<div class="row">
				<div class="col-lg-6">
					<div class="clinox-faq-img position-relative">
						<img src="<?php echo esc_url( nsp_asset( 'assets/img/about/fq.jpg' ) ); ?>" alt="">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="clinox-faq-text-wrapper">
						<div class="clinox-section-title headline pera-content">
							<span class="sub-title"><?php nsp_te( 'FAQ', 'الأسئلة الشائعة' ); ?></span>
							<h2><?php nsp_te( 'Frequently Asked Questions', 'الأسئلة الشائعة' ); ?></h2>
						</div>
						<div class="accordion" id="accordionFaqPage">
							<?php
							$faq_q = new WP_Query( [
								'post_type'      => 'faq',
								'posts_per_page' => 10,
								'post_status'    => 'publish',
								'no_found_rows'  => true,
							] );
							$fi = 0;
							if ( $faq_q->have_posts() ) :
								while ( $faq_q->have_posts() ) :
									$faq_q->the_post();
									$uid      = 'faqPage' . $fi;
									$expanded = ( 0 === $fi ) ? 'true' : 'false';
									$show     = ( 0 === $fi ) ? 'show' : '';
									$collapsed = ( 0 === $fi ) ? '' : ' collapsed';
									?>
									<div class="accordion-item headline pera-content">
										<h2 class="accordion-header" id="heading<?php echo esc_attr( $uid ); ?>">
											<button class="accordion-button<?php echo esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse"
												data-bs-target="#collapse<?php echo esc_attr( $uid ); ?>" aria-expanded="<?php echo esc_attr( $expanded ); ?>">
												<?php the_title(); ?>
											</button>
										</h2>
										<div id="collapse<?php echo esc_attr( $uid ); ?>" class="accordion-collapse collapse <?php echo esc_attr( $show ); ?>"
											aria-labelledby="heading<?php echo esc_attr( $uid ); ?>" data-bs-parent="#accordionFaqPage">
											<div class="accordion-body"><?php the_content(); ?></div>
										</div>
									</div>
									<?php $fi++; endwhile;
								wp_reset_postdata();
							else :
								echo '<p>' . esc_html( nsp_t( 'No FAQs found. Add some via the FAQs menu in WP Admin.', 'لا توجد أسئلة. أضف بعضها عبر قائمة الأسئلة في لوحة التحكم.' ) ) . '</p>';
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of FAQ section
============================================= -->

<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
