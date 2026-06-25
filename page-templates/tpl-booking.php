<?php
/**
 * Template Name: Booking Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Online Booking', 'الحجز الإلكتروني' ) );
?>

<!-- Start of Booking section
============================================= -->
<section id="clinox-booking" class="clinox-booking-section page-section-padding">
	<div class="container">
		<div class="clinox-booking-content">
			<div class="row">
				<div class="col-lg-6">
					<div class="clinox-booking-img">
						<img src="<?php echo esc_url( nsp_asset( 'assets/img/about/bk1.jpg' ) ); ?>" alt="">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="clinox-booking-form-wrap">
						<div class="clinox-section-title headline pera-content">
							<span class="sub-title"><?php nsp_te( 'Online Booking', 'الحجز الإلكتروني' ); ?></span>
							<h2><?php nsp_te( 'Book Our Services', 'احجز خدماتنا' ); ?></h2>
						</div>
						<div class="clinox-booking-form clinox-contact-form">
							<?php
							$cf7_id = get_option( 'nsp_cf7_booking_id', 0 );
							if ( function_exists( 'wpcf7' ) && $cf7_id ) :
								echo do_shortcode( '[contact-form-7 id="' . absint( $cf7_id ) . '" title="Booking Form"]' );
							else :
							?>
							<form action="<?php echo esc_url( home_url( '/contact/' ) ); ?>" method="get">
								<div class="row">
									<div class="col-md-6"><input type="text" name="name" placeholder="<?php nsp_ta( 'Name', 'الاسم' ); ?>"></div>
									<div class="col-md-6"><input type="email" name="email" placeholder="<?php nsp_ta( 'Email', 'البريد الإلكتروني' ); ?>"></div>
									<div class="col-md-6"><input type="text" name="phone" placeholder="<?php nsp_ta( 'Phone', 'الهاتف' ); ?>"></div>
									<div class="col-md-6">
										<div class="service-select position-relative">
											<select name="service">
												<option value=""><?php nsp_te( 'Select Service', 'اختر الخدمة' ); ?></option>
												<?php foreach ( nsp_get_services() as $svc ) : ?>
													<option value="<?php echo esc_attr( $svc['slug'] ); ?>"><?php echo esc_html( nsp_service_ar( $svc['title'], 'title' ) ?: $svc['title'] ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-12"><textarea name="message" placeholder="<?php nsp_ta( 'Message', 'الرسالة' ); ?>"></textarea></div>
								</div>
								<button type="submit"><?php nsp_te( 'Submit Now', 'إرسال' ); ?></button>
							</form>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of Booking section
============================================= -->

<!-- Start of Booking Contact Info section
============================================= -->
<section id="clinox-booking-contact" class="clinox-booking-contact-section">
	<div class="container">
		<div class="clinox-booking-contact-content">
			<div class="row">
				<div class="col-lg-4">
					<div class="booking-contact-item d-flex align-items-center">
						<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/icon/ic15.png' ) ); ?>" alt=""></div>
						<div class="inner-text headline">
							<h4><?php nsp_te( 'Office Address', 'عنوان المكتب' ); ?></h4>
							<span><?php echo esc_html( nsp_t(
								get_theme_mod( 'nsp_address', 'Building Number 7461, Hamza Street, PO Box 4161, Aladama Dist, Dammam 32242, Kingdom Of Saudi Arabia' ),
								get_theme_mod( 'nsp_address_ar', 'المبنى رقم 7461، شارع حمزة، صندوق بريد 4161، حي الأداما، الدمام 32242، المملكة العربية السعودية' )
							) ); ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="booking-contact-item d-flex align-items-center">
						<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/icon/ic16.png' ) ); ?>" alt=""></div>
						<div class="inner-text headline">
							<h4><?php nsp_te( 'Email Us', 'راسلنا' ); ?></h4>
							<span><?php echo esc_html( get_theme_mod( 'nsp_email', 'info@newsuperprime.sa' ) ); ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="booking-contact-item d-flex align-items-center">
						<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/icon/ic17.png' ) ); ?>" alt=""></div>
						<div class="inner-text headline">
							<h4><?php nsp_te( 'Telephone', 'الهاتف' ); ?></h4>
							<span><a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?></a></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End of Booking Contact Info section
============================================= -->

<?php get_footer(); ?>
