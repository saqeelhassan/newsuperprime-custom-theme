<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', sprintf( nsp_t( 'Search: %s', 'البحث: %s' ), get_search_query() ) );
?>

<section id="clinox-search-results" class="clinox-blog-feed-section page-section-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<?php if ( have_posts() ) : ?>
				<div class="clinox-blog-feed-wrap">
					<?php while ( have_posts() ) : the_post();
						$_raw_title  = get_the_title();
						$_ar_title   = nsp_post_ar( $_raw_title, 'title' );
						$_post_title = ( $_ar_title !== '' ) ? $_ar_title : $_raw_title;
						$_ar_excerpt = nsp_post_ar( $_raw_title, 'excerpt' );
						$_excerpt    = ( $_ar_excerpt !== '' ) ? $_ar_excerpt : get_the_excerpt();
					?>
					<div class="clinox-blog-feed-item">
						<div class="inner-img">
							<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-blog-feed', [ 'alt' => $_post_title ] );
							else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/blog/b1.jpg' ) ); ?>" alt=""><?php endif; ?>
						</div>
						<div class="inner-text headline pera-content">
							<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_post_title ); ?></a></h3>
							<?php nsp_post_meta(); ?>
							<p><?php echo esc_html( wp_trim_words( $_excerpt, 25 ) ); ?></p>
							<a class="read-more" href="<?php the_permalink(); ?>"><?php nsp_te( 'Read More', 'اقرأ المزيد' ); ?></a>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
				<?php nsp_pagination(); ?>
				<?php else : ?>
				<p><?php printf( esc_html( nsp_t( 'No results found for "%s".', 'لم يتم العثور على نتائج لـ "%s".' ) ), esc_html( get_search_query() ) ); ?></p>
				<?php get_search_form(); ?>
				<?php endif; ?>
			</div>
			<div class="col-lg-4"><?php get_sidebar(); ?></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
