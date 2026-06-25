<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

if ( is_category() ) {
    $_raw_title = single_cat_title( '', false );
    $_ar_title  = nsp_cat_ar( $_raw_title );
    $title      = $_ar_title !== '' ? $_ar_title : $_raw_title;
} elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
} elseif ( is_author() ) {
    $title = get_the_author();
} elseif ( is_year() ) {
    $title = get_the_date( 'Y' );
} elseif ( is_month() ) {
    $title = get_the_date( 'F Y' );
} elseif ( is_day() ) {
    $title = get_the_date();
} else {
    $title = nsp_t( 'Archives', 'الأرشيف' );
}

nsp_breadcrumb( '', $title );

$_blog_imgs = [ 'blg1.jpg', 'blg2.jpg', 'blg3.jpg', 'blg4.jpg', 'blg5.jpg', 'blg6.jpg' ];
$_bi = 0;
?>

<section id="clinox-archive" class="clinox-blog-feed-section page-section-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<?php if ( have_posts() ) : ?>
				<div class="clinox-blog-feed-wrap">
					<?php while ( have_posts() ) : the_post();
						$_raw_title  = get_the_title();
						$_ar_title   = nsp_get_post_ar( get_the_ID(), 'title' );
						$_post_title = ( $_ar_title !== '' ) ? $_ar_title : ( nsp_is_arabic() ? nsp_missing_post_ar_text( 'title' ) : $_raw_title );

						$cats        = get_the_category();
						$_raw_cat    = $cats ? $cats[0]->name : '';
						$_ar_cat     = nsp_cat_ar( $_raw_cat );
						$cat_name    = ( $_ar_cat !== '' ) ? $_ar_cat : esc_html( $_raw_cat );
						$cat_url     = $cats ? esc_url( get_category_link( $cats[0]->term_id ) ) : '';

						$_ar_excerpt  = nsp_get_post_ar( get_the_ID(), 'excerpt' );
						$_excerpt     = ( $_ar_excerpt !== '' ) ? $_ar_excerpt : ( nsp_is_arabic() ? nsp_missing_post_ar_text( 'excerpt' ) : get_the_excerpt() );
					?>
					<div class="clinox-blog-feed-item">
						<div class="inner-img">
							<?php if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'nsp-blog-feed', [ 'alt' => $_post_title ] );
							else : ?>
								<img src="<?php echo esc_url( nsp_asset( 'assets/img/blog/' . $_blog_imgs[ $_bi % count( $_blog_imgs ) ] ) ); ?>" alt="<?php echo esc_attr( $_post_title ); ?>">
							<?php endif; ?>
						</div>
						<div class="inner-text headline pera-content">
							<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_post_title ); ?></a></h3>
							<div class="inner-meta-category d-flex align-items-center">
								<?php if ( $cat_name ) : ?>
								<a class="blog-cat" href="<?php echo $cat_url; ?>"><?php echo esc_html( $cat_name ); ?></a>
								<?php endif; ?>
								<div class="inner-meta ul-li">
									<ul>
										<li><a href="<?php the_permalink(); ?>"><i class="fal fa-user"></i><?php echo esc_html( get_the_author() ); ?></a></li>
										<li><a href="<?php the_permalink(); ?>"><i class="fal fa-calendar-alt"></i><?php echo esc_html( nsp_get_the_date() ); ?></a></li>
									</ul>
								</div>
							</div>
							<p><?php echo esc_html( wp_trim_words( $_excerpt, 25 ) ); ?></p>
							<div class="read-more">
								<a href="<?php the_permalink(); ?>"><?php nsp_te( 'Read More', 'اقرأ المزيد' ); ?></a>
							</div>
						</div>
					</div>
					<?php $_bi++; endwhile; ?>
				</div>
				<?php nsp_pagination(); ?>
				<?php else : ?>
				<p><?php nsp_te( 'No posts found.', 'لم يتم العثور على مقالات.' ); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-lg-4"><?php get_sidebar(); ?></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
