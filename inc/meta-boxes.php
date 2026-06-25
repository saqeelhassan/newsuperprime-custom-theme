<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
   Register meta boxes
   ============================================================ */
function nsp_register_meta_boxes() {
    add_meta_box( 'nsp_post_ar_meta',     esc_html__( 'Arabic Blog Content', 'newsuperprime' ), 'nsp_render_post_ar_meta',     'post',        'normal', 'high' );
    add_meta_box( 'nsp_service_meta',      esc_html__( 'Service Details',     'newsuperprime' ), 'nsp_render_service_meta',      'service',     'normal', 'high' );
    add_meta_box( 'nsp_project_meta',      esc_html__( 'Project Details',     'newsuperprime' ), 'nsp_render_project_meta',      'project',     'normal', 'high' );
    add_meta_box( 'nsp_team_meta',         esc_html__( 'Team Member Details', 'newsuperprime' ), 'nsp_render_team_meta',         'team',        'normal', 'high' );
    add_meta_box( 'nsp_testimonial_meta',  esc_html__( 'Testimonial Details', 'newsuperprime' ), 'nsp_render_testimonial_meta',  'testimonial', 'normal', 'high' );
    add_meta_box( 'nsp_pricing_meta',      esc_html__( 'Pricing Details',     'newsuperprime' ), 'nsp_render_pricing_meta',      'pricing',     'normal', 'high' );
}
add_action( 'add_meta_boxes', 'nsp_register_meta_boxes' );

/* ============================================================
   Blog Arabic content meta box
   ============================================================ */
function nsp_render_post_ar_meta( WP_Post $post ) {
    wp_nonce_field( 'nsp_post_ar_meta_save', 'nsp_post_ar_meta_nonce' );
    $ar_title   = get_post_meta( $post->ID, '_nsp_post_ar_title', true );
    $ar_excerpt = get_post_meta( $post->ID, '_nsp_post_ar_excerpt', true );
    $ar_content = get_post_meta( $post->ID, '_nsp_post_ar_content', true );
    ?>
    <p>
        <label><?php esc_html_e( 'Arabic Title', 'newsuperprime' ); ?></label><br>
        <input type="text" name="_nsp_post_ar_title" value="<?php echo esc_attr( $ar_title ); ?>" class="widefat" dir="rtl">
    </p>
    <p>
        <label><?php esc_html_e( 'Arabic Excerpt / Short Description', 'newsuperprime' ); ?></label><br>
        <textarea name="_nsp_post_ar_excerpt" rows="3" class="widefat" dir="rtl"><?php echo esc_textarea( $ar_excerpt ); ?></textarea>
    </p>
    <p>
        <label><?php esc_html_e( 'Arabic Content', 'newsuperprime' ); ?></label><br>
        <textarea name="_nsp_post_ar_content" rows="8" class="widefat" dir="rtl"><?php echo esc_textarea( $ar_content ); ?></textarea>
    </p>
    <?php
}

/* ============================================================
   Service meta box
   ============================================================ */
function nsp_render_service_meta( WP_Post $post ) {
    wp_nonce_field( 'nsp_service_meta_save', 'nsp_service_meta_nonce' );
    $short_desc = get_post_meta( $post->ID, '_nsp_service_short_desc', true );
    $features   = get_post_meta( $post->ID, '_nsp_service_features', true );
    ?>
    <p>
        <label><?php esc_html_e( 'Short Description', 'newsuperprime' ); ?></label><br>
        <textarea name="_nsp_service_short_desc" rows="3" class="widefat"><?php echo esc_textarea( $short_desc ); ?></textarea>
    </p>
    <p>
        <label><?php esc_html_e( 'Features (one per line)', 'newsuperprime' ); ?></label><br>
        <textarea name="_nsp_service_features" rows="6" class="widefat"><?php echo esc_textarea( $features ); ?></textarea>
    </p>
    <?php
}

/* ============================================================
   Project meta box
   ============================================================ */
function nsp_render_project_meta( WP_Post $post ) {
    wp_nonce_field( 'nsp_project_meta_save', 'nsp_project_meta_nonce' );
    $fields = [
        '_nsp_project_client'     => esc_html__( 'Client',            'newsuperprime' ),
        '_nsp_project_location'   => esc_html__( 'Location',          'newsuperprime' ),
        '_nsp_project_completion' => esc_html__( 'Completion Date',   'newsuperprime' ),
        '_nsp_project_type'       => esc_html__( 'Project Type',      'newsuperprime' ),
        '_nsp_project_cleaner'    => esc_html__( 'Cleaner / Expert',  'newsuperprime' ),
    ];
    foreach ( $fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p><label>' . esc_html( $label ) . '</label><br>';
        echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" class="widefat"></p>';
    }
    $gallery = get_post_meta( $post->ID, '_nsp_project_gallery', true );
    ?>
    <p>
        <label><?php esc_html_e( 'Gallery (comma-separated attachment IDs)', 'newsuperprime' ); ?></label><br>
        <input type="text" name="_nsp_project_gallery" value="<?php echo esc_attr( $gallery ); ?>" class="widefat">
    </p>
    <?php
}

