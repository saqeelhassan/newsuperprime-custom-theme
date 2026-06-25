<?php
/**
 * Template Name: Service - Car Wash
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Car Wash Service', 'خدمة غسيل السيارات' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Car-Wash-Service-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'Car Wash Service', 'خدمة غسيل السيارات' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'Mobile Car Wash Service', 'خدمة غسيل السيارات المتنقلة' ); ?></h2>
					<p><?php nsp_te( 'Our mobile car wash team comes to your location — home, office or anywhere — providing a thorough interior and exterior clean using premium products. No queues, no waiting.', 'يأتي فريق غسيل السيارات المتنقل إلى موقعك — المنزل أو المكتب أو أي مكان — لتقديم تنظيف داخلي وخارجي شامل باستخدام منتجات فاخرة. بدون طوابير ولا انتظار.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'Full exterior hand wash', 'غسيل خارجي كامل باليد' ); ?></li>
						<li><?php nsp_te( 'Interior vacuum and wipe-down', 'شفط الداخل ومسح الأسطح' ); ?></li>
						<li><?php nsp_te( 'Dashboard and console polish', 'تلميع لوحة القيادة والكونسول' ); ?></li>
						<li><?php nsp_te( 'Tyre and rim cleaning', 'تنظيف الإطارات والجنوط' ); ?></li>
						<li><?php nsp_te( 'Window and glass cleaning', 'تنظيف النوافذ والزجاج' ); ?></li>
						<li><?php nsp_te( 'We come to your location', 'نأتي إلى موقعك' ); ?></li>
					</ul>
				</div>
				<div class="clinox-btn mt-30">
					<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span><?php nsp_te( 'Book Now', 'احجز الآن' ); ?></span></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="clinox-service-offer-section">
	<div class="container">
		<div class="clinox-section-title text-center headline pera-content">
			<span class="sub-title"><?php nsp_te( 'What We Cover', 'ما نشمله' ); ?></span>
			<h2><?php nsp_te( 'Car Wash Includes', 'غسيل السيارات يشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'Exterior Hand Wash', 'الغسيل الخارجي باليد' ),    nsp_t( 'Full body wash, rinse and dry using premium foam products.', 'غسيل كامل للهيكل وشطفه وتجفيفه باستخدام منتجات رغوة فاخرة.' ) ],
					[ '02', nsp_t( 'Interior Vacuum',    'شفط الداخل' ),               nsp_t( 'Complete vacuuming of seats, carpets and boot.', 'شفط شامل للمقاعد والسجاد وصندوق الأمتعة.' ) ],
					[ '03', nsp_t( 'Dashboard Polish',   'تلميع لوحة القيادة' ),      nsp_t( 'Cleaning and polishing of all interior surfaces.', 'تنظيف وتلميع جميع الأسطح الداخلية.' ) ],
					[ '04', nsp_t( 'Tyre & Rim Clean',   'تنظيف الإطارات والجنوط' ),  nsp_t( 'Thorough cleaning and dressing of tyres and alloy rims.', 'تنظيف شامل وتلميع الإطارات والجنوط المعدنية.' ) ],
					[ '05', nsp_t( 'Window Cleaning',    'تنظيف النوافذ' ),            nsp_t( 'Streak-free cleaning of all windows inside and out.', 'تنظيف النوافذ الداخلية والخارجية بدون آثار.' ) ],
					[ '06', nsp_t( 'Fragrance & Finish', 'العطر والإنهاء' ),           nsp_t( 'Car freshener and final protective wax coating.', 'معطر للسيارة وطبقة شمع واقية نهائية.' ) ],
				];
				foreach ( $items as $item ) : ?>
				<div class="col-lg-4 col-md-6">
					<div class="clinox-service-offer-item d-flex">
						<div class="inner-serial d-flex align-items-center justify-content-center"><?php echo esc_html( $item[0] ); ?></div>
						<div class="inner-text headline pera-content">
							<h3><?php echo esc_html( $item[1] ); ?></h3>
							<p><?php echo esc_html( $item[2] ); ?></p>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="clinox-service-benifit-section">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Why Choose Us', 'لماذا تختارنا' ); ?></span>
					<h2><?php nsp_te( 'Benefits of Our Car Wash', 'مزايا خدمة غسيل السيارات' ); ?></h2>
					<p><?php nsp_te( 'Save time and get a professional result — we bring the car wash to you at a time that suits your schedule.', 'وفّر وقتك واحصل على نتيجة احترافية — نحضر خدمة الغسيل إليك في الوقت الذي يناسبك.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'We come to your location', 'نأتي إلى موقعك' ); ?></li>
						<li><?php nsp_te( 'No water wastage — eco-friendly method', 'لا هدر للماء — طريقة صديقة للبيئة' ); ?></li>
						<li><?php nsp_te( 'Premium detailing products', 'منتجات تلميع فاخرة' ); ?></li>
						<li><?php nsp_te( 'Quick turnaround time', 'وقت إنجاز سريع' ); ?></li>
						<li><?php nsp_te( 'Available 7 days a week', 'متاح 7 أيام في الأسبوع' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Car-Wash-Service-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'Car Wash Benefits', 'مزايا غسيل السيارات' ); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/sections/contact' );
get_template_part( 'template-parts/sections/sponsor' );
get_footer();
