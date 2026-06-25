<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Our Projects', 'مشاريعنا' ) );

$filter_terms = get_terms( [ 'taxonomy' => 'project_category', 'hide_empty' => true ] );
?>

<!-- Start of project feed section
============================================= -->
<section id="clinox-project-feed" class="clinox-project-feed-section page-section-padding">
	<div class="container">
		<div class="project-feed-filter-btn ul-li">
			<ul id="filters" class="nav-gallery text-center">
				<li class="filtr-button filtr-active" data-filter="all"><?php nsp_te( 'All Projects', 'الكل' ); ?></li>
				<?php if ( ! is_wp_error( $filter_terms ) ) : foreach ( $filter_terms as $t ) : ?>
				<li class="filtr-button" data-filter="<?php echo esc_attr( $t->slug ); ?>"><?php echo esc_html( $t->name ); ?></li>
				<?php endforeach; endif; ?>
			</ul>
		</div>
		<div class="project-feed-wrap filtr-container row">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					$_proj_title    = get_the_title();
					$_proj_ar_title = nsp_project_ar( $_proj_title, 'title' );
					$assigned = wp_get_post_terms( get_the_ID(), 'project_category', [ 'fields' => 'slugs' ] );
					$data_cat = is_array( $assigned ) && ! is_wp_error( $assigned ) ? implode( ', ', $assigned ) : 'all';
					?>
					<div class="col-lg-4 col-sm-6 filtr-item" data-category="<?php echo esc_attr( $data_cat ); ?>" data-sort="<?php the_title_attribute(); ?>">
						<div class="clinox-project-item position-relative">
							<div class="read-more position-absolute">
								<a class="d-flex justify-content-center align-items-center" href="<?php the_permalink(); ?>"><i class="fal fa-arrow-right"></i></a>
							</div>
							<div class="inner-img">
								<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-project', [ 'alt' => $_proj_title ] );
								else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/project/pro5.jpg' ) ); ?>" alt="<?php echo esc_attr( $_proj_ar_title ?: $_proj_title ); ?>"><?php endif; ?>
							</div>
							<div class="inner-text position-absolute headline">
								<span class="pro-cate">
									<?php
									$terms = get_the_terms( get_the_ID(), 'project_category' );
									if ( $terms && ! is_wp_error( $terms ) ) :
										echo '<a href="' . esc_url( get_term_link( $terms[0] ) ) . '">' . esc_html( $terms[0]->name ) . '</a>';
									else :
										echo '<a href="#">' . esc_html( nsp_t( 'Our Services', 'خدماتنا' ) ) . '</a>';
									endif;
									?>
								</span>
								<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_proj_ar_title ?: $_proj_title ); ?></a></h3>
							</div>
						</div>
					</div>
				<?php endwhile;
			else :
				echo '<p>' . esc_html( nsp_t( 'No projects found. Add some via the Projects menu in WP Admin.', 'لا توجد مشاريع. أضف من قائمة المشاريع في لوحة التحكم.' ) ) . '</p>';
			endif;
			?>
		</div>
		<?php nsp_pagination(); ?>
	</div>
</section>
<!-- End of project feed section
============================================= -->

<?php get_template_part( 'template-parts/sections/contact' ); ?>
<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