/* ============================================================
   Team meta box
   ============================================================ */
function nsp_render_team_meta( WP_Post $post ) {
    wp_nonce_field( 'nsp_team_meta_save', 'nsp_team_meta_nonce' );
    $text_fields = [
        '_nsp_team_position'    => esc_html__( 'Position / Role',     'newsuperprime' ),
        '_nsp_team_experience'  => esc_html__( 'Years of Experience', 'newsuperprime' ),
        '_nsp_team_speciality'  => esc_html__( 'Speciality',          'newsuperprime' ),
        '_nsp_team_projects'    => esc_html__( 'Projects Completed',  'newsuperprime' ),
        '_nsp_team_email'       => esc_html__( 'Email',               'newsuperprime' ),
        '_nsp_team_phone'       => esc_html__( 'Phone',               'newsuperprime' ),
        '_nsp_team_facebook'    => esc_html__( 'Facebook URL',        'newsuperprime' ),
        '_nsp_team_twitter'     => esc_html__( 'Twitter URL',         'newsuperprime' ),
        '_nsp_team_behance'     => esc_html__( 'Behance URL',         'newsuperprime' ),
        '_nsp_team_youtube'     => esc_html__( 'YouTube URL',         'newsuperprime' ),
    ];
    foreach ( $text_fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p><label>' . esc_html( $label ) . '</label><br>';
        echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" class="widefat"></p>';
    }
    $skills = get_post_meta( $post->ID, '_nsp_team_skills', true );
    ?>
    <p>
        <label><?php esc_html_e( 'Skills (one per line: Label|Percent, e.g. Commercial|92)', 'newsuperprime' ); ?></label><br>
        <textarea name="_nsp_team_skills" rows="5" class="widefat"><?php echo esc_textarea( $skills ); ?></textarea>
    </p>
    <?php
}

/* ============================================================
   Testimonial meta box
   ============================================================ */
function nsp_render_testimonial_meta( WP_Post $post ) {
    wp_nonce_field( 'nsp_testimonial_meta_save', 'nsp_testimonial_meta_nonce' );
    $role   = get_post_meta( $post->ID, '_nsp_testimonial_role',   true );
    $photo  = get_post_meta( $post->ID, '_nsp_testimonial_photo',  true );
    $rating = get_post_meta( $post->ID, '_nsp_testimonial_rating', true );
    ?>
    <p>
        <label><?php esc_html_e( 'Role / Title (e.g. CEO, Gatko)', 'newsuperprime' ); ?></label><br>
        <input type="text" name="_nsp_testimonial_role" value="<?php echo esc_attr( $role ); ?>" class="widefat">
    </p>
    <p>
        <label><?php esc_html_e( 'Photo (attachment ID)', 'newsuperprime' ); ?></label><br>
        <input type="number" name="_nsp_testimonial_photo" value="<?php echo esc_attr( $photo ); ?>" class="widefat">
    </p>
    <p>
        <label><?php esc_html_e( 'Rating (1–5)', 'newsuperprime' ); ?></label><br>
        <input type="number" name="_nsp_testimonial_rating" min="1" max="5" value="<?php echo esc_attr( $rating ); ?>" class="widefat">
    </p>
    <?php
}

/* ============================================================
   Pricing meta box
   ============================================================ */
function nsp_render_pricing_meta( WP_Post $post ) {
    wp_nonce_field( 'nsp_pricing_meta_save', 'nsp_pricing_meta_nonce' );
    $price    = get_post_meta( $post->ID, '_nsp_pricing_price',    true );
    $icon     = get_post_meta( $post->ID, '_nsp_pricing_icon',     true );
    $features = get_post_meta( $post->ID, '_nsp_pricing_features', true );
    $cta_url  = get_post_meta( $post->ID, '_nsp_pricing_cta_url',  true );
    $featured = get_post_meta( $post->ID, '_nsp_pricing_featured', true );
    ?>
    <p>
        <label><?php esc_html_e( 'Price (e.g. $29.99)', 'newsuperprime' ); ?></label><br>
        <input type="text" name="_nsp_pricing_price" value="<?php echo esc_attr( $price ); ?>" class="widefat">
    </p>
    <p>
        <label><?php esc_html_e( 'Icon (attachment ID)', 'newsuperprime' ); ?></label><br>
        <input type="number" name="_nsp_pricing_icon" value="<?php echo esc_attr( $icon ); ?>" class="widefat">
    </p>
    <p>
        <label><?php esc_html_e( 'Features (one per line)', 'newsuperprime' ); ?></label><br>
        <textarea name="_nsp_pricing_features" rows="6" class="widefat"><?php echo esc_textarea( $features ); ?></textarea>
    </p>
    <p>
        <label><?php esc_html_e( 'CTA Button URL', 'newsuperprime' ); ?></label><br>
        <input type="url" name="_nsp_pricing_cta_url" value="<?php echo esc_attr( $cta_url ); ?>" class="widefat">
    </p>
    <p>
        <label>
            <input type="checkbox" name="_nsp_pricing_featured" value="1" <?php checked( $featured, '1' ); ?>>
            <?php esc_html_e( 'Featured plan (highlighted)', 'newsuperprime' ); ?>
        </label>
    </p>
    <?php
}

