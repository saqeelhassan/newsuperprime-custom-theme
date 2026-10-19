<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<dialog id="nsp-service-preview" aria-labelledby="nsp-preview-title" dir="<?php echo nsp_is_arabic() ? 'rtl' : 'ltr'; ?>">
    <div class="nsp-preview-layout">
        <header class="nsp-preview-hero">
            <img data-preview-image alt="">
            <button type="button" data-preview-close aria-label="<?php nsp_ta( 'Close service details', 'إغلاق تفاصيل الخدمة' ); ?>">×</button>
            <div class="nsp-preview-heading"><span data-preview-category></span><h2 id="nsp-preview-title" tabindex="-1"></h2><p data-preview-subtitle></p></div>
        </header>
        <div class="nsp-preview-body">
            <div class="nsp-preview-service-switcher">
                <button type="button" data-preview-prev aria-label="<?php nsp_ta('Previous service', 'الخدمة السابقة'); ?>">&larr;</button>
                <label for="nsp-preview-service"><?php nsp_te('Change service', 'تغيير الخدمة'); ?><select id="nsp-preview-service" data-preview-service><?php foreach (nsp_catalog_services() as $index=>$service) : ?><option value="<?php echo (int)$index; ?>"><?php echo esc_html($service['title']); ?></option><?php endforeach; ?></select></label>
                <button type="button" data-preview-next aria-label="<?php nsp_ta('Next service', 'الخدمة التالية'); ?>">&rarr;</button>
            </div>
            <template data-preview-service-data><?php foreach (nsp_catalog_services() as $service) nsp_booking_button($service['id'], $service['title'], $service['image']); ?></template>
            <h3><?php nsp_te( 'SERVICE OVERVIEW', 'نبذة عن الخدمة' ); ?></h3>
            <p data-preview-overview></p>
            <div class="nsp-preview-package-heading"><h3><?php nsp_te( 'SELECT PACKAGE', 'اختر الباقة' ); ?></h3><span><?php nsp_te( 'Clear pricing', 'أسعار واضحة' ); ?></span></div>
            <fieldset class="nsp-preview-packages"><legend class="screen-reader-text"><?php nsp_te( 'Choose a service package', 'اختر باقة الخدمة' ); ?></legend><div data-preview-packages></div></fieldset>
            <p data-preview-empty hidden><?php nsp_te( 'Packages for this service are not available yet. Contact our team for a tailored quote.', 'باقات هذه الخدمة غير متاحة حالياً. تواصل مع فريقنا للحصول على عرض سعر مخصص.' ); ?></p>
        </div>
        <footer class="nsp-preview-footer">
            <div><span><?php nsp_te( 'SELECTED PACKAGE', 'الباقة المختارة' ); ?></span><strong data-preview-price></strong></div>
            <button type="button" class="nsp-preview-book" data-preview-continue data-nsp-booking><?php nsp_te( 'Book Service', 'احجز الخدمة' ); ?> <span aria-hidden="true">→</span></button>
            <a class="nsp-preview-book" data-preview-quote hidden href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php nsp_te( 'Request a quote', 'اطلب عرض سعر' ); ?> <span aria-hidden="true">→</span></a>
        </footer>
    </div>
</dialog>
