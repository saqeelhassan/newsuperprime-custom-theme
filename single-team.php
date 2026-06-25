<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
nsp_breadcrumb( '', get_the_title() );
$position   = get_post_meta( get_the_ID(), '_nsp_team_position',    true );
$experience = get_post_meta( get_the_ID(), '_nsp_team_experience',  true );
$projects   = get_post_meta( get_the_ID(), '_nsp_team_projects',    true );
$email      = get_post_meta( get_the_ID(), '_nsp_team_email',       true );
$phone      = get_post_meta( get_the_ID(), '_nsp_team_phone',       true );
?>

<!-- Start of Team Details section
============================================= -->
<section id="clinox-team-details" class="clinox-team-details-section page-section-padding">
	<div class="container">
		<div class="clinox-team-details-content">
			<div class="row">
				<div class="col-lg-4">
					<div class="clinox-team-details-img">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-team', [ 'alt' => get_the_title() ] );
						else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/team/tmd1.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>"><?php endif; ?>
					</div>
					<div class="clinox-team-details-info headline pera-content">
						<h3><?php the_title(); ?></h3>
						<?php if ( $position ) : ?><span><?php echo esc_html( $position ); ?></span><?php endif; ?>
						<ul>
							<?php if ( $experience ) : ?><li><?php esc_html_e( 'Experience:', 'newsuperprime' ); ?> <span><?php echo esc_html( $experience ); ?> <?php esc_html_e( 'Years', 'newsuperprime' ); ?></span></li><?php endif; ?>
							<?php if ( $projects )   : ?><li><?php esc_html_e( 'Projects:', 'newsuperprime' ); ?> <span><?php echo esc_html( $projects ); ?>+ <?php esc_html_e( 'Completed', 'newsuperprime' ); ?></span></li><?php endif; ?>
							<?php if ( $email )      : ?><li><?php esc_html_e( 'Email:', 'newsuperprime' ); ?> <span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span></li><?php endif; ?>
							<?php if ( $phone )      : ?><li><?php esc_html_e( 'Phone:', 'newsuperprime' ); ?> <span><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></span></li><?php endif; ?>
						</ul>
						<div class="team-details-social ul-li">
							<?php nsp_social_links_html(); ?>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="clinox-team-details-text headline pera-content">
						<h3><?php esc_html_e( 'Biography', 'newsuperprime' ); ?></h3>
						<?php the_content(); ?>
					</div>
					<!-- Skills -->
					<div class="clinox-team-details-skill">
						<h3><?php esc_html_e( 'Professional Skills', 'newsuperprime' ); ?></h3>
						<?php nsp_team_skills( get_the_ID() ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of Team Details section
============================================= -->

<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php endwhile; get_footer(); ?>
