<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$services = $args['services'] ?? nsp_catalog_services();
$featured_attrs = function ( array $service ) {
    $extra = '';
    foreach ( $service['packages'] as $package ) $extra .= ' ' . $package['package_name'] . ' ' . ( $package['package_description'] ?? '' );
    return 'data-service-categories="' . esc_attr( implode( ' ', $service['categories'] ?? [] ) ) . '" data-catalog-item data-service-key="' . (int) $service['id'] . '" data-search="' . esc_attr( $service['title'] . ' ' . $service['description'] . $extra ) . '"';
};
?>
    <section id="nsp-featured" class="nsp-catalog-section" data-results-section>
        <div class="nsp-section-heading"><div><h2><?php nsp_te( 'Featured Services', 'خدماتنا المميزة' ); ?></h2><p class="nsp-eyebrow"><?php nsp_te( 'CLEAR PRICING · PROFESSIONAL WORK', 'أسعار واضحة · عمل احترافي' ); ?></p></div><div class="nsp-rail-controls"><button type="button" data-rail-prev="featured" aria-label="<?php nsp_ta( 'Previous services', 'الخدمات السابقة' ); ?>">←</button><button type="button" data-rail-next="featured" aria-label="<?php nsp_ta( 'Next services', 'الخدمات التالية' ); ?>">→</button></div></div>
        <div class="nsp-featured-rail" data-rail="featured">
        <?php foreach ( $services as $service ) : ?>
            <article class="nsp-service-card" <?php echo $featured_attrs( $service ); ?>>
                <a class="nsp-service-photo" href="<?php echo esc_url( $service['url'] ); ?>"><img src="<?php echo esc_url( $service['image'] ); ?>" alt="<?php echo esc_attr( $service['title'] ); ?>" loading="lazy"><span class="nsp-badge"><?php nsp_te( 'PROFESSIONAL CARE', 'عناية احترافية' ); ?></span></a>
                <div class="nsp-service-card-body"><h3><a href="<?php echo esc_url( $service['url'] ); ?>"><?php echo esc_html( $service['title'] ); ?></a></h3><p><?php echo esc_html( $service['description'] ); ?></p><div class="nsp-service-card-bottom"><div><span class="nsp-eyebrow"><?php nsp_te( 'STARTING FROM', 'ابتداءً من' ); ?></span><strong><?php echo esc_html( ( $service['price_label'] ?: nsp_catalog_price( $service['price'] ) ) ); ?></strong></div><?php nsp_booking_button( $service['id'], nsp_t( 'Book Now', 'احجز الآن' ), $service['image'] ); ?></div></div>
            </article>
        <?php endforeach; ?>
        </div>
    </section>
