<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<section id="clinox-contact" class="clinox-contact-section-3">
	<div class="container">
		<div class="clinox-contact-content">
			<div class="row">
				<div class="col-lg-6">
					<div class="clinox-contact-form-wrap">
						<div class="clinox-section-title headline pera-content">
							<span class="sub-title"><?php nsp_te( 'Contact Us', 'تواصل معنا' ); ?></span>
							<h2><?php nsp_te( 'Get In Touch', 'تواصل معنا' ); ?></h2>
						</div>
						<div class="clinox-contact-form">
							<?php
							$nsp_service_form_sc = isset( $nsp_service_form_sc ) ? $nsp_service_form_sc : '';
							$cf7_id              = get_option( 'nsp_cf7_contact_id', 0 );
							if ( $nsp_service_form_sc ) {
								echo do_shortcode( $nsp_service_form_sc );
							} elseif ( function_exists( 'wpcf7' ) && $cf7_id ) {
								echo do_shortcode( '[contact-form-7 id="' . absint( $cf7_id ) . '" title="Contact Form"]' );
							} else {
								?>
								<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
									<div class="row">
										<div class="col-md-6"><input type="text" name="name" placeholder="<?php nsp_ta( 'Name', 'الاسم' ); ?>"></div>
										<div class="col-md-6"><input type="email" name="email" placeholder="<?php nsp_ta( 'Email', 'البريد الإلكتروني' ); ?>"></div>
										<div class="col-md-6"><input type="text" name="phone" placeholder="<?php nsp_ta( 'Phone', 'الهاتف' ); ?>"></div>
										<div class="col-md-6">
											<div class="service-select position-relative">
												<select name="service">
													<option value=""><?php nsp_te( 'Service', 'الخدمة' ); ?></option>
													<?php foreach ( nsp_get_services() as $svc ) : ?>
														<option value="<?php echo esc_attr( $svc['slug'] ); ?>"><?php echo esc_html( nsp_service_ar( $svc['title'], 'title' ) ?: $svc['title'] ); ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-md-12"><textarea name="message" placeholder="<?php nsp_ta( 'Message', 'رسالتك' ); ?>"></textarea></div>
									</div>
									<button type="submit"><?php nsp_te( 'Submit Now', 'إرسال الآن' ); ?></button>
								</form>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="clinox-contact-info-wrap headline">
						<h3><?php nsp_te( 'Contact Info', 'معلومات التواصل' ); ?></h3>
						<div class="clinox-contact-info">
							<div class="row">
								<div class="col-md-6">
									<div class="contact-info-item d-flex">
										<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/ic15.png' ) ); ?>" alt=""></div>
										<div class="inner-text">
											<h4><?php nsp_te( 'Office Address:', 'عنوان المكتب:' ); ?></h4>
											<span><?php echo esc_html( get_theme_mod( 'nsp_address', 'Building Number 7461, Hamza Street, PO Box 4161, Aladama Dist, Dammam 32242, Kingdom Of Saudi Arabia' ) ); ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="contact-info-item d-flex">
										<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/ic16.png' ) ); ?>" alt=""></div>
										<div class="inner-text">
											<h4><?php nsp_te( 'Mail Us', 'راسلنا' ); ?></h4>
											<span><?php echo esc_html( get_theme_mod( 'nsp_email', 'info@newsuperprime.sa' ) ); ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="contact-info-item d-flex">
										<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/ic17.png' ) ); ?>" alt=""></div>
										<div class="inner-text">
											<h4><?php nsp_te( 'Telephone', 'الهاتف' ); ?></h4>
											<span><a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone1', '+966 593657772' ) ); ?></a></span>
											<span><a href="tel:<?php echo esc_attr( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nsp_phone2', '+966 559357772' ) ); ?></a></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="contact-info-item d-flex">
										<div class="inner-icon"><img src="<?php echo esc_url( nsp_asset( 'assets/img/img-5/icon/ic18.png' ) ); ?>" alt=""></div>
										<div class="inner-text">
											<h4><?php nsp_te( 'Opening Hour', 'ساعات العمل' ); ?></h4>
											<span><?php echo esc_html( get_theme_mod( 'nsp_opening_hours', '10.00pm - 08.00am, Friday Off' ) ); ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="contact-map">
							<?php
							$map_address = urlencode( get_theme_mod( 'nsp_address', 'Building Number 7461, Hamza Street, Aladama District, Dammam, Saudi Arabia' ) );
							$map_src     = 'https://maps.google.com/maps?q=' . $map_address . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
							?>
							<iframe
								src="<?php echo esc_url( $map_src ); ?>"
								width="100%"
								height="350"
								style="border:0;"
								allowfullscreen=""
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								title="<?php nsp_ta( 'Our Location', 'موقعنا' ); ?>"
							></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