/* ============================================================
   Save all meta boxes
   ============================================================ */
function nsp_save_meta_boxes( int $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $post_type = get_post_type( $post_id );

    // --- Blog Arabic content ---
    if ( 'post' === $post_type && isset( $_POST['nsp_post_ar_meta_nonce'] )
        && wp_verify_nonce( sanitize_key( $_POST['nsp_post_ar_meta_nonce'] ), 'nsp_post_ar_meta_save' ) ) {
        update_post_meta( $post_id, '_nsp_post_ar_title', sanitize_text_field( wp_unslash( $_POST['_nsp_post_ar_title'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_post_ar_excerpt', sanitize_textarea_field( wp_unslash( $_POST['_nsp_post_ar_excerpt'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_post_ar_content', wp_kses_post( wp_unslash( $_POST['_nsp_post_ar_content'] ?? '' ) ) );
    }

    // --- Service ---
    if ( 'service' === $post_type && isset( $_POST['nsp_service_meta_nonce'] )
        && wp_verify_nonce( sanitize_key( $_POST['nsp_service_meta_nonce'] ), 'nsp_service_meta_save' ) ) {
        update_post_meta( $post_id, '_nsp_service_short_desc', sanitize_textarea_field( wp_unslash( $_POST['_nsp_service_short_desc'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_service_features', sanitize_textarea_field( wp_unslash( $_POST['_nsp_service_features'] ?? '' ) ) );
    }

    // --- Project ---
    if ( 'project' === $post_type && isset( $_POST['nsp_project_meta_nonce'] )
        && wp_verify_nonce( sanitize_key( $_POST['nsp_project_meta_nonce'] ), 'nsp_project_meta_save' ) ) {
        $project_text_keys = [
            '_nsp_project_client', '_nsp_project_location', '_nsp_project_completion',
            '_nsp_project_type',   '_nsp_project_cleaner',
        ];
        foreach ( $project_text_keys as $key ) {
            update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
        }
        update_post_meta( $post_id, '_nsp_project_gallery', sanitize_text_field( wp_unslash( $_POST['_nsp_project_gallery'] ?? '' ) ) );
    }

    // --- Team ---
    if ( 'team' === $post_type && isset( $_POST['nsp_team_meta_nonce'] )
        && wp_verify_nonce( sanitize_key( $_POST['nsp_team_meta_nonce'] ), 'nsp_team_meta_save' ) ) {
        $team_text_keys = [
            '_nsp_team_position', '_nsp_team_experience', '_nsp_team_speciality',
            '_nsp_team_projects', '_nsp_team_email',      '_nsp_team_phone',
        ];
        foreach ( $team_text_keys as $key ) {
            update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
        }
        $url_keys = [ '_nsp_team_facebook', '_nsp_team_twitter', '_nsp_team_behance', '_nsp_team_youtube' ];
        foreach ( $url_keys as $key ) {
            update_post_meta( $post_id, $key, esc_url_raw( wp_unslash( $_POST[ $key ] ?? '' ) ) );
        }
        update_post_meta( $post_id, '_nsp_team_skills', sanitize_textarea_field( wp_unslash( $_POST['_nsp_team_skills'] ?? '' ) ) );
    }

    // --- Testimonial ---
    if ( 'testimonial' === $post_type && isset( $_POST['nsp_testimonial_meta_nonce'] )
        && wp_verify_nonce( sanitize_key( $_POST['nsp_testimonial_meta_nonce'] ), 'nsp_testimonial_meta_save' ) ) {
        update_post_meta( $post_id, '_nsp_testimonial_role',   sanitize_text_field( wp_unslash( $_POST['_nsp_testimonial_role'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_testimonial_photo',  absint( $_POST['_nsp_testimonial_photo'] ?? 0 ) );
        update_post_meta( $post_id, '_nsp_testimonial_rating', min( 5, max( 1, absint( $_POST['_nsp_testimonial_rating'] ?? 5 ) ) ) );
    }

    // --- Pricing ---
    if ( 'pricing' === $post_type && isset( $_POST['nsp_pricing_meta_nonce'] )
        && wp_verify_nonce( sanitize_key( $_POST['nsp_pricing_meta_nonce'] ), 'nsp_pricing_meta_save' ) ) {
        update_post_meta( $post_id, '_nsp_pricing_price',    sanitize_text_field( wp_unslash( $_POST['_nsp_pricing_price'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_pricing_icon',     absint( $_POST['_nsp_pricing_icon'] ?? 0 ) );
        update_post_meta( $post_id, '_nsp_pricing_features', sanitize_textarea_field( wp_unslash( $_POST['_nsp_pricing_features'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_pricing_cta_url',  esc_url_raw( wp_unslash( $_POST['_nsp_pricing_cta_url'] ?? '' ) ) );
        update_post_meta( $post_id, '_nsp_pricing_featured', isset( $_POST['_nsp_pricing_featured'] ) ? '1' : '0' );
    }
}
add_action( 'save_post', 'nsp_save_meta_boxes' );
