<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
$_s_raw_title  = get_the_title();
$_s_ar_title   = nsp_get_post_ar( get_the_ID(), 'title' );
$_s_post_title = ( $_s_ar_title !== '' ) ? $_s_ar_title : ( nsp_is_arabic() ? nsp_missing_post_ar_text( 'title' ) : $_s_raw_title );
$_s_ar_content = nsp_get_post_ar( get_the_ID(), 'content' );
nsp_breadcrumb( '', $_s_post_title );
$tags = get_the_tags();
?>

<!-- Start of Blog Single section
============================================= -->
<section id="clinox-blog-single" class="clinox-blog-single-section page-section-padding">
	<div class="container">
		<div class="clinox-blog-single-content">
			<div class="row">
				<div class="col-lg-8">
					<div class="clinox-blog-single-wrap">
						<div class="blog-single-img">
							<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-blog-feed', [ 'alt' => $_s_post_title ] );
							else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/blog/blg1.jpg' ) ); ?>" alt=""><?php endif; ?>
						</div>
						<div class="blog-single-text pera-content headline">
							<?php
							$_s_cats    = get_the_category();
							$_s_raw_cat = $_s_cats ? $_s_cats[0]->name : '';
							$_s_ar_cat  = nsp_cat_ar( $_s_raw_cat );
							$_s_cat_name = ( $_s_ar_cat !== '' ) ? $_s_ar_cat : esc_html( $_s_raw_cat );
							?>
							<div class="inner-meta-category d-flex align-items-center">
								<?php if ( $_s_cats ) : ?>
								<a class="blog-cat" href="<?php echo esc_url( get_category_link( $_s_cats[0]->term_id ) ); ?>"><?php echo esc_html( $_s_cat_name ); ?></a>
								<?php endif; ?>
								<div class="inner-meta ul-li">
									<ul>
										<li><a href="#"><i class="fal fa-user"></i><?php echo esc_html( get_the_author() ); ?></a></li>
										<li><a href="#"><i class="fal fa-calendar-alt"></i><?php echo esc_html( nsp_get_the_date() ); ?></a></li>
									</ul>
								</div>
							</div>
							<h1><?php echo esc_html( $_s_post_title ); ?></h1>
							<?php if ( $_s_ar_content !== '' ) : ?>
								<?php echo wp_kses_post( wpautop( $_s_ar_content ) ); ?>
							<?php elseif ( nsp_is_arabic() ) : ?>
								<?php echo wp_kses_post( wpautop( nsp_missing_post_ar_text( 'content' ) ) ); ?>
							<?php else : ?>
								<?php the_content(); ?>
							<?php endif; ?>

							<!-- Tags -->
							<?php if ( $tags ) : ?>
							<div class="blog-tags ul-li">
								<?php foreach ( $tags as $tag ) : ?>
									<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>

							<!-- Share -->
							<div class="blog-share d-flex justify-content-between align-items-center">
								<div class="share-social ul-li">
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
									<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&amp;text=<?php echo esc_attr( $_s_post_title ); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
								</div>
							</div>

							<!-- Prev / Next -->
							<div class="blog-nav d-flex justify-content-between">
								<?php
								$prev_post = get_previous_post();
								$next_post = get_next_post();
								if ( $prev_post ) :
								?>
								<div class="prev-post">
									<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><i class="fal fa-long-arrow-left"></i> <?php nsp_te( 'Previous Post', 'المقال السابق' ); ?></a>
								</div>
								<?php endif; if ( $next_post ) : ?>
								<div class="next-post">
									<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php nsp_te( 'Next Post', 'المقال التالي' ); ?> <i class="fal fa-long-arrow-right"></i></a>
								</div>
								<?php endif; ?>
							</div>

							<!-- Author bio -->
							<div class="blog-author d-flex align-items-center">
								<div class="author-img">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
								</div>
								<div class="author-text headline pera-content">
									<h4><?php the_author(); ?></h4>
									<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
								</div>
							</div>
						</div>

						<!-- Comments -->
						<?php comments_template(); ?>
					</div>
				</div>
				<div class="col-lg-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of Blog Single section
============================================= -->

<?php endwhile; get_footer(); ?>
