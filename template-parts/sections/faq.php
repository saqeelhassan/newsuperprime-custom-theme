<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section id="clinox-faq-3" class="clinox-faq-section-3 position-relative">
	<span class="clinox-fq-sidebg position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/faq-bg.jpg' ) ); ?>" alt=""></span>
	<span class="clinox-fq-sidebg2 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/side-sh3.png' ) ); ?>" alt=""></span>
	<div class="container">
		<div class="clinox-faq-content-3">
			<div class="row">
				<div class="col-lg-6">
					<div class="clinox-faq-img-3 position-relative">
						<span class="wc-shape1 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/dot-sh2.png' ) ); ?>" alt=""></span>
						<span class="wc-shape2 position-absolute wow fadeInUp" data-wow-delay="500ms" data-wow-duration="1500ms"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/shape/sq-sh3.png' ) ); ?>" alt=""></span>
						<div class="inner-img wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
							<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/about/fq.jpg' ) ); ?>" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="clinox-faq-text-wrapper-3">
						<div class="clinox-section-title-3 headline pera-content wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
							<div class="subtitle text-uppercase"><?php nsp_te( 'Any Question', 'هل لديك سؤال؟' ); ?></div>
							<h2><?php nsp_te( 'You Can Depend On Us Get a Good Services', 'يمكنك الاعتماد علينا للحصول على خدمات متميزة' ); ?></h2>
						</div>
						<div class="clinox-faq-accordion-3">
							<div class="accordion" id="accordionHomeFaq">
								<?php
								$faq_query = new WP_Query( [
									'post_type'      => 'faq',
									'posts_per_page' => 4,
									'post_status'    => 'publish',
									'no_found_rows'  => true,
								] );

								if ( $faq_query->have_posts() ) :
									$fi = 0;
									while ( $faq_query->have_posts() ) :
										$faq_query->the_post();
										$uid      = 'faqHome' . $fi;
										$expanded = ( 0 === $fi ) ? 'true' : 'false';
										$show     = ( 0 === $fi ) ? 'show' : '';
										$collapsed = ( 0 === $fi ) ? '' : ' collapsed';
										?>
										<div class="accordion-item headline pera-content wow fadeInUp" data-wow-delay="<?php echo esc_attr( ( $fi + 2 ) . '00ms' ); ?>" data-wow-duration="1500ms">
											<h2 class="accordion-header" id="heading<?php echo esc_attr( $uid ); ?>">
												<button class="accordion-button<?php echo esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse"
													data-bs-target="#collapse<?php echo esc_attr( $uid ); ?>" aria-expanded="<?php echo esc_attr( $expanded ); ?>">
													<?php
													$_faq_title = get_the_title();
													$_faq_ar_t  = nsp_faq_ar( $_faq_title, 'title' );
													echo esc_html( $_faq_ar_t ?: $_faq_title );
													?>
												</button>
											</h2>
											<div id="collapse<?php echo esc_attr( $uid ); ?>" class="accordion-collapse collapse <?php echo esc_attr( $show ); ?>"
												aria-labelledby="heading<?php echo esc_attr( $uid ); ?>" data-bs-parent="#accordionHomeFaq">
												<div class="accordion-body"><?php
													$_faq_ar_c = nsp_faq_ar( get_the_title(), 'content' );
													echo $_faq_ar_c ? esc_html( $_faq_ar_c ) : wp_kses_post( get_the_content() );
												?></div>
											</div>
										</div>
										<?php $fi++; endwhile;
									wp_reset_postdata();
								else :
									// Static fallback
									$faq_static = [
										[ nsp_t( 'Why Tile Polishing Matters', 'لماذا تلميع البلاط مهم؟' ), nsp_t( 'We denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot.', 'تلميع البلاط يُطيل عمره ويمنحه مظهراً جديداً ومشرقاً، كما يُسهل التنظيف اليومي ويحمي السطح من الخدوش.' ) ],
										[ nsp_t( 'Office, House, Mosque, Schools Cleaning', 'تنظيف المكاتب والمنازل والمساجد والمدارس' ), nsp_t( 'We denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot.', 'نقدم خدمات تنظيف شاملة لجميع أنواع المباني باستخدام معدات متطورة وفريق مدرب على أعلى مستوى.' ) ],
										[ nsp_t( 'Car Detailing Services', 'خدمات تلميع السيارات' ), nsp_t( 'We denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot.', 'خدمات تلميع السيارات تشمل التنظيف الداخلي والخارجي الشامل مع الحماية بالشمع لإبراز بريق سيارتك.' ) ],
									];
									foreach ( $faq_static as $fi => $faq ) :
										$uid      = 'faqHomeS' . $fi;
										$expanded = ( 0 === $fi ) ? 'true' : 'false';
										$show     = ( 0 === $fi ) ? 'show' : '';
										$collapsed = ( 0 === $fi ) ? '' : ' collapsed';
										?>
										<div class="accordion-item headline pera-content wow fadeInUp" data-wow-delay="<?php echo esc_attr( ( $fi + 2 ) . '00ms' ); ?>" data-wow-duration="1500ms">
											<h2 class="accordion-header" id="heading<?php echo esc_attr( $uid ); ?>">
												<button class="accordion-button<?php echo esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse"
													data-bs-target="#collapse<?php echo esc_attr( $uid ); ?>" aria-expanded="<?php echo esc_attr( $expanded ); ?>">
													<?php echo esc_html( $faq[0] ); ?>
												</button>
											</h2>
											<div id="collapse<?php echo esc_attr( $uid ); ?>" class="accordion-collapse collapse <?php echo esc_attr( $show ); ?>"
												aria-labelledby="heading<?php echo esc_attr( $uid ); ?>" data-bs-parent="#accordionHomeFaq">
												<div class="accordion-body"><?php echo esc_html( $faq[1] ); ?></div>
											</div>
										</div>
									<?php endforeach; endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
