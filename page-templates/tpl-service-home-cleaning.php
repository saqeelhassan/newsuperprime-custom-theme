<?php
/**
 * Template Name: Service - Home Cleaning
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Home Cleaning Service', 'خدمة تنظيف المنازل' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Home-Cleaning-Service-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'Home Cleaning Service', 'خدمة تنظيف المنازل' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'Deep Cleaning & Home Cleaning Service', 'تنظيف عميق وتنظيف منازل احترافي' ); ?></h2>
					<p><?php nsp_te( 'We provide home cleaning in Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa and across Saudi Arabia\'s Eastern Region using eco-friendly products and modern equipment. Our trained staff handles hourly maid service, villa cleaning, apartment cleaning and post construction cleaning so every corner is spotless.', 'نقدم خدمات تنظيف منازل عالية الجودة في الدمام والخبر والظهران والجبيل والقطيف والأحساء وجميع مدن المنطقة الشرقية باستخدام منتجات صديقة للبيئة ومعدات حديثة. يضمن فريقنا المدرب نظافة كل ركن في منزلك، من التنظيف العميق للمطبخ إلى تعقيم الحمامات.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'Full house deep cleaning and post construction cleaning', 'تنظيف شامل للمنزل' ); ?></li>
						<li><?php nsp_te( 'Kitchen and appliance cleaning', 'تنظيف المطبخ والأجهزة' ); ?></li>
						<li><?php nsp_te( 'Bathroom sanitization', 'تعقيم الحمامات' ); ?></li>
						<li><?php nsp_te( 'Dusting, vacuuming and mopping', 'إزالة الغبار والكنس والمسح' ); ?></li>
						<li><?php nsp_te( 'Window and glass cleaning', 'تنظيف النوافذ والزجاج' ); ?></li>
						<li><?php nsp_te( 'Villa cleaning, apartment cleaning and house cleaning near me support', 'استخدام منتجات صديقة للبيئة' ); ?></li>
					</ul>
				</div>
				<div class="clinox-btn mt-30">
					<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span><?php nsp_te( 'Get A Free Quote', 'احصل على عرض مجاني' ); ?></span></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="clinox-service-offer-section">
	<div class="container">
		<div class="clinox-section-title text-center headline pera-content">
			<span class="sub-title"><?php nsp_te( 'What We Cover', 'ما نشمله' ); ?></span>
			<h2><?php nsp_te( 'Home Cleaning Includes', 'تنظيف المنازل يشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'Living Room Cleaning',  'تنظيف غرفة المعيشة' ),  nsp_t( 'Deep cleaning of sofas, surfaces, floors and all living areas.', 'تنظيف عميق للأرائك والأسطح والأرضيات وجميع مناطق الجلوس.' ) ],
					[ '02', nsp_t( 'Kitchen Deep Clean',    'تنظيف المطبخ عمقياً' ), nsp_t( 'Full kitchen cleaning including appliances, cabinets and counters.', 'تنظيف المطبخ بالكامل يشمل الأجهزة والخزائن وأسطح العمل.' ) ],
					[ '03', nsp_t( 'Bathroom Sanitization', 'تعقيم الحمام' ),         nsp_t( 'Complete disinfection of toilets, showers, sinks and tiles.', 'تعقيم شامل للمراحيض والمغاسل والدش والبلاط.' ) ],
					[ '04', nsp_t( 'Bedroom Cleaning',      'تنظيف غرف النوم' ),      nsp_t( 'Dusting, vacuuming, bed making and wardrobe wipe-down.', 'إزالة الغبار والكنس وترتيب الأسرة ومسح الخزائن.' ) ],
					[ '05', nsp_t( 'Floor Mopping',         'مسح الأرضيات' ),         nsp_t( 'Thorough mopping and polishing of all floor types.', 'مسح وتلميع شامل لجميع أنواع الأرضيات.' ) ],
					[ '06', nsp_t( 'Window Cleaning',       'تنظيف النوافذ' ),        nsp_t( 'Streak-free interior and exterior window and glass cleaning.', 'تنظيف النوافذ والزجاج الداخلي والخارجي بدون آثار.' ) ],
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
					<h2><?php nsp_te( 'Benefits of Our Home Cleaning', 'مزايا خدمة تنظيف المنازل' ); ?></h2>
					<p><?php nsp_te( 'Our professional home cleaning service gives you a spotless, healthy living environment so you can focus on what matters most.', 'خدمة تنظيف المنازل الاحترافية لدينا تمنحك بيئة معيشية نظيفة وصحية حتى تتفرغ لما يهمك.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'Trained and background-checked staff', 'موظفون مدربون وموثوقون' ); ?></li>
						<li><?php nsp_te( 'Flexible scheduling — daily, weekly or monthly', 'جدولة مرنة — يومية أو أسبوعية أو شهرية' ); ?></li>
						<li><?php nsp_te( 'Eco-friendly, family-safe products', 'منتجات صديقة للبيئة وآمنة للأسرة' ); ?></li>
						<li><?php nsp_te( '100% satisfaction guarantee', 'ضمان الرضا ١٠٠٪' ); ?></li>
						<li><?php nsp_te( 'Fully insured service', 'خدمة مؤمنة بالكامل' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Home-Cleaning-Service-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'Home Cleaning Benefits', 'مزايا تنظيف المنازل' ); ?>">
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
