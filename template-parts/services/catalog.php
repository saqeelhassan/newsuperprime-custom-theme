<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$services = nsp_catalog_services();
$offers = [];
foreach ( $services as $service ) {
    foreach ( $service['packages'] as $index => $package ) {
        $offers[] = [ 'service' => $service, 'package' => $package, 'index' => $index ];
    }
}
$item_attrs = function ( array $service, string $extra = '' ) {
    foreach ( $service['packages'] as $package ) $extra .= ' ' . $package['package_name'] . ' ' . ( $package['package_description'] ?? '' );
    return 'data-service-categories="' . esc_attr( implode( ' ', $service['categories'] ?? [] ) ) . '" data-catalog-item data-service-key="' . (int) $service['id'] . '" data-search="' . esc_attr( $service['title'] . ' ' . $service['description'] . ' ' . $extra ) . '"';
};
?>
<main id="nsp-catalog" class="nsp-catalog">
<div class="nsp-catalog-shell container">
    <h1 class="screen-reader-text"><?php nsp_te( 'Our Services', 'خدماتنا' ); ?></h1>
    <div class="nsp-browse-heading"><span class="nsp-eyebrow"><?php nsp_te( 'BROWSE SERVICES', 'تصفح الخدمات' ); ?></span></div>
    <div class="nsp-filter-strip" role="group" aria-label="<?php nsp_ta( 'Filter services', 'تصفية الخدمات' ); ?>">
        <button type="button" data-catalog-filter="all" aria-pressed="true"><i class="fas fa-th-large" aria-hidden="true"></i> <?php nsp_te( 'All', 'جميع الخدمات' ); ?></button>
        <?php foreach ( nsp_catalog_categories( $services ) as $category ) : ?><button type="button" data-catalog-filter="<?php echo (int) $category->term_id; ?>" aria-pressed="false"><span class="nsp-filter-dot" aria-hidden="true"></span><?php echo esc_html( nsp_catalog_category_label( $category->name ) ); ?></button><?php endforeach; ?>
    </div>
    <div class="nsp-browse-heading"><span class="nsp-eyebrow"><?php nsp_te( 'SERVICE AREAS', 'مناطق الخدمة' ); ?></span></div>
    <div class="nsp-filter-strip nsp-city-strip" role="group" aria-label="<?php nsp_ta( 'Choose service city', 'اختر مدينة الخدمة' ); ?>">
        <?php foreach ( [ 'Khobar' => 'الخبر', 'Dammam' => 'الدمام', 'Jubail' => 'الجبيل', 'Ras Tanura' => 'رأس تنورة' ] as $city => $arabic ) : ?>
            <button type="button" data-catalog-city="<?php echo esc_attr( $city ); ?>" aria-pressed="<?php echo 'Dammam' === $city ? 'true' : 'false'; ?>"><span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?php nsp_te( $city, $arabic ); ?></span></button>
        <?php endforeach; ?>
    </div>
    <p data-catalog-status role="status" class="screen-reader-text"></p>
    <div data-no-results hidden class="nsp-no-results"><?php nsp_te( 'No services match your search. Try another word or choose All Services.', 'لا توجد خدمات مطابقة. جرب كلمة أخرى أو اختر جميع الخدمات.' ); ?></div>

    <?php get_template_part( 'template-parts/services/hero', null, [ 'services' => $services ] ); ?>

    <?php get_template_part( 'template-parts/services/featured', null, [ 'services' => $services ] ); ?>

    <section class="nsp-catalog-section" data-results-section>
        <div class="nsp-section-heading"><div><h2><?php nsp_te( 'Service Packages', 'باقات الخدمات' ); ?></h2><p><?php nsp_te( 'Your space. Your service. Choose what fits.', 'مساحتك، خدمتك. اختر ما يناسبك.' ); ?></p></div><span class="nsp-small-accent"><?php nsp_te( 'BOOK DIRECT', 'احجز مباشرة' ); ?></span></div>
        <div class="nsp-offer-grid" data-results-limit="8">
        <?php if ( $offers ) : foreach ( $offers as $offer ) : $service = $offer['service']; $package = $offer['package']; ?>
            <article class="nsp-offer-card" <?php echo $item_attrs( $service, $package['package_name'] . ' ' . ( $package['package_description'] ?? '' ) ); ?>>
                <div class="nsp-offer-top"><img src="<?php echo esc_url( $service['image'] ); ?>" alt="" loading="lazy"><div><span class="nsp-eyebrow"><?php echo esc_html( $service['title'] ); ?></span><h3><?php echo esc_html( $package['package_name'] ); ?></h3><strong><?php echo esc_html( nsp_catalog_price( $package['package_price'] ) ); ?></strong><?php if ( ! empty( $package['package_perk'] ) ) : ?><p class="nsp-perk"><i class="fas fa-gift" aria-hidden="true"></i> <?php echo esc_html( $package['package_perk'] ); ?></p><?php endif; ?></div></div>
                <div class="nsp-offer-bottom"><span><?php echo esc_html( wp_trim_words( $package['package_description'] ?? '', 12 ) ?: nsp_t( 'Confirm your preferred date with our team.', 'أكد موعدك المفضل مع فريقنا.' ) ); ?></span><?php nsp_booking_button( $service['id'], nsp_t( 'Book →', 'احجز ←' ), $service['image'], $offer['index'] ); ?></div>
            </article>
        <?php endforeach; else : foreach ( array_slice( $services, 0, 4 ) as $service ) : ?>
            <article class="nsp-offer-card" <?php echo $item_attrs( $service ); ?>><div class="nsp-offer-top"><img src="<?php echo esc_url( $service['image'] ); ?>" alt="" loading="lazy"><div><span class="nsp-eyebrow"><?php nsp_te( 'TAILORED TO YOUR SPACE', 'حسب احتياجات مساحتك' ); ?></span><h3><?php echo esc_html( $service['title'] ); ?></h3><strong><?php nsp_te( 'Price on request', 'السعر عند الطلب' ); ?></strong></div></div><div class="nsp-offer-bottom"><span><?php nsp_te( 'Tell us what you need for a tailored quote.', 'أخبرنا باحتياجاتك للحصول على عرض سعر.' ); ?></span><a class="nsp-small-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php nsp_te( 'Get a quote →', 'اطلب عرض سعر ←' ); ?></a></div></article>
        <?php endforeach; endif; ?>
        </div>
    </section>

    <section class="nsp-benefit-panel"><span class="nsp-panel-icon"><i class="fas fa-tag" aria-hidden="true"></i></span><div><p class="nsp-eyebrow"><?php nsp_te( 'FIRST BOOKING BENEFIT', 'ميزة الحجز الأول' ); ?></p><h2><?php nsp_te( 'A fresh start, with 10% off.', 'بداية منعشة مع خصم ١٠٪.' ); ?></h2><p><?php nsp_te( 'Your regular service price stays clear. The booking form automatically applies your 10% welcome benefit.', 'يبقى سعر الخدمة واضحاً. يطبق نموذج الحجز خصم الترحيب بنسبة ١٠٪ تلقائياً.' ); ?></p><div class="nsp-benefit-chips"><span><i class="fas fa-check-circle" aria-hidden="true"></i> <?php nsp_te( 'Applied automatically at review', 'يطبق تلقائياً عند المراجعة' ); ?></span><span><i class="fas fa-check-circle" aria-hidden="true"></i> <?php nsp_te( 'See your final price before sending', 'اطلع على السعر النهائي قبل الإرسال' ); ?></span></div></div></section>
    <section class="nsp-weekend-panel"><h2><i class="far fa-calendar-alt" aria-hidden="true"></i> <?php nsp_te( 'Make room for a cleaner weekend', 'استقبل عطلة نهاية الأسبوع بنظافة' ); ?></h2><p><?php nsp_te( 'Prefer Friday or Saturday? Choose your date and our team will confirm availability.', 'تفضل الجمعة أو السبت؟ اختر موعدك وسيؤكد فريقنا التوفر.' ); ?></p><div class="nsp-weekend-grid"><?php foreach ( [ [ 'Flexible scheduling', 'مواعيد مرنة' ], [ 'Clear package prices', 'أسعار باقات واضحة' ], [ 'Easy WhatsApp requests', 'طلبات واتساب سهلة' ], [ 'Your instructions, included', 'تعليماتك موضع اهتمام' ] ] as $text ) : ?><span><i class="far fa-check-circle" aria-hidden="true"></i> <?php nsp_te( $text[0], $text[1] ); ?></span><?php endforeach; ?></div></section>

    <section class="nsp-catalog-section" data-results-section><div class="nsp-section-heading"><div><h2><?php nsp_te( 'More Specialized Services', 'المزيد من الخدمات المتخصصة' ); ?></h2><p class="nsp-eyebrow"><?php nsp_te( 'RESIDENTIAL & COMMERCIAL SOLUTIONS', 'حلول للمنازل والمنشآت التجارية' ); ?></p></div></div><div class="nsp-specialized-grid">
        <?php foreach ( $services as $service ) : ?><article class="nsp-specialized-card" <?php echo $item_attrs( $service ); ?>><img src="<?php echo esc_url( $service['image'] ); ?>" alt="" loading="lazy"><div><h3><a href="<?php echo esc_url( $service['url'] ); ?>"><?php echo esc_html( $service['title'] ); ?></a></h3><p><?php echo esc_html( $service['description'] ); ?></p><strong><?php echo esc_html( ( $service['price_label'] ?: nsp_catalog_price( $service['price'] ) ) ); ?></strong></div><a class="nsp-circle-link" href="<?php echo esc_url( $service['url'] ); ?>" aria-label="<?php echo esc_attr( $service['title'] ); ?>">↗</a></article><?php endforeach; ?>
    </div></section>

    <?php $projects = get_posts( [ 'post_type' => 'project', 'post_status' => 'publish', 'numberposts' => 6 ] ); if ( $projects ) : ?>
    <section class="nsp-catalog-section"><div class="nsp-section-heading"><div><h2><?php nsp_te( 'Our Work', 'أعمالنا' ); ?></h2><p class="nsp-eyebrow"><?php nsp_te( 'SERVICE IN ACTION ACROSS THE EASTERN REGION', 'خدماتنا على أرض الواقع في المنطقة الشرقية' ); ?></p></div><a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>"><?php nsp_te( 'View all ↗', 'عرض الكل ↖' ); ?></a></div><div class="nsp-work-rail">
        <?php foreach ( $projects as $project_index => $project ) : $photo = get_the_post_thumbnail_url( $project->ID, 'nsp-project' ) ?: ( $services ? $services[ $project_index % count( $services ) ]['image'] : nsp_service_image_url( 'Home-Cleaning-Service.jpg' ) ); ?><a class="nsp-work-card" href="<?php echo esc_url( get_permalink( $project->ID ) ); ?>"><img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( nsp_project_ar( $project->post_title, 'title' ) ?: $project->post_title ); ?>" loading="lazy"><div><span class="nsp-eyebrow"><?php nsp_te( 'NEW SUPER PRIME', 'نيو سوبر برايم' ); ?></span><h3><?php echo esc_html( nsp_project_ar( $project->post_title, 'title' ) ?: $project->post_title ); ?></h3></div></a><?php endforeach; ?>
    </div></section><?php endif; ?>


    <section class="nsp-catalog-section"><div class="nsp-section-heading"><div><h2><?php nsp_te( 'How Booking Works', 'كيف تحجز خدماتنا' ); ?></h2><p><?php nsp_te( 'Your next clean, in five simple steps.', 'خدمتك القادمة في خمس خطوات بسيطة.' ); ?></p></div></div><ol class="nsp-how-steps"><?php foreach ( [ [ 'Choose a package', 'اختر الباقة' ], [ 'Set your location', 'حدد الموقع' ], [ 'Pick a date', 'اختر الموعد' ], [ 'Add your details', 'أضف بياناتك' ], [ 'Send on WhatsApp', 'أرسل عبر واتساب' ] ] as $i => $step ) : ?><li><span><?php echo (int) $i + 1; ?></span><?php nsp_te( $step[0], $step[1] ); ?></li><?php endforeach; ?></ol></section>
</div>
</main>
