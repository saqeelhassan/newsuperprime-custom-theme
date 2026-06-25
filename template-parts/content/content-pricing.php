<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section id="clinox-price-3" class="clinox-price-section-3"
	data-background="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/price-bg.jpg' ) ); ?>">
	<div class="container">
		<div class="clinox-section-title-3 text-center headline pera-content wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
			<div class="subtitle text-uppercase"><?php nsp_te( 'Our pricing', 'أسعارنا' ); ?></div>
			<h2><?php nsp_te( 'Combine the Services You Need in One Booking', 'اجمع الخدمات التي تحتاجها في حجز واحد' ); ?></h2>
		</div>
		<div class="clinox-price-content-3">
			<div class="row justify-content-center">
				<?php
				$combo_pricing_defaults = [
					'basic plan' => [
						'title'    => nsp_t( 'One Service', 'خدمة واحدة' ),
						'price'    => 'SAR 499',
						'period'   => nsp_t( 'Per Booking', 'لكل حجز' ),
						'features' => [
							nsp_t( 'Choose any one cleaning service', 'اختر أي خدمة تنظيف واحدة' ),
							nsp_t( 'Fixed quote before work starts', 'عرض سعر واضح قبل بدء العمل' ),
							nsp_t( 'Single team visit', 'زيارة واحدة من الفريق' ),
							nsp_t( 'Book when needed, no membership', 'احجز عند الحاجة بدون اشتراك' ),
						],
					],
					'standard plan' => [
						'title'    => nsp_t( 'Add More Services', 'أضف خدمات أكثر' ),
						'price'    => 'SAR 999',
						'period'   => nsp_t( 'Per Booking', 'لكل حجز' ),
						'features' => [
							nsp_t( 'Combine any 2 to 3 services', 'اجمع من خدمتين إلى ثلاث خدمات' ),
							nsp_t( 'Better value than separate bookings', 'قيمة أفضل من الحجوزات المنفصلة' ),
							nsp_t( 'Coordinated same-day schedule', 'تنسيق الخدمات في نفس اليوم' ),
							nsp_t( 'One invoice for all services', 'فاتورة واحدة لكل الخدمات' ),
						],
					],
					'premium plan' => [
						'title'    => nsp_t( 'All Services Bundle', 'باقة كل الخدمات' ),
						'price'    => 'SAR 1499',
						'period'   => nsp_t( 'Per Booking', 'لكل حجز' ),
						'features' => [
							nsp_t( 'Add all required services together', 'أضف كل الخدمات المطلوبة معاً' ),
							nsp_t( 'Whole home or office solution', 'حل كامل للمنزل أو المكتب' ),
							nsp_t( 'Priority scheduling', 'أولوية في تحديد الموعد' ),
							nsp_t( 'Custom scope after inspection', 'نطاق عمل مخصص بعد المعاينة' ),
						],
					],
				];

				$pricing_query = new WP_Query( [
					'post_type'      => 'pricing',
					'posts_per_page' => 3,
					'post_status'    => 'publish',
					'no_found_rows'  => true,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				] );

				$price_delays = [ '400ms', '400ms', '600ms' ];
				$pr_bgs       = [ 'pr-bg.png', 'pr-bg2.png', 'pr-bg.png' ];

				if ( $pricing_query->have_posts() ) :
					$pi = 0;
					while ( $pricing_query->have_posts() ) :
						$pricing_query->the_post();
						$price    = get_post_meta( get_the_ID(), '_nsp_pricing_price',    true );
						$features = get_post_meta( get_the_ID(), '_nsp_pricing_features', true );
						$cta_url  = get_post_meta( get_the_ID(), '_nsp_pricing_cta_url',  true ) ?: home_url( '/contact/' );
						$featured = get_post_meta( get_the_ID(), '_nsp_pricing_featured', true );
						$active   = $featured ? ' active' : '';
						$feat_lines = $features ? array_filter( array_map( 'trim', explode( "\n", $features ) ) ) : [];
						?>
						<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $price_delays[ $pi % 3 ] ); ?>" data-wow-duration="1500ms">
							<div class="clinox-price-item-3 text-center<?php echo esc_attr( $active ); ?>">
								<div class="inner-tittle headline pera-content">
									<?php
									$_plan_title = get_the_title();
									$_legacy_key = strtolower( trim( $_plan_title ) );
									if ( isset( $combo_pricing_defaults[ $_legacy_key ] ) ) {
										$_combo      = $combo_pricing_defaults[ $_legacy_key ];
										$_plan_title = $_combo['title'];
										$_plan_price = $_combo['price'];
										$_plan_label = $_combo['period'];
										$feat_lines  = $_combo['features'];
									} else {
										$_plan_price = nsp_pricing_sar( $_plan_title, $price );
										$_plan_label = nsp_t( 'Per Booking', 'لكل حجز' );
									}
									?>
									<h3>- <?php echo esc_html( nsp_pricing_ar( $_plan_title, 'title' ) ?: $_plan_title ); ?> -</h3>
									<span class="cl-price"><?php echo esc_html( $_plan_price ); ?></span>
									<span class="cl-price-plan"><?php echo esc_html( $_plan_label ); ?></span>
								</div>
								<div class="inner-list ul-li-block" data-background="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/' . $pr_bgs[ $pi % 3 ] ) ); ?>">
									<ul>
										<?php foreach ( $feat_lines as $feat ) : ?>
											<li><?php echo esc_html( nsp_pricing_ar( $feat, 'feature' ) ?: $feat ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
								<div class="inner-btn d-flex justify-content-center">
									<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( $cta_url ); ?>"><?php nsp_te( 'Get Started', 'ابدأ الآن' ); ?></a>
								</div>
							</div>
						</div>
						<?php $pi++; endwhile;
					wp_reset_postdata();
				else :
					// Static fallback
					$price_static = array_values( $combo_pricing_defaults );
					foreach ( $price_static as $pi => $plan ) :
					?>
					<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $price_delays[ $pi ] ); ?>" data-wow-duration="1500ms">
						<div class="clinox-price-item-3 text-center<?php echo esc_attr( 1 === $pi ? ' active' : '' ); ?>">
							<div class="inner-tittle headline pera-content">
								<h3>- <?php echo esc_html( $plan['title'] ); ?> -</h3>
								<span class="cl-price"><?php echo esc_html( $plan['price'] ); ?></span>
								<span class="cl-price-plan"><?php echo esc_html( $plan['period'] ); ?></span>
							</div>
							<div class="inner-list ul-li-block" data-background="<?php echo esc_url( nsp_asset( 'assets/img/img-5/bg/' . $pr_bgs[ $pi ] ) ); ?>">
								<ul>
									<?php foreach ( $plan['features'] as $feat ) : ?>
										<li><?php echo esc_html( $feat ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="inner-btn d-flex justify-content-center">
								<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php nsp_te( 'Get Started', 'ابدأ الآن' ); ?></a>
							</div>
						</div>
					</div>
					<?php endforeach; endif; ?>
			</div>
		</div>
	</div>
</section>
