<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
    $service_title = nsp_service_ar( get_the_title(), 'title' ) ?: html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' );
    nsp_breadcrumb( '', $service_title );
    ?>
    <section class="page-section-padding"><div class="container">
        <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'nsp-service' ); ?>
        <h1><?php echo esc_html( $service_title ); ?></h1>
        <?php $service_description = nsp_service_ar( get_the_title(), 'desc' );
        if ( $service_description ) echo wpautop( esc_html( $service_description ) );
        else the_content(); ?>
        <?php nsp_booking_button( get_the_ID() ); ?>
    </div></section>
<?php endwhile;
get_footer();
