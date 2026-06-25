<?php
/**
 * Template Name: Service - Office Cleaning
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Office Cleaning Service', 'خدمة تنظيف المكاتب' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Office-Cleaning-Service-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'Office Cleaning Service', 'خدمة تنظيف المكاتب' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'Office Cleaning & Commercial Cleaning Company', 'تنظيف مكاتب احترافي' ); ?></h2>
					<p><?php nsp_te( 'Keep your workplace clean, healthy and productive with office cleaning in Dammam, Khobar and the Eastern Region, commercial cleaning company support and janitorial services for B2B commercial clients. We work around your schedule to ensure minimal disruption to your business operations.', 'حافظ على مكان عملك نظيفاً وصحياً ومنتجاً مع خدمة تنظيف المكاتب الموثوقة لدينا في الدمام والخبر وجميع مدن المنطقة الشرقية. نعمل وفق جدولك لضمان أدنى تأثير على سير العمل.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'Desk, workstation and janitorial services', 'تنظيف المكاتب وأماكن العمل' ); ?></li>
						<li><?php nsp_te( 'Floor mopping and vacuuming', 'مسح الأرضيات والكنس' ); ?></li>
						<li><?php nsp_te( 'Washroom and kitchen sanitization', 'تعقيم الحمامات والمطبخ' ); ?></li>
						<li><?php nsp_te( 'Garbage removal and disposal', 'إزالة القمامة والتخلص منها' ); ?></li>
						<li><?php nsp_te( 'Glass partition and window cleaning', 'تنظيف الفواصل الزجاجية والنوافذ' ); ?></li>
						<li><?php nsp_te( 'After-hours B2B commercial cleaning service available', 'الخدمة متاحة بعد أوقات العمل' ); ?></li>
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
			<h2><?php nsp_te( 'Office Cleaning Includes', 'تنظيف المكاتب يشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'Workstation Cleaning',   'تنظيف أماكن العمل' ),   nsp_t( 'Full desk, monitor, keyboard and surface sanitization.', 'تعقيم شامل للمكتب والشاشة ولوحة المفاتيح وجميع الأسطح.' ) ],
					[ '02', nsp_t( 'Reception & Lobby',      'الاستقبال والردهة' ),     nsp_t( 'Welcoming clean reception areas and entrance spaces.', 'تنظيف مناطق الاستقبال والمداخل لإعطاء انطباع أول مميز.' ) ],
					[ '03', nsp_t( 'Washroom Sanitization',  'تعقيم الحمامات' ),        nsp_t( 'Complete toilet, sink and floor disinfection.', 'تعقيم شامل للمراحيض والمغاسل والأرضيات.' ) ],
					[ '04', nsp_t( 'Kitchen & Pantry',       'المطبخ والمستودع' ),      nsp_t( 'Cleaning of office kitchens, fridges and appliances.', 'تنظيف مطابخ المكاتب والثلاجات والأجهزة.' ) ],
					[ '05', nsp_t( 'Carpet & Floor Care',    'العناية بالسجاد والأرضيات' ), nsp_t( 'Vacuuming carpets and mopping hard floors.', 'كنس السجاد ومسح الأرضيات الصلبة.' ) ],
					[ '06', nsp_t( 'Waste Management',       'إدارة النفايات' ),        nsp_t( 'Emptying bins, recycling and responsible waste disposal.', 'إفراغ سلال المهملات وإعادة التدوير والتخلص المسؤول من النفايات.' ) ],
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
					<h2><?php nsp_te( 'Benefits of Our Office Cleaning', 'مزايا خدمة تنظيف المكاتب' ); ?></h2>
					<p><?php nsp_te( 'A clean workplace boosts employee productivity and leaves a lasting impression on your clients and visitors.', 'بيئة عمل نظيفة ترفع إنتاجية الموظفين وتترك انطباعاً دائماً لدى عملائك وزوارك.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'Customised cleaning schedule', 'جدول تنظيف مخصص' ); ?></li>
						<li><?php nsp_te( 'After-hours and weekend availability', 'متاح بعد الدوام وفي عطلات نهاية الأسبوع' ); ?></li>
						<li><?php nsp_te( 'Professional uniformed staff', 'طاقم مهني بزي موحد' ); ?></li>
						<li><?php nsp_te( 'Insured and bonded team', 'فريق مؤمن عليه' ); ?></li>
						<li><?php nsp_te( 'Regular quality inspections', 'فحوصات جودة دورية' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Office-Cleaning-Service-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'Office Cleaning Benefits', 'مزايا تنظيف المكاتب' ); ?>">
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
