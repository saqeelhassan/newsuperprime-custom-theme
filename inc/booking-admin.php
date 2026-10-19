<?php
/** Native WordPress service package editor; no field plugin required. */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'add_meta_boxes_service', function () {
    add_meta_box( 'nsp-booking-packages', __( 'Booking Packages', 'newsuperprime' ), 'nsp_booking_packages_editor', 'service', 'normal', 'high' );
} );

function nsp_booking_package_row( $index, array $row = [] ): void {
    ?>
    <fieldset class="nsp-package-row" style="border:1px solid #c3c4c7;padding:16px;margin:16px 0;background:#fff;">
        <legend><strong><?php esc_html_e( 'Service package', 'newsuperprime' ); ?></strong></legend>
        <p><label><?php esc_html_e( 'Package name (required)', 'newsuperprime' ); ?><br>
            <input class="widefat" type="text" name="nsp_booking_packages[<?php echo esc_attr( $index ); ?>][package_name]" value="<?php echo esc_attr( $row['package_name'] ?? '' ); ?>" maxlength="150" required>
        </label></p>
        <p><label><?php esc_html_e( 'Regular price in SAR (required)', 'newsuperprime' ); ?><br>
            <input type="number" name="nsp_booking_packages[<?php echo esc_attr( $index ); ?>][package_price]" value="<?php echo esc_attr( $row['package_price'] ?? '' ); ?>" min="0" max="99999999" step="0.01" required>
        </label></p>
        <p><label><?php esc_html_e( 'Description', 'newsuperprime' ); ?><br>
            <textarea class="widefat" rows="3" name="nsp_booking_packages[<?php echo esc_attr( $index ); ?>][package_description]" maxlength="2000"><?php echo esc_textarea( $row['package_description'] ?? '' ); ?></textarea>
        </label></p>
        <p><label><?php esc_html_e( 'Perk / included benefit', 'newsuperprime' ); ?><br>
            <input class="widefat" type="text" name="nsp_booking_packages[<?php echo esc_attr( $index ); ?>][package_perk]" value="<?php echo esc_attr( $row['package_perk'] ?? '' ); ?>" maxlength="300">
        </label></p>
        <button type="button" class="button-link-delete" data-remove-package><?php esc_html_e( 'Remove package', 'newsuperprime' ); ?></button>
    </fieldset>
    <?php
}

function nsp_booking_packages_editor( WP_Post $post ): void {
    wp_nonce_field( 'nsp_booking_packages_save', 'nsp_booking_packages_nonce' );
    $basis = get_post_meta( $post->ID, '_nsp_price_basis', true );
    echo '<p><label>Pricing basis <select name="nsp_price_basis">';
    foreach ( [ ''=>'Package prices', 'hourly'=>'45 SAR per hour (minimum 3 hours)', 'size'=>'Price depends on size', 'quote'=>'Price on request' ] as $value=>$label ) {
        echo '<option value="' . esc_attr($value) . '" ' . selected($basis, $value, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select></label></p><p class="description">For size-based or quote pricing, remove package rows. Hourly package prices are the total for the selected hours.</p>';
    $rows = array_values( nsp_booking_packages( $post->ID ) );
    ?>
    <div id="nsp-packages-editor" data-next-index="<?php echo count( $rows ); ?>">
        <p><?php esc_html_e( 'Add the packages customers can choose after clicking Book Service. Update or publish this service to save your changes.', 'newsuperprime' ); ?></p>
        <p class="description"><?php esc_html_e( 'Use the regular price. The booking form applies the 10% First Booking Benefit automatically. Your service title, featured image, and category appear at the top of the form.', 'newsuperprime' ); ?></p>
        <div data-package-rows>
            <?php foreach ( $rows as $index => $row ) nsp_booking_package_row( $index, $row ); ?>
        </div>
        <p data-empty-packages <?php if ( $rows ) echo 'hidden'; ?>><?php esc_html_e( 'No packages yet. Add a package to enable booking for this service.', 'newsuperprime' ); ?></p>
        <button type="button" class="button button-secondary" data-add-package><?php esc_html_e( 'Add package', 'newsuperprime' ); ?></button>
        <template data-package-template><?php nsp_booking_package_row( '__INDEX__' ); ?></template>
    </div>
    <?php
}

add_action( 'admin_enqueue_scripts', function () {
    $screen = get_current_screen();
    if ( ! $screen || 'post' !== $screen->base || 'service' !== $screen->post_type ) return;
    $file = '/assets/js/booking-admin.js';
    wp_enqueue_script( 'nsp-booking-admin', NSP_THEME_URI . $file, [], filemtime( NSP_THEME_DIR . $file ), true );
} );

function nsp_save_booking_packages( int $post_id ): void {
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) return;
    if ( 'service' !== get_post_type( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( ! isset( $_POST['nsp_booking_packages_nonce'] ) || ! is_string( $_POST['nsp_booking_packages_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nsp_booking_packages_nonce'] ) ), 'nsp_booking_packages_save' ) ) return;

    $rows = wp_unslash( $_POST['nsp_booking_packages'] ?? [] );
    $packages = [];
    $invalid = ! is_array( $rows );
    foreach ( is_array( $rows ) ? $rows : [] as $row ) {
        if ( ! is_array( $row ) ) { $invalid = true; break; }
        foreach ( [ 'package_name', 'package_price', 'package_description', 'package_perk' ] as $key ) {
            if ( isset( $row[ $key ] ) && ! is_scalar( $row[ $key ] ) ) { $invalid = true; break 2; }
        }
        $name = sanitize_text_field( $row['package_name'] ?? '' );
        $price = $row['package_price'] ?? '';
        if ( '' === $name || ! is_numeric( $price ) || ! is_finite( (float) $price ) || (float) $price < 0 || (float) $price > 99999999 ) { $invalid = true; break; }
        $packages[] = [
            'package_name' => $name,
            'package_price' => round( (float) $price, 2 ),
            'package_description' => sanitize_textarea_field( $row['package_description'] ?? '' ),
            'package_perk' => sanitize_text_field( $row['package_perk'] ?? '' ),
        ];
    }
    if ( $invalid ) {
        set_transient( 'nsp_packages_error_' . get_current_user_id(), $post_id, 60 );
        return; // Keep the previously saved packages when validation fails.
    }
    update_post_meta( $post_id, '_nsp_booking_packages', $packages );
    if ( isset($_POST['nsp_price_basis']) && is_string($_POST['nsp_price_basis']) && in_array($_POST['nsp_price_basis'], ['', 'hourly', 'size', 'quote'], true) ) update_post_meta($post_id, '_nsp_price_basis', $_POST['nsp_price_basis']);
}
add_action( 'save_post_service', 'nsp_save_booking_packages' );

add_action( 'admin_notices', function () {
    $key = 'nsp_packages_error_' . get_current_user_id();
    $post_id = get_transient( $key );
    if ( ! $post_id ) return;
    delete_transient( $key );
    echo '<div class="notice notice-error"><p>' . esc_html__( 'Booking packages were not saved. Each package needs a name and a valid nonnegative SAR price up to 99,999,999. Previously saved packages have been kept. Re-enter your changes and update the service.', 'newsuperprime' ) . '</p></div>';
} );
