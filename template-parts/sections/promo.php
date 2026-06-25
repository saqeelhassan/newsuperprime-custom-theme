<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section id="clinox-promo" class="clinox-promo-section position-relative" data-background="<?php echo esc_url( nsp_asset( 'assets/img/bg/promo-bg.jpg' ) ); ?>">
	<div class="banner-shape position-absolute"><img src="<?php echo esc_url( nsp_asset( 'assets/img/banner/banner-bg2.png' ) ); ?>" alt=""></div>
	<div class="container">
		<div class="clinox-promo-content position-relative">
			<div class="clinox-section-title headline pera-content">
				<span class="sub-title"><?php nsp_te( "Let's Talk", 'دعنا نتحدث' ); ?></span>
				<h2><?php echo esc_html( nsp_t(
					get_theme_mod( 'nsp_cta_headline',    "Get Our Services, It's Affordable Save Time & Save Money." ),
					get_theme_mod( 'nsp_cta_headline_ar', 'احصل على خدماتنا بأسعار معقولة. وفر وقتك وأموالك.' )
				) ); ?></h2>
			</div>
			<div class="banner-btn-wrapper d-flex align-items-center">
				<div class="banner-btn">
					<a class="d-flex justify-content-center align-items-center" href="<?php echo esc_url( get_theme_mod( 'nsp_cta_button_url', home_url( '/contact/' ) ) ); ?>">
						<span><?php nsp_te( 'Get An Estimate', 'احصل على تقدير' ); ?></span>
					</a>
				</div>
				<div class="banener-cta d-flex align-items-center">
					<span><?php nsp_te( 'or', 'أو' ); ?></span>
					<span dir="ltr" class="promo-phones">
						<a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?></a>,
						<a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></a>
					</span>
				</div>
			</div>
		</div>
	</div>
</section>
