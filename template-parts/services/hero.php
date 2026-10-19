<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$services = $args['services'] ?? nsp_catalog_services();
$is_home_hero = ! empty( $args['home'] );
$hero_services = $is_home_hero ? array_slice( $services, 0, 4 ) : $services;
?>
    <?php if ( $services ) : ?>
    <section id="<?php echo $is_home_hero ? 'clinox-banner-3' : 'nsp-catalog-highlights'; ?>" class="nsp-catalog-hero" data-service-hero <?php if ( $is_home_hero ) : ?>data-background="<?php echo esc_url( $services[0]['image'] ); ?>"<?php endif; ?> aria-roledescription="carousel" aria-label="<?php nsp_ta( 'Service highlights', 'أبرز الخدمات' ); ?>">
        <?php foreach ( $hero_services as $index => $service ) : ?>
        <article data-service-categories="<?php echo esc_attr( implode( ' ', $service['categories'] ?? [] ) ); ?>" data-hero-slide <?php if ( $index ) echo 'hidden'; ?> aria-label="<?php echo esc_attr( $service['title'] ); ?>">
            <img src="<?php echo esc_url( $service['image'] ); ?>" alt="" <?php if ( $index ) echo 'loading="lazy"'; ?>>
            <span class="nsp-hero-quality"><i class="fas fa-check-circle" aria-hidden="true"></i> <?php nsp_te( 'Professional care. Every visit.', 'عناية احترافية في كل زيارة.' ); ?></span>
            <div class="nsp-hero-copy"><div class="nsp-hero-meta"><span class="nsp-badge"><?php nsp_te( 'PROFESSIONAL SERVICE', 'خدمة احترافية' ); ?></span><span><?php echo esc_html( ( $service['price_label'] ?: nsp_catalog_price( $service['price'] ) ) ); ?></span></div><h2><?php echo esc_html( $service['title'] ); ?></h2><p><?php echo esc_html( wp_trim_words( $service['description'], 22 ) ); ?></p><div class="nsp-hero-actions"><?php nsp_booking_button( $service['id'], nsp_t( 'Book Service', 'احجز الخدمة' ), $service['image'] ); ?><?php if ( $is_home_hero ) : ?><a class="nsp-hero-all-services" href="<?php echo esc_url( nsp_post_type_archive_url( 'service', 'services' ) ); ?>"><?php nsp_te( 'View All Services', 'عرض جميع الخدمات' ); ?></a><?php endif; ?></div></div>
        </article>
        <?php endforeach; ?>
        <div class="nsp-hero-dots" role="group" aria-label="<?php nsp_ta( 'Choose a featured service', 'اختر خدمة مميزة' ); ?>"><?php foreach ( $hero_services as $index => $service ) : ?><button type="button" <?php if ( $index >= 4 ) echo 'hidden'; ?> data-hero-dot="<?php echo (int) $index; ?>" aria-pressed="<?php echo $index ? 'false' : 'true'; ?>" aria-label="<?php echo esc_attr( $service['title'] ); ?>"></button><?php endforeach; ?></div>
    </section>
    <?php endif; ?>
