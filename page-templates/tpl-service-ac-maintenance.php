<?php
/**
 * Template Name: Service - AC Maintenance
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'AC Maintenance Service', 'خدمة صيانة المكيفات' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'AC-Maintenance-Service-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'AC Maintenance Service', 'خدمة صيانة المكيفات' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'AC Cleaning, HVAC & Water Tank Cleaning', 'صيانة وإصلاح المكيفات' ); ?></h2>
					<p><?php nsp_te( 'Keep your air conditioning running efficiently in the Eastern Region heat with AC cleaning, HVAC maintenance and water tank cleaning services across Dammam, Khobar, Dhahran, Jubail, Qatif and Al-Ahsa. Our certified technicians service split units, central AC and ducted systems with fast response and genuine parts.', 'حافظ على كفاءة مكيفك في أجواء المنطقة الشرقية مع خدمات تنظيف المكيفات وصيانة أنظمة التكييف وتنظيف خزانات المياه في الدمام والخبر والظهران والجبيل والقطيف والأحساء. يخدم فنيونا المعتمدون جميع الماركات الرئيسية — وحدات السبليت والمكيف المركزي وأنظمة القنوات — باستجابة سريعة وقطع غيار أصلية.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'AC cleaning and HVAC deep cleaning', 'صيانة وتنظيف عميق للمكيف' ); ?></li>
						<li><?php nsp_te( 'Filter replacement and gas top-up', 'تغيير الفلتر وإعادة شحن الغاز' ); ?></li>
						<li><?php nsp_te( 'Fault diagnosis and repair', 'تشخيص الأعطال وإصلاحها' ); ?></li>
						<li><?php nsp_te( 'New AC installation', 'تركيب مكيفات جديدة' ); ?></li>
						<li><?php nsp_te( 'Annual maintenance contracts and water tank cleaning support', 'عقود صيانة سنوية' ); ?></li>
						<li><?php nsp_te( 'All brands and models covered', 'تغطية جميع الماركات والموديلات' ); ?></li>
					</ul>
				</div>
				<div class="clinox-btn mt-30">
					<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span><?php nsp_te( 'Book a Technician', 'احجز فنياً' ); ?></span></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="clinox-service-offer-section">
	<div class="container">
		<div class="clinox-section-title text-center headline pera-content">
			<span class="sub-title"><?php nsp_te( 'What We Cover', 'ما نشمله' ); ?></span>
			<h2><?php nsp_te( 'AC Maintenance Includes', 'صيانة المكيفات تشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'AC Deep Cleaning',   'تنظيف المكيف عمقياً' ),    nsp_t( 'Full indoor and outdoor unit cleaning and disinfection.', 'تنظيف وتعقيم شامل للوحدة الداخلية والخارجية.' ) ],
					[ '02', nsp_t( 'Filter Replacement', 'تغيير الفلتر' ),            nsp_t( 'Washing or replacing filters for better air quality.', 'غسيل أو استبدال الفلاتر لتحسين جودة الهواء.' ) ],
					[ '03', nsp_t( 'Gas Recharge',       'إعادة شحن الغاز' ),         nsp_t( 'Refrigerant top-up for optimal cooling performance.', 'إعادة شحن غاز التبريد لأداء تبريد مثالي.' ) ],
					[ '04', nsp_t( 'Electrical Check',   'فحص الكهرباء' ),            nsp_t( 'Inspection of all wiring, capacitors and connections.', 'فحص الأسلاك والمكثفات والتوصيلات الكهربائية.' ) ],
					[ '05', nsp_t( 'Fault Diagnosis',    'تشخيص الأعطال' ),           nsp_t( 'Accurate diagnosis using professional tools.', 'تشخيص دقيق باستخدام أدوات احترافية.' ) ],
					[ '06', nsp_t( 'New Installation',   'تركيب جديد' ),              nsp_t( 'Expert installation of split and central AC systems.', 'تركيب احترافي لأنظمة السبليت والمكيف المركزي.' ) ],
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
					<h2><?php nsp_te( 'Benefits of Our AC Maintenance', 'مزايا خدمة صيانة المكيفات' ); ?></h2>
					<p><?php nsp_te( 'Regular AC maintenance extends the life of your unit, reduces energy bills and ensures clean, healthy air for your family or team.', 'الصيانة الدورية للمكيف تطيل عمره وتخفض فاتورة الكهرباء وتضمن هواءً نقياً وصحياً لعائلتك أو فريقك.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'Certified and experienced technicians', 'فنيون معتمدون وذوو خبرة' ); ?></li>
						<li><?php nsp_te( 'Same-day service available', 'الخدمة في نفس اليوم متاحة' ); ?></li>
						<li><?php nsp_te( 'Genuine spare parts used', 'استخدام قطع غيار أصلية' ); ?></li>
						<li><?php nsp_te( '90-day repair warranty', 'ضمان إصلاح لمدة 90 يوماً' ); ?></li>
						<li><?php nsp_te( 'Annual maintenance contracts available', 'عقود صيانة سنوية متاحة' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'AC-Maintenance-Service-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'AC Maintenance Benefits', 'مزايا صيانة المكيفات' ); ?>">
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
