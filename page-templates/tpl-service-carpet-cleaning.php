<?php
/**
 * Template Name: Service - Carpet Cleaning
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Carpet Cleaning Service', 'خدمة تنظيف السجاد' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Carpet-Cleaning-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'Carpet Cleaning Service', 'خدمة تنظيف السجاد' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'Upholstery, Sofa & Carpet Cleaning', 'تنظيف سجاد احترافي' ); ?></h2>
					<p><?php nsp_te( 'We provide upholstery cleaning, sofa cleaning, carpet cleaning and curtain cleaning to remove stains, dust, odors and allergens. Our team uses professional equipment and fabric-safe products to restore freshness without damaging fibers.', 'ننظف السجاد والموكيت بعمق لإزالة البقع والغبار والروائح ومسببات الحساسية. يستخدم فريقنا معدات احترافية ومنتجات آمنة على الأقمشة لاستعادة النظافة دون إتلاف الألياف.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'Deep steam and shampoo carpet cleaning', 'تنظيف عميق بالبخار والشامبو' ); ?></li>
						<li><?php nsp_te( 'Stain and spot treatment', 'معالجة البقع والآثار' ); ?></li>
						<li><?php nsp_te( 'Odor removal and deodorizing', 'إزالة الروائح وتعطير السجاد' ); ?></li>
						<li><?php nsp_te( 'Dust and allergen extraction', 'استخراج الغبار ومسببات الحساسية' ); ?></li>
						<li><?php nsp_te( 'Safe sofa, curtain and upholstery cleaning for homes and offices', 'تنظيف آمن للمنازل والمكاتب' ); ?></li>
						<li><?php nsp_te( 'Fast drying process', 'عملية تجفيف سريعة' ); ?></li>
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
			<h2><?php nsp_te( 'Carpet Cleaning Includes', 'تنظيف السجاد يشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'Pre-inspection', 'الفحص المسبق' ), nsp_t( 'We inspect carpet type, stains, and traffic areas before cleaning.', 'نفحص نوع السجاد والبقع ومناطق الاستخدام الكثيف قبل التنظيف.' ) ],
					[ '02', nsp_t( 'Vacuum Extraction', 'شفط الغبار' ), nsp_t( 'Powerful vacuuming removes loose dust and dry soil.', 'شفط قوي يزيل الغبار والأتربة الجافة.' ) ],
					[ '03', nsp_t( 'Stain Treatment', 'معالجة البقع' ), nsp_t( 'Targeted treatment for coffee, food, mud, and common marks.', 'معالجة مخصصة لبقع القهوة والطعام والطين والآثار الشائعة.' ) ],
					[ '04', nsp_t( 'Deep Washing', 'الغسيل العميق' ), nsp_t( 'Deep shampoo or steam cleaning based on the carpet material.', 'تنظيف عميق بالشامبو أو البخار حسب خامة السجاد.' ) ],
					[ '05', nsp_t( 'Odor Control', 'التحكم بالروائح' ), nsp_t( 'Deodorizing treatment leaves carpets fresh and clean.', 'معالجة إزالة الروائح تمنح السجاد رائحة نظيفة ومنعشة.' ) ],
					[ '06', nsp_t( 'Drying & Grooming', 'التجفيف والترتيب' ), nsp_t( 'Final grooming helps the carpet dry evenly and look refreshed.', 'الترتيب النهائي يساعد السجاد على الجفاف بشكل متساو ومظهر متجدد.' ) ],
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
					<h2><?php nsp_te( 'Benefits of Our Carpet Cleaning', 'مزايا خدمة تنظيف السجاد' ); ?></h2>
					<p><?php nsp_te( 'Clean carpets improve indoor air quality, remove trapped dust, and make your home or workplace feel fresher and healthier.', 'السجاد النظيف يحسن جودة الهواء الداخلي ويزيل الغبار العالق ويجعل منزلك أو مكان عملك أكثر انتعاشاً وصحة.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'Professional-grade cleaning equipment', 'معدات تنظيف احترافية' ); ?></li>
						<li><?php nsp_te( 'Safe products for families and staff', 'منتجات آمنة للعائلات والموظفين' ); ?></li>
						<li><?php nsp_te( 'Better air quality and fewer allergens', 'جودة هواء أفضل وحساسية أقل' ); ?></li>
						<li><?php nsp_te( 'Restores carpet color and softness', 'استعادة لون ونعومة السجاد' ); ?></li>
						<li><?php nsp_te( 'Suitable for homes, offices, and commercial spaces', 'مناسب للمنازل والمكاتب والمساحات التجارية' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Carpet-Cleaning-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'Carpet Cleaning Benefits', 'مزايا تنظيف السجاد' ); ?>">
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
