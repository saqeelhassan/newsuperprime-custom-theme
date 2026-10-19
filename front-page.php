<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main id="nsp-home" class="nsp-home-redesign">

    <div class="nsp-catalog nsp-home-hero">
        <div class="nsp-home-hero-shell">
            <h1 class="screen-reader-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
            <?php get_template_part( 'template-parts/services/hero', null, [ 'home' => true ] ); ?>
        </div>
    </div>

    <?php get_template_part( 'template-parts/sections/home-booking' ); ?>

	<!-- Start of About Section
	============================================= -->
	<section id="clinox-about-3" class="clinox-about-section-3 position-relative">
		<span class="clinox-bg-shape position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/side-sh1.png' ) ); ?>" alt=""></span>
		<div class="container">
			<div class="clinox-about-content-3">
				<div class="row">
					<div class="col-lg-6">
						<div class="clinox-about-img-3 position-relative">
							<span class="ab-shape2 position-absolute wow fadeInUp" data-wow-delay="700ms" data-wow-duration="1500ms"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/sq-sh2.png' ) ); ?>" alt=""></span>
							<span class="ab-shape3 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/dot-sh1.png' ) ); ?>" alt=""></span>
							<span class="ab-shape4 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/dot-sh2.png' ) ); ?>" alt=""></span>
							<div class="inner-img-wrap position-relative wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
								<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/ab1.jpg' ) ); ?>" alt="">
							</div>
							<div class="inner-bottom-img position-absolute wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
								<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/ab2.jpg' ) ); ?>" alt="">
								<span class="ab-shape1 position-absolute wow fadeInRight" data-wow-delay="600ms" data-wow-duration="1500ms"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/sq-sh1.png' ) ); ?>" alt=""></span>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="clinox-about-text-area-3">
							<div class="clinox-section-title-3 headline pera-content wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
								<div class="subtitle text-uppercase"><?php nsp_te( 'about New Super Prime', 'عن نيو سوبر برايم' ); ?></div>
								<h2><?php nsp_te( 'Your Trusted Partner for Cleaning, Pest Control & Maintenance', 'شريككم الموثوق في التنظيف ومكافحة الآفات والصيانة' ); ?></h2>
								<p><?php nsp_te( 'We proudly serve Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa, Ras Tanura, Hafr Al-Batin and all surrounding Eastern Region cities. Our services include deep cleaning, home cleaning, office cleaning, pest control, AC cleaning, water tank cleaning, upholstery cleaning and moving maintenance across the Eastern Province.', 'نخدم بفخر الدمام والخبر والظهران والجبيل والقطيف والأحساء ورأس تنورة وحفر الباطن وجميع مدن المنطقة الشرقية. تشمل خدماتنا التنظيف العميق وتنظيف المنازل والمكاتب ومكافحة الآفات وتنظيف المكيفات وخزانات المياه والمفروشات وصيانة النقل في جميع أنحاء المنطقة الشرقية.' ); ?></p>
							</div>
							<div class="clinox-about-text-wrap-3">
								<h3 class="wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms"><?php nsp_te( 'We proudly serve the Eastern Province and all its cities, our services include:', 'نخدم بفخر المنطقة الشرقية وجميع مدنها، وتشمل خدماتنا:' ); ?></h3>
								<div class="clinox-about-feature-list-3 d-flex align-items-center wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
									<div class="inner-img">
										<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/ab3.jpg' ) ); ?>" alt="">
									</div>
									<div class="inner-text ul-li-block">
										<?php $about_services = nsp_get_services(); ?>
										<ul id="nsp-about-services" data-collapsed>
											<?php foreach ( $about_services as $svc ) : ?>
												<li><?php echo esc_html( nsp_service_ar( $svc['title'], 'title' ) ?: $svc['title'] ); ?></li>
											<?php endforeach; ?>
										</ul>
										<?php if ( count( $about_services ) > 4 ) : ?>
                                        <button type="button" class="nsp-about-services-toggle" aria-expanded="false" aria-controls="nsp-about-services" data-more="<?php nsp_ta( 'Read More', 'عرض المزيد' ); ?>" data-less="<?php nsp_ta( 'Read Less', 'عرض أقل' ); ?>"><?php nsp_te( 'Read More', 'عرض المزيد' ); ?></button>
                                    <?php endif; ?>
									</div>
								</div>
								<div class="clinox-about-cta-btn-grp wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
									<div class="about-cta-btn-wrapper d-flex align-items-center">
										<div class="about-cta d-flex align-items-center">
											<i class="far fa-phone-alt"></i>
											<div class="about-cta-text">
												<span><?php nsp_te( 'Emergency Services', 'خدمات الطوارئ' ); ?></span>
												<div class="nsp-emergency-phones" dir="ltr">
												<a dir="ltr" href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?></a>,
												<a dir="ltr" href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></a>
												</div>
											</div>
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

    <div id="nsp-home-services" class="nsp-catalog nsp-home-featured" data-home-services>
        <div class="container">
            <?php get_template_part( 'template-parts/services/featured' ); ?>
            <div class="nsp-home-services-link"><a href="<?php echo esc_url( nsp_post_type_archive_url( 'service', 'services' ) ); ?>"><?php nsp_te( 'View All Services', 'عرض جميع الخدمات' ); ?> <span aria-hidden="true">&rarr;</span></a></div>
        </div>
    </div>

	<!-- Start of Why choose Section
	============================================= -->
	<section id="clinox-why-choose-3" class="clinox-why-choose-section-3 position-relative">
		<span class="clinox-wc-sidebg position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/wc-bg.jpg' ) ); ?>" alt=""></span>
		<span class="clinox-wc-sidebg2 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/side-sh2.png' ) ); ?>" alt=""></span>
		<div class="container">
			<div class="clinox-why-choose-content-3">
				<div class="row">
					<div class="col-lg-6">
						<div class="clinox-why-choose-text-wrap-3">
							<div class="clinox-section-title-3 headline pera-content wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
								<div class="subtitle text-uppercase"><?php nsp_te( 'Why Choose US', 'لماذا تختارنا' ); ?></div>
								<h2><?php nsp_te( 'We Will Make Every Inch Clean & Organized', 'سنجعل كل شبر نظيفاً ومرتباً' ); ?></h2>
								<p><?php nsp_te( 'We deliver professional cleaning, pest control and maintenance services across the Eastern Province — proudly serving Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa and beyond.', 'نسعى دائماً لتقديم أفضل خدمات التنظيف باستخدام أحدث الأساليب والمواد الآمنة، لنمنح عملاءنا بيئة نظيفة وصحية.' ); ?></p>
							</div>
							<div class="clinox-why-choose-feature-wrap-3 d-flex flex-wrap position-relative">
								<?php
								$wc_items = [
									[ 'ic4.png', nsp_t( 'Daily & Monthly Cleaning', 'تنظيف يومي وشهري' ) ],
									[ 'ic5.png', nsp_t( '100% Cleaning Satisfaction', 'رضا تنظيف ١٠٠٪' ) ],
									[ 'ic6.png', nsp_t( 'Committed to Best Work', 'ملتزمون بأفضل عمل' ) ],
									[ 'ic7.png', nsp_t( 'Experts Staffs & Cleaner', 'فريق متخصص وخبير' ) ],
								];
								$delays = [ '400ms', '500ms', '600ms', '700ms' ];
								foreach ( $wc_items as $i => $item ) :
								?>
								<div class="clinox-why-choose-inner-item-3 d-flex align-items-center wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delays[ $i ] ); ?>" data-wow-duration="1500ms">
									<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/' . $item[0] ) ); ?>" alt=""></div>
									<div class="inner-text headline"><h3><?php echo esc_html( $item[1] ); ?></h3></div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="clinox-why-choose-img-3 position-relative">
							<span class="wc-shape1 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/dot-sh2.png' ) ); ?>" alt=""></span>
							<span class="wc-shape2 position-absolute wow fadeInBottom" data-wow-delay="400ms" data-wow-duration="1500ms"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/sq-sh3.png' ) ); ?>" alt=""></span>
							<div class="inner-img wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
								<img src="<?php echo esc_url( nsp_asset( nsp_is_arabic() ? 'assets/img/img-5/about/wc-arabic.jpg' : 'assets/img/img-5/about/wc.jpg' ) ); ?>" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End of Why choose Section
	============================================= -->

	<!-- Start of Fun Fact section
	============================================= -->
	<section id="clinox-fun-fact" class="clinox-fun-fact-section-3 position-relative"
		data-background="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/fun-bg.jpg' ) ); ?>">
		<div class="container">
			<div class="clinox-fun-fact-content position-relative">
				<div class="row">
					<?php
					$facts = [
						[ '2000', '+', nsp_t( 'Complete Project', 'مشروع منجز' ) ],
						[ '100', '+',  nsp_t( 'Cleaning Expert', 'خبير تنظيف' )  ],
						[ '1500', '+', nsp_t( 'Satisfied Client', 'عميل راضٍ' )  ],
						[ '15', '+',  nsp_t( 'National Awarded', 'جائزة وطنية' )  ],
					];
					foreach ( $facts as $f ) :
					?>
					<div class="col-lg-3 col-md-6">
						<div class="clinox-fun-fact-item-3 headline pera-content d-flex justify-content-center">
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

	<!-- Start of Faq section
	============================================= -->
	<?php get_template_part( 'template-parts/sections/faq' ); ?>
	<!-- End of Faq section
	============================================= -->

    <?php get_template_part( 'template-parts/sections/how-booking' ); ?>

	<!-- Start of Project section
	============================================= -->
	<section id="clinox-project-3" class="clinox-project-section">
		<div class="container">
			<div class="clinox-project-top-content-3 d-flex justify-content-between align-items-center">
				<div class="clinox-section-title-3 headline pera-content wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
					<div class="subtitle text-uppercase"><?php nsp_te( 'Latest Projects', 'أحدث المشاريع' ); ?></div>
					<h2><?php nsp_te( "Let's Discover Our Latest Finished Projects", 'اكتشف أحدث مشاريعنا المنجزة' ); ?></h2>
				</div>
				<div class="clnix-project-title-text-3 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
					<?php nsp_te( "We cover all Eastern Province cities — Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa, Ras Tanura, Hafr Al-Batin and more — delivering outstanding results on every project.", 'نغطي جميع مدن المنطقة الشرقية — الدمام والخبر والظهران والجبيل والقطيف والأحساء ورأس تنورة وحفر الباطن وغيرها — ونقدم نتائج استثنائية في كل مشروع.' ); ?>
				</div>
			</div>
			<div class="clinox-project-content-3">
				<div class="clinox-project-slider-3" dir="<?php echo nsp_is_arabic() ? 'rtl' : 'ltr'; ?>">
					<?php
					$proj_query = new WP_Query( [
						'post_type'      => 'project',
						'posts_per_page' => 6,
						'post_status'    => 'publish',
						'no_found_rows'  => true,
					] );
					$proj_before_after = [
						[ 'pro1-before.jpeg', 'pro1-after.jpeg' ],
						[ 'pro2-before.jpeg', 'pro2-after.jpeg' ],
						[ 'pro3-before.jpeg', 'pro3-after.jpeg' ],
					];

					if ( $proj_query->have_posts() ) :
						$pi = 0;
						while ( $proj_query->have_posts() ) :
							$proj_query->the_post();
							$_proj_title    = get_the_title();
							$_proj_ar_title = nsp_project_ar( $_proj_title, 'title' );
							$_loc_raw       = get_post_meta( get_the_ID(), '_nsp_project_location', true ) ?: 'Saudi Arabia';
							$_loc_display   = nsp_location_ar( $_loc_raw );
							?>
							<div class="clinox-slider-item-3">
								<div class="clinox-project-item-3 position-relative">
									<div class="inner-img">
										<?php $_project_pair = $proj_before_after[ $pi % count( $proj_before_after ) ]; ?>
										<div class="nsp-before-after" aria-label="<?php echo esc_attr( sprintf( nsp_t( 'Before and after view of %s', 'عرض قبل وبعد لـ %s' ), $_proj_ar_title ?: $_proj_title ) ); ?>">
											<img class="nsp-before-after__img nsp-before-after__img--before" src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/project/' . $_project_pair[0] ) ); ?>" alt="<?php echo esc_attr( sprintf( nsp_t( 'Before %s', 'قبل %s' ), $_proj_ar_title ?: $_proj_title ) ); ?>">
											<div class="nsp-before-after__after">
												<img class="nsp-before-after__img nsp-before-after__img--after" src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/project/' . $_project_pair[1] ) ); ?>" alt="<?php echo esc_attr( sprintf( nsp_t( 'After %s', 'بعد %s' ), $_proj_ar_title ?: $_proj_title ) ); ?>">
											</div>
											<span class="nsp-before-after__label nsp-before-after__label--before"><?php nsp_te( 'Before', 'قبل' ); ?></span>
											<span class="nsp-before-after__label nsp-before-after__label--after"><?php nsp_te( 'After', 'بعد' ); ?></span>
											<span class="nsp-before-after__divider" aria-hidden="true"></span>
										</div>
									</div>
									<div class="inner-text headline">
										<span><a href="#"><?php echo esc_html( $_loc_display ); ?></a></span>
										<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_proj_ar_title ?: $_proj_title ); ?></a></h3>
										<a class="read-more-btn d-flex align-items-center justify-content-center" href="<?php the_permalink(); ?>"><i class="fal fa-long-arrow-right nsp-flip-rtl"></i></a>
									</div>
								</div>
							</div>
							<?php $pi++; endwhile;
						wp_reset_postdata();
					else :
						// Fallback to static images
						$proj_static = [
							[ 'pro1-before.jpeg', 'pro1-after.jpeg', nsp_t( 'Pest Control Services', 'خدمات مكافحة الحشرات' ) ],
							[ 'pro2-before.jpeg', 'pro2-after.jpeg', nsp_t( 'Office & House Cleaning Services', 'تنظيف المكاتب والمنازل' ) ],
							[ 'pro3-before.jpeg', 'pro3-after.jpeg', nsp_t( 'AC Repairing & Cleaning Services', 'إصلاح وتنظيف المكيفات' ) ],
						];
						foreach ( $proj_static as $p ) :
						?>
						<div class="clinox-slider-item-3">
							<div class="clinox-project-item-3 position-relative">
								<div class="inner-img">
									<div class="nsp-before-after" aria-label="<?php echo esc_attr( sprintf( nsp_t( 'Before and after view of %s', 'عرض قبل وبعد لـ %s' ), $p[2] ) ); ?>">
										<img class="nsp-before-after__img nsp-before-after__img--before" src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/project/' . $p[0] ) ); ?>" alt="<?php echo esc_attr( sprintf( nsp_t( 'Before %s', 'قبل %s' ), $p[2] ) ); ?>">
										<div class="nsp-before-after__after">
											<img class="nsp-before-after__img nsp-before-after__img--after" src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/project/' . $p[1] ) ); ?>" alt="<?php echo esc_attr( sprintf( nsp_t( 'After %s', 'بعد %s' ), $p[2] ) ); ?>">
										</div>
										<span class="nsp-before-after__label nsp-before-after__label--before"><?php nsp_te( 'Before', 'قبل' ); ?></span>
										<span class="nsp-before-after__label nsp-before-after__label--after"><?php nsp_te( 'After', 'بعد' ); ?></span>
										<span class="nsp-before-after__divider" aria-hidden="true"></span>
									</div>
								</div>
								<div class="inner-text headline">
									<span><a href="#"><?php nsp_te( 'Eastern Province, KSA', 'المنطقة الشرقية، المملكة العربية السعودية' ); ?></a></span>
									<h3><a href="<?php echo esc_url( nsp_post_type_archive_url( 'project', 'projects' ) ); ?>"><?php echo esc_html( $p[2] ); ?></a></h3>
									<a class="read-more-btn d-flex align-items-center justify-content-center" href="<?php echo esc_url( nsp_post_type_archive_url( 'project', 'projects' ) ); ?>"><i class="fal fa-long-arrow-right nsp-flip-rtl"></i></a>
								</div>
							</div>
						</div>
						<?php endforeach; endif; ?>
				</div>
			</div>
		</div>
	</section>
	<!-- End of Project section
	============================================= -->

	<!-- Start of Testimonial section
	============================================= -->
	<section id="clinox-testimonial-3" class="clinox-testimonial-section-3"
		data-background="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/tst-bg.jpg' ) ); ?>">
		<div class="container">
			<div class="clinox-testimonial-content-3">
				<div class="row">
					<div class="col-lg-6">
						<div class="clenfix-testi-img-wrap-3 position-relative">
							<div class="inner-img wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
								<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/tst1.jpg' ) ); ?>" alt="">
							</div>
							<div class="inner-circle position-absolute">
								<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/tst-cir.png' ) ); ?>" alt="">
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="clinox-testimonial-text-wrap-3">
							<div class="clinox-section-title-3 headline pera-content wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
								<div class="subtitle text-uppercase"><?php nsp_te( 'Testimonials', 'آراء العملاء' ); ?></div>
								<h2><?php nsp_te( "What Our Clients Say About Us", 'ما يقوله عملاؤنا عنا' ); ?></h2>
							</div>
							<div class="clinox-testimonial-slider-wrap-3">
								<div class="clinox-testimonial-slider-3">
									<?php
									$testi_query = new WP_Query( [
										'post_type'      => 'testimonial',
										'posts_per_page' => 5,
										'post_status'    => 'publish',
										'no_found_rows'  => true,
									] );

									if ( $testi_query->have_posts() ) :
										while ( $testi_query->have_posts() ) :
											$testi_query->the_post();
											$_tst_name    = get_the_title();
											$_tst_ar_name = nsp_testimonial_ar( $_tst_name, 'name' );
											$_tst_ar_cont = nsp_testimonial_ar( $_tst_name, 'content' );
											$_tst_ar_role = nsp_testimonial_ar( $_tst_name, 'role' );
											$role         = $_tst_ar_role ?: get_post_meta( get_the_ID(), '_nsp_testimonial_role', true );
											$rating       = (int) get_post_meta( get_the_ID(), '_nsp_testimonial_rating', true ) ?: 5;
											?>
											<div class="clenfix-testimonial-item-3">
												<div class="clenfix-testimonial-item-wrap-3 position-relative">
													<div class="inner-text">
														<div class="inner-top d-flex justify-content-between align-items-center">
															<div class="quote-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/ic11.png' ) ); ?>" alt=""></div>
															<?php nsp_star_rating( $rating ); ?>
														</div>
														<div class="inner-decs"><?php echo $_tst_ar_cont ? esc_html( $_tst_ar_cont ) : wp_kses_post( get_the_content() ); ?></div>
													</div>
													<div class="inner-img">
														<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'thumbnail' );
														else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/tst1.jpg' ) ); ?>" alt=""><?php endif; ?>
													</div>
												</div>
												<div class="inner-author headline">
													<h3><?php echo esc_html( $_tst_ar_name ?: $_tst_name ); ?></h3>
													<span><?php echo esc_html( $role ); ?></span>
												</div>
											</div>
											<?php
										endwhile;
										wp_reset_postdata();
									else :
										// Static fallback
										for ( $t = 0; $t < 2; $t++ ) :
										?>
										<div class="clenfix-testimonial-item-3">
											<div class="clenfix-testimonial-item-wrap-3 position-relative">
												<div class="inner-text">
													<div class="inner-top d-flex justify-content-between align-items-center">
														<div class="quote-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/ic11.png' ) ); ?>" alt=""></div>
														<?php nsp_star_rating( 5 ); ?>
													</div>
													<div class="inner-decs"><?php nsp_te( 'I have always been active member of the community but always felt like I could do so much more. Great cleaning service!', 'خدمة تنظيف ممتازة! الفريق كان محترفاً ودقيقاً في العمل. أوصي بشدة بخدماتهم لكل منزل وشركة.' ); ?></div>
												</div>
												<div class="inner-img"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/tst1.jpg' ) ); ?>" alt=""></div>
											</div>
											<div class="inner-author headline">
												<h3><?php nsp_te( 'Harbajan Sing', 'عبدالله الحربي' ); ?></h3>
												<span><?php nsp_te( 'CEO, Gatko', 'مدير عام، شركة الخليج' ); ?></span>
											</div>
										</div>
										<?php endfor; endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End of Testimonial section
	============================================= -->

	<!-- Start of Blog section
	============================================= -->
	<section id="clinox-blog-3" class="clinox-blog-section-3">
		<div class="container">
			<div class="clinox-blog-top-content-3 d-flex justify-content-between align-items-center">
				<div class="clinox-section-title-3 headline pera-content wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
					<div class="subtitle text-uppercase"><?php nsp_te( 'Latest Blog', 'أحدث المقالات' ); ?></div>
					<h2><?php nsp_te( "Let's Discover Our Latest News & Articles", 'اكتشف أحدث أخبارنا ومقالاتنا' ); ?></h2>
				</div>
			</div>
			<div class="clinox-blog-content-3">
				<div class="row justify-content-center">
					<?php
					$blog_query = new WP_Query( [
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'post_status'    => 'publish',
						'no_found_rows'  => true,
					] );
					$blog_imgs = [ 'blg1.jpg', 'blg2.jpg', 'blg3.jpg' ];
					$bi = 0;
					if ( $blog_query->have_posts() ) :
						while ( $blog_query->have_posts() ) :
							$blog_query->the_post();
							$delay = ( $bi + 4 ) . '00ms';
							?>
							<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>" data-wow-duration="1500ms">
								<div class="clinox-blog-item-3 position-relative">
									<?php
									$_blog_title = get_the_title();
									$_blog_ar    = nsp_get_post_ar( get_the_ID(), 'title' );
									$_blog_label = $_blog_ar ?: ( nsp_is_arabic() ? nsp_missing_post_ar_text( 'title' ) : $_blog_title );
									?>
									<div class="inner-img">
										<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'nsp-blog-feed', [ 'alt' => $_blog_label ] );
										else : ?><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/blog/' . $blog_imgs[ $bi % 3 ] ) ); ?>" alt="<?php echo esc_attr( $_blog_label ); ?>"><?php endif; ?>
									</div>
									<div class="inner-text headline">
										<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $_blog_label ); ?></a></h3>
										<div class="blog-meta">
											<a href="<?php the_permalink(); ?>"><i class="fal fa-calendar-check"></i> <?php echo esc_html( nsp_get_the_date() ); ?></a>
											<a href="<?php the_permalink(); ?>"><i class="far fa-user"></i> <?php echo esc_html( get_the_author() ); ?></a>
										</div>
										<div class="read-more-btn">
											<a class="d-flex justify-content-center align-items-center" href="<?php the_permalink(); ?>"><?php nsp_te( 'Read More', 'اقرأ المزيد' ); ?></a>
										</div>
									</div>
								</div>
							</div>
							<?php $bi++;
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- End of Blog section
	============================================= -->

	<!-- Start of sponsor section
	============================================= -->
	<?php get_template_part( 'template-parts/sections/sponsor' ); ?>
	<!-- End of sponsor section
	============================================= -->

</main>
<?php get_footer(); ?>
