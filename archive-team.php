<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Our Team Members', 'أعضاء فريقنا' ) );
?>

<!-- Start of Team Feed section
============================================= -->
<section id="clinox-team-feed" class="clinox-team-feed-section page-section-padding">
	<div class="container">
		<div class="clinox-team-feed-content">
			<div class="row">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						$position = get_post_meta( get_the_ID(), '_nsp_team_position', true );
						?>
						<div class="col-lg-4 col-md-6">
							<div class="clinox-team-inner-item position-relative">
								<div class="inner-img">
									<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-team', [ 'alt' => get_the_title() ] );
									else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/team/tm1.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>"><?php endif; ?>
								</div>
								<div class="inner-text-social position-absolute headline text-center">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<span><?php echo esc_html( $position ); ?></span>
									<div class="inner-social">
										<?php nsp_social_links_html(); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile;
				else :
					echo '<p>' . esc_html( nsp_t( 'No team members found.', 'لا يوجد أعضاء فريق.' ) ) . '</p>';
				endif;
				?>
			</div>
			<?php nsp_pagination(); ?>
		</div>
	</div>
</section>
<!-- End of Team Feed section
============================================= -->

<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
