<?php
/**
 * Template Name: Service - Pest Control
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Pest Control Service', 'خدمة مكافحة الحشرات' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Pest-Control-Service-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'Pest Control Service', 'خدمة مكافحة الحشرات' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'Pest Control in the Eastern Region', 'مكافحة حشرات احترافية في المنطقة الشرقية' ); ?></h2>
					<p><?php nsp_te( 'Protect your home or business with pest control services in Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa and the Eastern Region for cockroach control, bed bug control, rodents and other pests. We use safe, effective and government-approved treatments that eliminate pests at the source.', 'احمِ منزلك أو منشأتك من الحشرات والقوارض وسائر الآفات في الدمام والخبر والظهران والجبيل والقطيف والأحساء وجميع مدن المنطقة الشرقية بمعالجاتنا الآمنة والفعّالة والمعتمدة حكومياً. نستخدم حلولاً آمنة للأطفال والحيوانات الأليفة تقضي على الآفات من جذورها.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'Cockroach control and ant treatment', 'معالجة الصراصير والنمل' ); ?></li>
						<li><?php nsp_te( 'Bed bug control and elimination', 'القضاء على حشرات الفراش' ); ?></li>
						<li><?php nsp_te( 'Rodent control and trapping', 'مكافحة القوارض وإيقادها' ); ?></li>
						<li><?php nsp_te( 'Termite inspection and treatment', 'فحص النمل الأبيض ومعالجته' ); ?></li>
						<li><?php nsp_te( 'Mosquito and fly control', 'مكافحة البعوض والذباب' ); ?></li>
						<li><?php nsp_te( 'Child and pet safe chemicals', 'مواد كيميائية آمنة للأطفال والحيوانات' ); ?></li>
					</ul>
				</div>
				<div class="clinox-btn mt-30">
					<a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span><?php nsp_te( 'Book Treatment', 'احجز علاجاً' ); ?></span></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="clinox-service-offer-section">
	<div class="container">
		<div class="clinox-section-title text-center headline pera-content">
			<span class="sub-title"><?php nsp_te( 'What We Cover', 'ما نشمله' ); ?></span>
			<h2><?php nsp_te( 'Pest Control Includes', 'مكافحة الحشرات تشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'Inspection & Survey',  'الفحص والمسح' ),          nsp_t( 'Full property inspection to identify pest types and entry points.', 'فحص شامل للممتلكات لتحديد أنواع الآفات ونقاط الدخول.' ) ],
					[ '02', nsp_t( 'Cockroach Treatment',  'معالجة الصراصير' ),        nsp_t( 'Gel bait and spray treatment for full cockroach elimination.', 'معالجة بالطُعم الجيل والرذاذ للقضاء التام على الصراصير.' ) ],
					[ '03', nsp_t( 'Bed Bug Treatment',    'معالجة حشرات الفراش' ),   nsp_t( 'Heat and chemical treatment to eradicate bed bugs completely.', 'معالجة حرارية وكيميائية للقضاء الكامل على حشرات الفراش.' ) ],
					[ '04', nsp_t( 'Rodent Control',       'مكافحة القوارض' ),         nsp_t( 'Bait stations and traps for mice and rat removal.', 'محطات طُعم وأفخاخ لإزالة الفئران والجرذان.' ) ],
					[ '05', nsp_t( 'Termite Treatment',    'معالجة النمل الأبيض' ),    nsp_t( 'Soil and wood treatment to protect your structure.', 'معالجة التربة والخشب لحماية هيكل المبنى.' ) ],
					[ '06', nsp_t( 'Follow-Up Visit',      'زيارة المتابعة' ),          nsp_t( 'Return visit to ensure complete pest elimination.', 'زيارة متابعة للتأكد من القضاء التام على الآفات.' ) ],
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
					<h2><?php nsp_te( 'Benefits of Our Pest Control', 'مزايا خدمة مكافحة الحشرات' ); ?></h2>
					<p><?php nsp_te( 'Our licensed pest control experts deliver lasting results with minimal disruption to your home or business.', 'يقدم خبراؤنا المرخصون في مكافحة الحشرات نتائج دائمة مع أدنى تأثير على منزلك أو منشأتك.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'Licensed and government-approved', 'مرخص ومعتمد حكومياً' ); ?></li>
						<li><?php nsp_te( 'Safe for children and pets', 'آمن للأطفال والحيوانات الأليفة' ); ?></li>
						<li><?php nsp_te( 'Long-lasting treatments', 'معالجات طويلة الأمد' ); ?></li>
						<li><?php nsp_te( 'Guaranteed results or free re-treatment', 'نتائج مضمونة أو إعادة المعالجة مجاناً' ); ?></li>
						<li><?php nsp_te( 'Annual protection plans available', 'خطط حماية سنوية متاحة' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Pest-Control-Service-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'Pest Control Benefits', 'مزايا مكافحة الحشرات' ); ?>">
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
