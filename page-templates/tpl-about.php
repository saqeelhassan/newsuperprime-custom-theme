<?php
/**
 * Template Name: About Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( esc_url( nsp_asset( 'assets/img/banner/breadcrumb-about.jpg' ) ), nsp_t( 'About Us', 'من نحن' ) );
?>

<!-- Start of About section
============================================= -->
<section id="clinox-about" class="clinox-about-section">
	<div class="container">
		<div class="clinox-about-content-2">
			<div class="row">
				<div class="col-lg-6">
					<div class="clinox-about-img-wrapper position-relative">
						<div class="clinox-about-img1">
							<img src="<?php echo esc_url( nsp_asset( 'assets/img/about/ab2.jpg' ) ); ?>" alt="">
						</div>
						<div class="about-exp position-absolute headline d-flex align-items-center justify-content-center">
							<h3>100%</h3>
							<span><?php nsp_te( 'Quality Commitment', 'التزام بالجودة' ); ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="clinox-about-text-wrap">
						<div class="clinox-section-title headline pera-content pr-text-in">
							<h3 class="sub-title d-inline-block">
								<span class="pr-text-in_item1"><span class="pr-text-in_item2"><span class="pr-text-in_item3"><?php nsp_te( 'Who We Are', 'من نحن' ); ?></span></span></span>
							</h3>
							<h2>
								<span class="pr-text-in_item1"><span class="pr-text-in_item2"><span class="pr-text-in_item3"><?php nsp_te( 'Your Trusted Partner for Cleaning, Pest Control & Maintenance', 'شريككم الموثوق في التنظيف ومكافحة الآفات والصيانة' ); ?></span></span></span>
							</h2>
							<?php the_content(); ?>
						</div>
						<div class="about-feature-item-wrap-2 ul-li-block">
							<ul>
								<li><?php nsp_te( 'Proudly serving Dammam, Khobar, Jubail, Qatif, Al-Ahsa & all Eastern Province cities.', 'نخدم بفخر الدمام والخبر والجبيل والقطيف والأحساء وجميع مدن المنطقة الشرقية.' ); ?></li>
								<li><?php nsp_te( 'We always ensure the highest quality standards for every client.', 'نلتزم دائماً بتقديم أعلى معايير الجودة لكل عميل.' ); ?></li>
								<li><?php nsp_te( 'Our trained team is ready to serve you at any time across the Eastern Province.', 'فريقنا المدرب جاهز لخدمتك في أي وقت في جميع أنحاء المنطقة الشرقية.' ); ?></li>
							</ul>
						</div>
						<div class="about-signature-cta-wrap d-flex">
							<div class="about-cta-btn d-flex">
								<div class="banener-cta d-flex align-items-center">
									<i class="far fa-phone-alt"></i>
									<div class="banener-cta-text">
										<span><?php nsp_te( 'Emergency Call', 'اتصال طوارئ' ); ?></span>
										<span dir="ltr" class="banener-cta-phones">
											<a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?></a>,
											<a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></a>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of About section
============================================= -->

<!-- Start of Fun Fact section
============================================= -->
<section id="clinox-fun-fact" class="clinox-fun-fact-section position-relative" data-background="<?php echo esc_url( nsp_asset( 'assets/img/bg/fun-bg.jpg' ) ); ?>">
	<div class="banner-shape position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/banner/fun-fact-bg.png' ) ); ?>" alt=""></div>
	<div class="container">
		<div class="clinox-fun-fact-content position-relative">
			<div class="row">
				<?php
				$facts = [
					[ '58',  'k+', nsp_t( 'Complete Project',  'مشروع منجز' ) ],
					[ '305', '+',  nsp_t( 'Cleaning Expert',   'خبير تنظيف' ) ],
					[ '48',  'k+', nsp_t( 'Satisfied Client',  'عميل راضٍ' ) ],
					[ '125', '+',  nsp_t( 'National Awarded',  'جائزة وطنية' ) ],
				];
				foreach ( $facts as $f ) :
				?>
				<div class="col-lg-3 col-md-6">
					<div class="clinox-fun-fact-item headline pera-content d-flex justify-content-center">
						<div class="inner-text-counter">
							<h3><span class="counter"><?php echo esc_html( $f[0] ); ?></span><?php echo esc_html( $f[1] ); ?></h3>
							<p><?php echo esc_html( $f[2] ); ?></p>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<!-- End of Fun Fact section
============================================= -->

<!-- Start of Team section (slider)
============================================= -->
<section id="clinox-team" class="clinox-team-section">
	<div class="container">
		<div class="clinox-section-title headline text-center pera-content pr-text-in">
			<h3 class="sub-title d-inline-block">
				<span class="pr-text-in_item1"><span class="pr-text-in_item2"><span class="pr-text-in_item3"><?php nsp_te( 'Our Team Members', 'أعضاء فريقنا' ); ?></span></span></span>
			</h3>
			<h2>
				<span class="pr-text-in_item1"><span class="pr-text-in_item2"><span class="pr-text-in_item3"><?php nsp_te( 'Expert Cleaning Staff.', 'فريق التنظيف المتخصص' ); ?></span></span></span>
			</h2>
		</div>
		<div class="clinox-team-content position-relative">
			<div class="clinox-team-slider-wrap">
				<?php
				$team_query = new WP_Query( [
					'post_type'      => 'team',
					'posts_per_page' => 6,
					'post_status'    => 'publish',
					'no_found_rows'  => true,
				] );
				$fallback_imgs = [ 'tm1.jpg', 'tm2.jpg', 'tm3.jpg' ];
				$ti = 0;
				if ( $team_query->have_posts() ) :
					while ( $team_query->have_posts() ) :
						$team_query->the_post();
						$position = get_post_meta( get_the_ID(), '_nsp_team_position', true );
						?>
						<div class="slider-inner-item">
							<div class="clinox-team-inner-item position-relative">
								<div class="inner-img">
									<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-team', [ 'alt' => get_the_title() ] );
									else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/team/' . $fallback_imgs[ $ti % 3 ] ) ); ?>" alt="<?php the_title_attribute(); ?>"><?php endif; ?>
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
						<?php $ti++; endwhile;
					wp_reset_postdata();
				else :
					for ( $i = 0; $i < 3; $i++ ) :
					?>
					<div class="slider-inner-item">
						<div class="clinox-team-inner-item position-relative">
							<div class="inner-img"><img src="<?php echo esc_url( nsp_asset( 'assets/img/team/' . $fallback_imgs[ $i ] ) ); ?>" alt=""></div>
							<div class="inner-text-social position-absolute headline text-center">
								<h3><a href="<?php echo esc_url( nsp_post_type_archive_url( 'team', 'team' ) ); ?>"><?php nsp_te( 'Raymond Turner', 'عبدالرحمن الغامدي' ); ?></a></h3>
								<span><?php nsp_te( 'Senior Cleaner', 'مشرف تنظيف أول' ); ?></span>
							</div>
						</div>
					</div>
					<?php endfor; endif; ?>
			</div>
			<div class="carousel_nav">
				<button type="button" class="team_left_arrow"><i class="far fa-long-arrow-left"></i></button>
				<button type="button" class="team_right_arrow"><i class="far fa-long-arrow-right"></i></button>
			</div>
		</div>
	</div>
</section>
<!-- End of Team section
============================================= -->

<!-- Start of Why choose section
============================================= -->
<section id="clinox-why-choose" class="clinox-why-choose-section">
	<div class="container">
		<div class="clinox-why-choose-content">
			<div class="row">
				<div class="col-lg-6">
					<div class="clinox-why-choose-text-wrap">
						<div class="clinox-section-title headline pera-content">
							<span class="sub-title"><?php nsp_te( 'Why Choose US?', 'لماذا تختارنا؟' ); ?></span>
							<h2><?php nsp_te( 'We Will Make Every Inch Clean & Organized.', 'سنجعل كل شبر نظيفاً ومرتباً.' ); ?></h2>
						</div>
						<div class="clinox-why-choose-inner-wrapper">
							<div class="row">
								<div class="col-md-6">
									<div class="clinox-why-choose-inner-item">
										<div class="inner-icon position-relative"><img src="<?php echo esc_url( nsp_asset( 'assets/img/icon/ic11.png' ) ); ?>" alt=""></div>
										<div class="inner-text headline"><h3><?php nsp_te( 'Daily & Monthly Cleaning', 'تنظيف يومي وشهري' ); ?></h3></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="clinox-why-choose-inner-item">
										<div class="inner-icon position-relative"><img src="<?php echo esc_url( nsp_asset( 'assets/img/icon/ic10.png' ) ); ?>" alt=""></div>
										<div class="inner-text headline"><h3><?php nsp_te( '100% Cleaning Satisfaction', 'رضا تنظيف ١٠٠٪' ); ?></h3></div>
									</div>
								</div>
							</div>
						</div>
						<div class="clinox-why-choose-skill-wrap headline pera-content">
							<h3><?php nsp_te( 'Our Skill Making Your Business Shine:', 'مهاراتنا تجعل عملك يتألق:' ); ?></h3>
							<div class="skill-progress-bar">
								<div class="skill-set-percent headline">
									<h4><?php nsp_te( 'Commercial', 'تجاري' ); ?></h4>
									<div class="progress"><div class="progress-bar" data-percent="92"></div></div>
								</div>
								<div class="skill-set-percent headline">
									<h4><?php nsp_te( 'Residential', 'سكني' ); ?></h4>
									<div class="progress"><div class="progress-bar" data-percent="85"></div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="clinox-why-choose-img position-relative">
						<span class="bg-shape position-absolute"></span>
						<div class="why-choose-img1 bg-img-area">
							<img src="<?php echo esc_url( nsp_asset( 'assets/img/about/wc1.jpg' ) ); ?>" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of Why choose section
============================================= -->

<?php get_template_part( 'template-parts/sections/promo' ); ?>
<?php get_template_part( 'template-parts/sections/contact' ); ?>
<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
<?php get_footer(); ?>
