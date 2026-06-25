<?php
/**
 * Template Name: Service - Home Shifting
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
nsp_breadcrumb( '', nsp_t( 'Home Shifting Service', 'خدمة نقل العفش' ) );
?>

<section class="clinox-about-service-section page-section-padding">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Home-Shifting-Service-page.jpg' ) ); ?>" alt="<?php nsp_ta( 'Home Shifting Service', 'خدمة نقل العفش' ); ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-section-title headline pera-content">
					<span class="sub-title"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></span>
					<h2><?php nsp_te( 'Moving Maintenance & Home Shifting', 'نقل عفش آمن واحترافي' ); ?></h2>
					<p><?php nsp_te( 'Our moving maintenance service covers home shifting, furniture transport, office relocation and general maintenance. We pack, transport and deliver furniture, fragile items and appliances with the utmost care, making your move completely stress-free.', 'تضمن خدمة نقل العفش لدينا تعبئة ممتلكاتك ونقلها وتسليمها بأمان تام. نتعامل مع الأثاث والمقتنيات الهشة والأجهزة بأقصى درجات الحرص لجعل انتقالك خالياً من القلق.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-30">
					<ul>
						<li><?php nsp_te( 'Furniture transport, disassembly and reassembly', 'فك وتركيب الأثاث' ); ?></li>
						<li><?php nsp_te( 'Professional packing with quality materials', 'تعبئة احترافية بمواد عالية الجودة' ); ?></li>
						<li><?php nsp_te( 'Safe and secure transportation', 'نقل آمن ومضمون' ); ?></li>
						<li><?php nsp_te( 'Fragile and valuable item handling', 'التعامل مع القطع الهشة والثمينة' ); ?></li>
						<li><?php nsp_te( 'Door-to-door delivery', 'توصيل من الباب إلى الباب' ); ?></li>
						<li><?php nsp_te( 'Office relocation, general maintenance and post-move cleaning available', 'تنظيف ما بعد النقل متاح' ); ?></li>
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
			<h2><?php nsp_te( 'Home Shifting Includes', 'نقل العفش يشمل' ); ?></h2>
		</div>
		<div class="clinox-service-offer-content mt-40">
			<div class="row">
				<?php
				$items = [
					[ '01', nsp_t( 'Pre-Move Survey',       'المسح قبل النقل' ),        nsp_t( 'We assess your home and plan the most efficient move.', 'نقيّم منزلك ونضع خطة للانتقال الأكثر كفاءة.' ) ],
					[ '02', nsp_t( 'Professional Packing',  'التعبئة الاحترافية' ),      nsp_t( 'All items packed with bubble wrap, cartons and straps.', 'تعبئة جميع المقتنيات بالفقاعات الواقية والكراتين والأربطة.' ) ],
					[ '03', nsp_t( 'Furniture Disassembly', 'فك الأثاث' ),               nsp_t( 'Safe dismantling of beds, wardrobes and large furniture.', 'فك آمن للأسرة والخزائن والأثاث الكبير.' ) ],
					[ '04', nsp_t( 'Secure Transportation', 'النقل الآمن' ),             nsp_t( 'GPS-tracked vehicles with padded interiors.', 'مركبات مزودة بنظام تتبع GPS وداخلية مبطنة للحماية.' ) ],
					[ '05', nsp_t( 'Unpacking & Setup',     'التفريغ والترتيب' ),        nsp_t( 'Unpacking and placing furniture in your new home.', 'تفريغ الصناديق وترتيب الأثاث في منزلك الجديد.' ) ],
					[ '06', nsp_t( 'Post-Move Cleaning',    'تنظيف ما بعد النقل' ),     nsp_t( 'Optional cleaning of your old and new property.', 'تنظيف اختياري لمنزلك القديم والجديد.' ) ],
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
					<h2><?php nsp_te( 'Benefits of Our Home Shifting', 'مزايا خدمة نقل العفش' ); ?></h2>
					<p><?php nsp_te( 'Moving home is stressful enough — let our experienced team handle every detail so you can settle into your new home with ease.', 'الانتقال إلى منزل جديد أمر مرهق بما يكفي — دع فريقنا المتمرس يتولى كل التفاصيل حتى تستقر في منزلك الجديد براحة تامة.' ); ?></p>
				</div>
				<div class="service-benifit-feature ul-li mt-20">
					<ul>
						<li><?php nsp_te( 'Experienced and trained movers', 'عمال نقل مدربون وذوو خبرة' ); ?></li>
						<li><?php nsp_te( 'Full insurance coverage on all items', 'تأمين شامل على جميع المقتنيات' ); ?></li>
						<li><?php nsp_te( 'On-time guaranteed delivery', 'تسليم في الوقت المحدد مضمون' ); ?></li>
						<li><?php nsp_te( 'Transparent pricing — no hidden costs', 'أسعار شفافة — بدون تكاليف خفية' ); ?></li>
						<li><?php nsp_te( 'Available 7 days a week', 'متاح 7 أيام في الأسبوع' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="clinox-about-service-img-wrap position-relative">
					<span class="img-shape position-absolute"></span>
					<div class="clinox-about-service-img">
						<img src="<?php echo esc_url( nsp_service_image_url( 'Home-Shifting-Service-page-1.jpg' ) ); ?>" alt="<?php nsp_ta( 'Home Shifting Benefits', 'مزايا نقل العفش' ); ?>">
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
