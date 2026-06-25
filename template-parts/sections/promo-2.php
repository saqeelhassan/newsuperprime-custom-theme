<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section id="clinox-promo-2" class="clinox-promo-section-2 position-relative">
	<div class="side-shape1 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/shape/side1.png' ) ); ?>" alt=""></div>
	<div class="side-shape2 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/shape/side2.png' ) ); ?>" alt=""></div>
	<div class="star-vector1 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/shape1.png' ) ); ?>" alt=""></div>
	<div class="star-vector2 position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/shape1.png' ) ); ?>" alt=""></div>
	<div class="container">
		<div class="clinox-promo-content-2 position-relative">
			<div class="clinox-section-title-2 text-center headline pera-content">
				<span class="sub-title text-uppercase"><?php nsp_te( 'We Are Best Cleaner', 'نحن الأفضل في التنظيف' ); ?></span>
				<h2><?php echo esc_html( get_theme_mod( 'nsp_cta_headline', "Get Our Services, It's Affordable Save Time. Save Money." ) ); ?></h2>
			</div>
			<div class="banner-btn-wrapper d-flex justify-content-center align-items-center">
				<div class="banner-btn">
					<a class="d-flex justify-content-center align-items-center" href="<?php echo esc_url( get_theme_mod( 'nsp_cta_button_url', home_url( '/contact/' ) ) ); ?>">
						<span><?php nsp_te( 'Get An Estimate', 'احصل على تقدير' ); ?></span>
					</a>
				</div>
				<div class="banener-cta d-flex align-items-center">
					<span><?php nsp_te( 'or', 'أو' ); ?></span>
					<a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?></a>,
					<a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
