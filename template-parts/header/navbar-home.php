<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!-- Start of header section
============================================= -->
<header id="clinox-header" class="clinox-header-section header-style-three home-sticky-header">
	<div class="clinox-header-logo-cta">
		<div class="container">
			<div class="clinox-header-logo-cta-content d-flex">
				<div class="brand-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php nsp_site_logo(); ?></a>
				</div>
				<div class="header-cta-wrapper d-flex justify-content-between">
					<div class="header-info-item d-flex align-items-center position-relative">
						<div class="hd-item-icon">
							<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/pin.png' ) ); ?>" alt="">
						</div>
						<div class="hd-item-meta">
							<label><?php nsp_te( 'Contact us', 'تواصل معنا' ); ?></label>
							<span><?php echo esc_html( nsp_t(
								get_theme_mod( 'nsp_address',    'Building Number 7461, Hamza Street, PO Box 4161, Aladama Dist, Dammam 32242, Kingdom Of Saudi Arabia' ),
								get_theme_mod( 'nsp_address_ar', 'المبنى رقم 7461، شارع حمزة، ص.ب 4161، حي الأداما، الدمام 32242، المملكة العربية السعودية' )
							) ); ?></span>
						</div>
					</div>
					<div class="header-info-item d-flex align-items-center position-relative">
						<div class="hd-item-icon">
							<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/mail.png' ) ); ?>" alt="">
						</div>
						<div class="hd-item-meta">
							<label><?php nsp_te( 'Email us', 'راسلنا' ); ?></label>
							<span class="nsp-header-email" dir="ltr"><a href="mailto:<?php echo esc_attr( sanitize_email( get_theme_mod( 'nsp_email', 'info@newsuperprime.sa' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_email', 'info@newsuperprime.sa' ) ); ?></a></span>
						</div>
					</div>
					<div class="header-info-item d-flex align-items-center position-relative">
						<div class="hd-item-icon">
							<img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/call.png' ) ); ?>" alt="">
						</div>
						<div class="hd-item-meta">
							<label><?php nsp_te( 'Free Call', 'اتصل مجاناً' ); ?></label>
							<div class="nsp-header-phones" dir="ltr">
                                <?php foreach ( [ get_theme_mod( 'nsp_phone1', '+966 593657772' ), get_theme_mod( 'nsp_phone2', '+966 559357772' ) ] as $header_phone ) : ?>
                                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $header_phone ) ); ?>"><?php echo esc_html( $header_phone ); ?></a>
                                <?php endforeach; ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-navigation-content-wrapper">
		<div class="container">
			<div class="header-navigation-content align-items-center d-flex justify-content-between">
				<div class="sticky-brand-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php nsp_site_logo(); ?></a>
				</div>
				<nav class="main-navigation clearfix ul-li">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_id'        => 'main-nav',
						'menu_class'     => 'nav navbar-nav clearfix',
						'container'      => false,
						'walker'         => new NSP_Nav_Walker(),
						'fallback_cb'    => false,
					] );
					?>
				</nav>
				<div class="header-cart-btn-search align-items-center d-flex">
					<?php nsp_language_switcher(); ?>
					<div class="h-search">
						<button type="button" class="search-box-outer" aria-label="<?php echo esc_attr( nsp_t( __( 'Search', 'newsuperprime' ), __( 'بحث', 'newsuperprime' ) ) ); ?>"><i class="far fa-search" aria-hidden="true"></i></button>
					</div>
					<div class="h-cta-btn">
                        <?php nsp_header_booking_button( nsp_t( 'Book Service', 'احجز خدمة' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile_menu">
		<button type="button" class="mobile_menu_button open_mobile_menu" aria-label="<?php echo esc_attr( nsp_t( __( 'Open menu', 'newsuperprime' ), __( 'فتح القائمة', 'newsuperprime' ) ) ); ?>">
			<i class="fal fa-bars" aria-hidden="true"></i>
		</button>
		<div class="mobile_menu_wrap">
			<div class="mobile_menu_overlay open_mobile_menu"></div>
			<div class="mobile_menu_content">
				<button type="button" class="mobile_menu_close open_mobile_menu" aria-label="<?php echo esc_attr( nsp_t( __( 'Close menu', 'newsuperprime' ), __( 'إغلاق القائمة', 'newsuperprime' ) ) ); ?>">
					<i class="fal fa-times" aria-hidden="true"></i>
				</button>
				<div class="m-brand-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php nsp_site_logo(); ?></a>
				</div>
				<nav class="mobile-main-navigation clearfix ul-li">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_id'        => 'm-main-nav',
						'menu_class'     => 'nav navbar-nav clearfix',
						'container'      => false,
						'walker'         => new NSP_Nav_Walker(),
						'fallback_cb'    => false,
					] );
					?>
				</nav>
				<?php nsp_language_switcher(); ?>
			</div>
		</div>
		<!-- /Mobile-Menu -->
	</div>
</header>
<!-- Search PopUp -->
<div class="search-popup">
	<button type="button" class="close-search style-two" aria-label="<?php echo esc_attr( nsp_t( __( 'Close search', 'newsuperprime' ), __( 'إغلاق البحث', 'newsuperprime' ) ) ); ?>"><span class="fal fa-times" aria-hidden="true"></span></button>
	<button type="button" class="close-search" aria-label="<?php echo esc_attr( nsp_t( __( 'Close search', 'newsuperprime' ), __( 'إغلاق البحث', 'newsuperprime' ) ) ); ?>"><span class="fa fa-arrow-up" aria-hidden="true"></span></button>
	<?php get_search_form(); ?>
</div>
<!-- End of header section
============================================= -->
