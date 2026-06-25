<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="clinox-sidebar">
	<?php if ( false ) : // reserve slot for custom WP widgets when added via Appearance > Widgets
		dynamic_sidebar( 'blog-sidebar' );
	else : ?>
		<!-- Search widget -->
		<div class="widget clinox-search-widget">
			<h3 class="widget-title"><?php nsp_te( 'Search News', 'بحث في الأخبار' ); ?></h3>
			<?php get_search_form(); ?>
		</div>

		<!-- Categories widget -->
		<div class="widget clinox-category-widget headline ul-li-block">
			<h3 class="widget-title"><?php nsp_te( 'Popular Category', 'الفئات الشائعة' ); ?></h3>
			<ul>
				<?php
				$_sb_cats = get_categories( [ 'hide_empty' => false ] );
				foreach ( $_sb_cats as $_sb_cat ) :
					$_sb_ar   = nsp_cat_ar( $_sb_cat->name );
					$_sb_name = ( $_sb_ar !== '' ) ? $_sb_ar : esc_html( $_sb_cat->name );
				?>
				<li class="cat-item"><a href="<?php echo esc_url( get_category_link( $_sb_cat->term_id ) ); ?>"><?php echo esc_html( $_sb_name ); ?> (<?php echo (int) $_sb_cat->count; ?>)</a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- Recent posts widget -->
		<div class="widget clinox-recent-posts-widget">
			<h3 class="widget-title"><?php nsp_te( 'Popular Posts', 'المقالات الشائعة' ); ?></h3>
			<div class="recent-blog-wrap">
				<?php
				$recent = new WP_Query( [
					'posts_per_page'      => 4,
					'post_status'         => 'publish',
					'no_found_rows'       => true,
					'ignore_sticky_posts' => true,
				] );
				while ( $recent->have_posts() ) :
					$recent->the_post();
					$_r_raw   = get_the_title();
					$_r_ar    = nsp_post_ar( $_r_raw, 'title' );
					$_r_title = ( $_r_ar !== '' ) ? $_r_ar : $_r_raw;
					?>
					<div class="recent-blog-img-text d-flex align-items-center">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="recent-img">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'nsp-blog-thumb', [ 'alt' => $_r_title ] ); ?></a>
						</div>
						<?php endif; ?>
						<div class="recent-text headline pera-content">
							<h4><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_r_title ); ?></a></h4>
							<span><?php echo esc_html( nsp_get_the_date() ); ?></span>
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>

		<!-- Tag Cloud widget -->
		<div class="widget clinox-tags-widget">
			<h3 class="widget-title"><?php nsp_te( 'Popular Tags', 'الوسوم الشائعة' ); ?></h3>
			<?php wp_tag_cloud( [ 'smallest' => 10, 'largest' => 14, 'unit' => 'px', 'number' => 20 ] ); ?>
		</div>
	<?php endif; ?>
</div>
