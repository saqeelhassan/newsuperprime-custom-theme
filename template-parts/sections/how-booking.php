<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$booking_steps = [
    [ 'fas fa-layer-group', 'Choose a package', 'اختر الباقة', 'Find the right service for your space.', 'اختر الخدمة المناسبة لمساحتك.' ],
    [ 'fas fa-map-marker-alt', 'Set your location', 'حدد موقعك', 'Share your address or pin your location.', 'أضف عنوانك أو حدد موقعك على الخريطة.' ],
    [ 'far fa-calendar-alt', 'Pick a date', 'اختر الموعد', 'Choose your preferred day and time.', 'اختر اليوم والوقت المناسبين لك.' ],
    [ 'far fa-user', 'Add your details', 'أضف بياناتك', 'Tell us how to reach you and what you need.', 'أخبرنا كيف نتواصل معك وما تحتاجه.' ],
    [ 'fab fa-whatsapp', 'Send on WhatsApp', 'أرسل عبر واتساب', 'Review your request. Our team will confirm.', 'راجع طلبك وسيؤكد فريقنا التفاصيل.' ],
];
?>
<section id="clinox-how-work-3" class="nsp-home-booking" aria-labelledby="nsp-home-booking-title">
    <div class="container">
        <div class="nsp-booking-process-heading">
            <p class="nsp-booking-process-eyebrow"><?php nsp_te( 'HOW WE WORK', 'كيف نعمل' ); ?></p>
            <h2 id="nsp-home-booking-title"><?php nsp_te( 'How Booking Works', 'كيف تحجز خدماتنا' ); ?></h2>
            <p><?php nsp_te( 'Your next clean, in five simple steps.', 'خدمتك القادمة في خمس خطوات بسيطة.' ); ?></p>
        </div>
        <ol class="nsp-booking-process">
            <?php foreach ( $booking_steps as $index => $step ) : ?>
                <li>
                    <div class="nsp-booking-step-icon"><i class="<?php echo esc_attr( $step[0] ); ?>" aria-hidden="true"></i><span aria-hidden="true"><?php echo (int) $index + 1; ?></span></div>
                    <h3><?php nsp_te( $step[1], $step[2] ); ?></h3>
                    <p><?php nsp_te( $step[3], $step[4] ); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
