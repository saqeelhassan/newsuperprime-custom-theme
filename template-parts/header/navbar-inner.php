<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!-- Start of header section
============================================= -->
<header id="clinox-header" class="clinox-header-section  header-style-one">
	<div class="clinox-header-top-wrap">
		<div class="container">
			<div class="clinox-header-top-content d-flex align-items-center justify-content-between">
				<div class="top-info ul-li">
					<ul>
						<li><i class="fal fa-phone-alt"></i><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>, <?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></li>
						<li><i class="far fa-envelope"></i> <?php echo esc_html( get_theme_mod( 'nsp_email', 'info@newsuperprime.sa' ) ); ?></li>
					</ul>
				</div>
				<div class="top-social-btn d-flex align-items-center">
					<div class="top-social ul-li">
						<ul>
							<?php nsp_social_links_html( true ); ?>
						</ul>
					</div>
					<div class="top-btn">
						<a class="d-flex justify-content-center align-items-center" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php nsp_te( 'GET A QUOTE', 'احصل على عرض سعر' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clinox-header-logo-cta">
		<div class="container">
			<div class="clinox-header-logo-cta-content d-flex">
				<div class="brand-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php nsp_site_logo(); ?></a>
				</div>
				<div class="header-cta-wrapper d-flex justify-content-between">
					<div class="header-info-item d-flex align-items-center position-relative">
						<div class="hd-item-icon">
							<i class="fal fa-map-marker-alt"></i>
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
							<i class="fal fa-envelope"></i>
						</div>
						<div class="hd-item-meta">
							<label><?php nsp_te( 'Email us', 'راسلنا' ); ?></label>
							<span><?php echo esc_html( get_theme_mod( 'nsp_email', 'info@newsuperprime.sa' ) ); ?></span>
						</div>
					</div>
					<div class="header-info-item d-flex align-items-center position-relative">
						<div class="hd-item-icon">
							<i class="fal fa-phone-alt"></i>
						</div>
						<div class="hd-item-meta">
							<label><?php nsp_te( 'Free Call', 'اتصل مجاناً' ); ?></label>
							<span><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>, <?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></span>
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
						<button class="search-box-outer"><i class="far fa-search"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile_menu">
		<div class="mobile_menu_button open_mobile_menu">
			<i class="fal fa-bars"></i>
		</div>
		<div class="mobile_menu_wrap">
			<div class="mobile_menu_overlay open_mobile_menu"></div>
			<div class="mobile_menu_content">
				<div class="mobile_menu_close open_mobile_menu">
					<i class="fal fa-times"></i>
				</div>
				<div class="m-brand-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php nsp_site_logo(); ?></a>
				</div>
				<nav class="mobile-main-navigation  clearfix ul-li">
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
	<button class="close-search style-two"><span class="fal fa-times"></span></button>
	<button class="close-search"><span class="fa fa-arrow-up"></span></button>
	<?php get_search_form(); ?>
</div>
<!-- End of header section
============================================= -->
