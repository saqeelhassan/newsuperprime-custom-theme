<?php if ( ! defined( 'ABSPATH' ) ) exit; $booking_services = nsp_catalog_services(); ?>
<section id="clinox-estimate" class="clinox-estimate-section nsp-home-booking-bar" aria-labelledby="nsp-quick-booking-title">
    <div class="container">
        <div class="nsp-quick-booking-heading"><h2 id="nsp-quick-booking-title"><?php nsp_te( 'Book a Service', 'احجز خدمة' ); ?></h2><p><?php nsp_te( 'Choose your service and city to start your booking.', 'اختر الخدمة والمدينة لبدء الحجز.' ); ?></p></div>
        <div class="nsp-home-booking-controls">
            <label for="nsp-quick-service"><?php nsp_te( 'Service', 'الخدمة' ); ?><select id="nsp-quick-service" required><option value=""><?php nsp_te( 'Choose a service', 'اختر الخدمة' ); ?></option><?php foreach ( $booking_services as $index=>$service ) : ?><option value="<?php echo (int) $index; ?>"><?php echo esc_html( $service['title'] ); ?></option><?php endforeach; ?></select></label>
            <label for="nsp-quick-city"><?php nsp_te( 'Service area', 'منطقة الخدمة' ); ?><select id="nsp-quick-city"><?php foreach ( [ 'Dammam'=>'الدمام', 'Khobar'=>'الخبر', 'Jubail'=>'الجبيل', 'Ras Tanura'=>'رأس تنورة' ] as $city=>$arabic ) : ?><option value="<?php echo esc_attr( $city ); ?>"><?php nsp_te( $city, $arabic ); ?></option><?php endforeach; ?></select></label>
            <button type="button" data-home-booking-submit disabled aria-haspopup="dialog" aria-controls="nsp-service-preview"><?php nsp_te( 'Book Now', 'احجز الآن' ); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
        </div>
        <template id="nsp-quick-booking-data"><?php foreach ( $booking_services as $service ) nsp_booking_button( $service['id'], nsp_t( 'Book Now', 'احجز الآن' ), $service['image'] ); ?></template>
    </div>
</section>
