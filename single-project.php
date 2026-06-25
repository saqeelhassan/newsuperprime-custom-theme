<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
nsp_breadcrumb( '', get_the_title() );
$client     = get_post_meta( get_the_ID(), '_nsp_project_client',     true );
$location   = get_post_meta( get_the_ID(), '_nsp_project_location',   true );
$completion = get_post_meta( get_the_ID(), '_nsp_project_completion', true );
$proj_type  = get_post_meta( get_the_ID(), '_nsp_project_type',       true );
$cleaner    = get_post_meta( get_the_ID(), '_nsp_project_cleaner',    true );
$gallery    = get_post_meta( get_the_ID(), '_nsp_project_gallery',    true );
$gallery_ids = $gallery ? array_filter( array_map( 'absint', explode( ',', $gallery ) ) ) : [];
$before_after_pairs = [
	'residential-deep-cleaning'       => [ 'pro1-before.jpeg', 'pro1-after.jpeg' ],
	'corporate-office-pest-control'   => [ 'pro2-before.jpeg', 'pro2-after.jpeg' ],
	'hotel-ac-servicing-contract'     => [ 'pro3-before.jpeg', 'pro3-after.jpeg' ],
	'tv-lounge-room'                  => [ 'pro2-before.jpeg', 'pro2-after.jpeg' ],
];
$before_after_default_pairs = array_values( $before_after_pairs );
$before_after_pair = $before_after_pairs[ get_post_field( 'post_name', get_the_ID() ) ] ?? $before_after_default_pairs[ get_the_ID() % count( $before_after_default_pairs ) ];

// Category term name
$proj_terms = get_the_terms( get_the_ID(), 'project_category' );
$cat_name   = ( $proj_terms && ! is_wp_error( $proj_terms ) ) ? $proj_terms[0]->name : '';
?>

<!-- Start of portfolio details section
============================================= -->
<section id="clinox-portfolio-details" class="clinox-portfolio-details-section page-section-padding">
	<div class="container">
		<div class="clinox-portfolio-details-content">
			<div class="row">
				<div class="col-lg-8">
					<div class="clinox-project-details-slider position-relative">
						<div class="project-before-after-view">
							<div class="slider-inner-img">
								<div class="nsp-before-after nsp-before-after--details" aria-label="<?php echo esc_attr( sprintf( nsp_t( 'Before and after view of %s', 'عرض قبل وبعد لـ %s' ), get_the_title() ) ); ?>">
									<img class="nsp-before-after__img nsp-before-after__img--before" src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/project/' . $before_after_pair[0] ) ); ?>" alt="<?php echo esc_attr( sprintf( nsp_t( 'Before %s', 'قبل %s' ), get_the_title() ) ); ?>">
									<div class="nsp-before-after__after">
										<img class="nsp-before-after__img nsp-before-after__img--after" src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/project/' . $before_after_pair[1] ) ); ?>" alt="<?php echo esc_attr( sprintf( nsp_t( 'After %s', 'بعد %s' ), get_the_title() ) ); ?>">
									</div>
									<span class="nsp-before-after__label nsp-before-after__label--before"><?php nsp_te( 'Before', 'قبل' ); ?></span>
									<span class="nsp-before-after__label nsp-before-after__label--after"><?php nsp_te( 'After', 'بعد' ); ?></span>
									<span class="nsp-before-after__divider" aria-hidden="true"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="clinox-project-details-feature headline">
						<h3><?php esc_html_e( 'Project Info', 'newsuperprime' ); ?></h3>
						<div class="feature-list ul-li-block">
							<ul>
								<?php if ( $client )     : ?><li><?php esc_html_e( 'Clients',       'newsuperprime' ); ?> <span><?php echo esc_html( $client ); ?></span></li><?php endif; ?>
								<?php if ( $location )   : ?><li><?php esc_html_e( 'Location',      'newsuperprime' ); ?> <span><?php echo esc_html( $location ); ?></span></li><?php endif; ?>
								<?php if ( $completion ) : ?><li><?php esc_html_e( 'Completion',    'newsuperprime' ); ?> <span><?php echo esc_html( $completion ); ?></span></li><?php endif; ?>
								<?php if ( $proj_type )  : ?><li><?php esc_html_e( 'Project Type',  'newsuperprime' ); ?> <span><?php echo esc_html( $proj_type ); ?></span></li><?php endif; ?>
								<?php if ( $cat_name )   : ?><li><?php esc_html_e( 'Category',      'newsuperprime' ); ?> <span><?php echo esc_html( $cat_name ); ?></span></li><?php endif; ?>
								<?php if ( $cleaner )    : ?><li><?php esc_html_e( 'Cleaner',       'newsuperprime' ); ?> <span><?php echo esc_html( $cleaner ); ?></span></li><?php endif; ?>
							</ul>
						</div>
						<div class="project-share d-flex justify-content-between">
							<span class="title"><?php esc_html_e( 'Share', 'newsuperprime' ); ?></span>
							<div class="share-social">
								<?php nsp_social_links_html(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clinox-project-details-text-wrapper">
			<div class="project-details-text-content headline pera-content">
				<h3><?php esc_html_e( 'Project Details', 'newsuperprime' ); ?></h3>
				<?php the_content(); ?>
			</div>
			<div class="clinox-project-overview">
				<?php if ( $gallery_ids && count( $gallery_ids ) >= 2 ) : ?>
				<div class="row">
					<div class="col-lg-6">
						<div class="row">
							<div class="col-md-6">
								<div class="clinox-about-service-img-wrap position-relative">
									<span class="img-shape position-absolute"></span>
									<div class="clinox-about-service-img">
										<?php echo wp_get_attachment_image( $gallery_ids[0], 'medium' ); ?>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="clinox-about-service-img-wrap position-relative">
									<span class="img-shape position-absolute"></span>
									<div class="clinox-about-service-img">
										<?php echo wp_get_attachment_image( $gallery_ids[1], 'medium' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="clinox-service-feature-items headline pera-content ul-li-block position-relative">
							<div class="clinox-service-feature-text position-relative">
								<h3><?php esc_html_e( 'Project Overview', 'newsuperprime' ); ?></h3>
								<p><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div class="clinox-project-next-prev-btn d-flex justify-content-between">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					?>
					<?php if ( $prev ) : ?>
					<div class="clinox-btn">
						<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>"><span><?php esc_html_e( 'Previous Project', 'newsuperprime' ); ?></span></a>
					</div>
					<?php endif; ?>
					<?php if ( $next ) : ?>
					<div class="clinox-btn">
						<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>"><span><?php esc_html_e( 'Next Project', 'newsuperprime' ); ?></span></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of portfolio details section
============================================= -->

<?php get_template_part( 'template-parts/sections/contact' ); ?>
<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php endwhile; get_footer(); ?>
