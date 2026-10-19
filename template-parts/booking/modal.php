<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<dialog id="nsp-booking" aria-labelledby="nsp-booking-title" aria-describedby="nsp-step-count" lang="en" dir="ltr">
    <form id="nsp-booking-form" novalidate class="tw-flex tw-max-h-[92dvh] tw-flex-col">
        <header class="tw-shrink-0 tw-border-0 tw-border-b tw-border-solid tw-border-slate-200 tw-p-6">
            <div class="tw-flex tw-items-start tw-gap-4">
                <button type="button" data-back hidden aria-label="<?php echo esc_attr( nsp_t( __( 'Previous step', 'newsuperprime' ), __( 'الخطوة السابقة', 'newsuperprime' ) ) ); ?>" class="tw-rounded-full tw-border-0 tw-bg-mist tw-p-2 tw-text-ink">←</button>
                <div class="tw-flex-1">
                    <p id="nsp-step-count" data-step-count class="tw-text-xs tw-font-bold tw-tracking-widest tw-text-prime" aria-live="polite">STEP 1 OF 5</p>
                    <h2 id="nsp-booking-title" tabindex="-1">Select service &amp; package</h2>
                </div>
                <button type="button" data-close aria-label="<?php echo esc_attr( nsp_t( __( 'Close booking', 'newsuperprime' ), __( 'إغلاق الحجز', 'newsuperprime' ) ) ); ?>" class="tw-rounded-full tw-border-0 tw-bg-mist tw-px-3 tw-py-1 tw-text-2xl tw-text-ink">×</button>
            </div>
            <div role="group" data-progress class="tw-mt-4 tw-flex tw-gap-2" aria-label="Booking progress">
                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                    <span role="img" data-dot class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-slate-200" aria-label="Step <?php echo (int) $i; ?>"></span>
                <?php endfor; ?>
            </div>
        </header>
        <div class="tw-overflow-y-auto tw-p-6" data-body>
            <section data-step="1" class="tw-space-y-5">
                <div class="tw-flex tw-items-center tw-gap-4 tw-rounded-xl tw-bg-mist tw-p-4">
                    <img data-service-image alt="" width="80" height="80" decoding="async" loading="lazy" class="tw-h-20 tw-w-20 tw-rounded-lg tw-object-cover">
                    <div><span data-service-category class="tw-text-xs tw-font-bold tw-uppercase tw-tracking-wide tw-text-prime"></span><h3 data-service-title></h3></div>
                </div>
                <fieldset class="tw-m-0 tw-min-w-0 tw-border-0 tw-p-0"><legend class="tw-mb-3 tw-text-base tw-font-bold">Choose your package</legend><div data-packages class="tw-space-y-3"></div></fieldset>
            </section>
            <section data-step="2" hidden class="tw-space-y-5">
                <fieldset class="tw-m-0 tw-border-0 tw-p-0"><legend class="tw-mb-3 tw-font-bold">Select your city</legend><div class="tw-flex tw-flex-wrap tw-gap-2">
                    <?php foreach ( [ 'Khobar', 'Dammam', 'Jubail', 'Ras Tanura' ] as $city ) : ?>
                        <label class="tw-flex tw-cursor-pointer tw-items-center tw-gap-2 tw-rounded-full tw-border tw-border-solid tw-border-slate-300 tw-px-4 tw-py-2"><input type="radio" name="city" value="<?php echo esc_attr( $city ); ?>"> <?php echo esc_html( $city ); ?></label>
                    <?php endforeach; ?>
                </div></fieldset>
                <div class="tw-rounded-xl tw-bg-mist tw-p-4 tw-space-y-3">
                    <h3>Use your current location</h3>
                    <button type="button" data-gps class="tw-rounded-lg tw-border tw-border-solid tw-border-prime tw-bg-white tw-px-4 tw-py-2 tw-font-bold tw-text-prime">Capture GPS location</button>
                    <button type="button" data-clear-gps hidden class="tw-border-0 tw-bg-transparent tw-text-ink tw-underline">Use a typed address instead</button>
                    <p data-gps-status role="status" class="tw-text-sm">Allow location access, or enter your address below.</p>
                </div>
                <div data-address class="tw-space-y-4">
                    <p class="tw-text-sm tw-text-slate-600">Or enter your address</p>
                    <label class="tw-block tw-font-medium" for="nsp-street">Street address<input id="nsp-street" name="street" autocomplete="street-address" maxlength="240" class="tw-mt-1"></label>
                    <label class="tw-block tw-font-medium" for="nsp-area">Area / neighborhood<input id="nsp-area" name="area" autocomplete="address-line2" maxlength="120" class="tw-mt-1"></label>
                </div>
            </section>
            <section data-step="3" hidden class="tw-space-y-5">
                <label class="tw-block tw-font-medium" for="nsp-date">Preferred date<input id="nsp-date" name="date" type="date" class="tw-mt-2"></label>
                <fieldset class="tw-m-0 tw-border-0 tw-p-0"><legend class="tw-mb-3 tw-font-bold">Preferred time slot</legend><div class="tw-grid tw-gap-3 sm:tw-grid-cols-3">
                    <?php foreach ( [ '9AM–12PM', '1PM–4PM', '4PM–7PM' ] as $slot ) : ?>
                        <label class="tw-flex tw-cursor-pointer tw-items-center tw-gap-2 tw-rounded-xl tw-border tw-border-solid tw-border-slate-300 tw-p-3"><input type="radio" name="time" value="<?php echo esc_attr( $slot ); ?>"> <?php echo esc_html( $slot ); ?></label>
                    <?php endforeach; ?>
                </div></fieldset>
                <p class="tw-text-sm tw-text-slate-600">Times are in Saudi Arabia time. Our team will confirm availability.</p>
            </section>
            <section data-step="4" hidden class="tw-space-y-4">
                <label class="tw-block tw-font-medium" for="nsp-name">Full name<input id="nsp-name" name="fullName" autocomplete="name" maxlength="100" class="tw-mt-1"></label>
                <label class="tw-block tw-font-medium" for="nsp-mobile">WhatsApp / mobile number<input id="nsp-mobile" name="mobile" type="tel" autocomplete="tel" placeholder="+966 5X XXX XXXX" maxlength="30" class="tw-mt-1"></label>
                <fieldset class="tw-m-0 tw-border-0 tw-p-0"><legend class="tw-mb-2 tw-font-bold">Preferred contact method</legend><div class="tw-flex tw-gap-3">
                    <?php foreach ( [ 'WhatsApp', 'Phone Call' ] as $method ) : ?>
                        <label class="tw-flex tw-cursor-pointer tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-solid tw-border-slate-300 tw-p-3"><input type="radio" name="contactMethod" value="<?php echo esc_attr( $method ); ?>" <?php checked( $method, 'WhatsApp' ); ?>> <?php echo esc_html( $method ); ?></label>
                    <?php endforeach; ?>
                </div></fieldset>
                <label class="tw-block tw-font-medium" for="nsp-instructions">Special instructions <span class="tw-font-normal tw-text-slate-500">(optional)</span><textarea id="nsp-instructions" name="instructions" rows="3" maxlength="1500" class="tw-mt-1"></textarea></label>
            </section>
            <section data-step="5" hidden class="tw-space-y-5">
                <div class="tw-rounded-xl tw-bg-mist tw-p-4"><p class="tw-text-xs tw-font-bold tw-uppercase tw-tracking-widest">Your booking reference</p><p data-reference class="tw-font-mono tw-text-xl tw-font-bold tw-text-prime"></p></div>
                <dl data-summary class="tw-m-0 tw-space-y-3"></dl>
                <div class="tw-space-y-3 tw-rounded-xl tw-bg-mist tw-p-4">
                    <div class="tw-flex tw-justify-between"><span>Regular price</span><span data-regular></span></div>
                    <div class="tw-flex tw-justify-between tw-gap-3 tw-text-prime"><span>First Booking Benefit (10%)</span><span data-discount></span></div>
                    <div class="tw-flex tw-justify-between tw-text-xl tw-font-bold"><span>Final price</span><span data-total></span></div>
                </div>
                <p class="tw-text-sm tw-text-slate-600">Send this request to our team on WhatsApp. Your booking is confirmed after our team replies.</p>
            </section>
            <p data-error role="alert" hidden class="tw-mt-4 tw-rounded-lg tw-bg-red-50 tw-p-3 tw-text-sm tw-text-red-700"></p>
        </div>
        <footer class="tw-shrink-0 tw-border-0 tw-border-t tw-border-solid tw-border-slate-200 tw-p-5">
            <button type="submit" data-next class="tw-w-full tw-rounded-xl tw-border-0 tw-bg-prime tw-px-4 tw-py-4 tw-font-bold tw-text-white">Continue →</button>
        </footer>
    </form>
</dialog>
