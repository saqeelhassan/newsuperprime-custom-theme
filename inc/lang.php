<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Cookie-based two-language system — no plugin required.
 * Arabic is the primary (default) language; English is secondary.
 *
 * Usage in templates:
 *   nsp_te( 'Book Now', 'احجز الآن' );          // echo escaped
 *   echo esc_url( nsp_t( '/contact/', '/ar/contact/' ) ); // return
 */

// ── Language detection ────────────────────────────────────────────────────

function nsp_current_lang(): string {
    if ( isset( $_GET['lang'] ) ) {
        $requested = sanitize_key( wp_unslash( $_GET['lang'] ) );
        if ( in_array( $requested, [ 'ar', 'en' ], true ) ) {
            return $requested;
        }
    }

    if ( isset( $_COOKIE['nsp_lang'] ) && in_array( $_COOKIE['nsp_lang'], [ 'ar', 'en' ], true ) ) {
        return $_COOKIE['nsp_lang'];
    }
    return 'ar'; // Arabic is the default
}

function nsp_is_arabic(): bool {
    return nsp_current_lang() === 'ar';
}

// Process ?lang= switch early — before any output.
add_action( 'init', function () {
    if ( is_admin() ) return;
    if ( ! isset( $_GET['lang'] ) ) return;
    $requested = sanitize_key( wp_unslash( $_GET['lang'] ) );
    if ( ! in_array( $requested, [ 'ar', 'en' ], true ) ) return;

    $lang = $requested;

    // Set the cookie for future requests
    $cookie_args = [
        'expires'  => time() + 30 * DAY_IN_SECONDS,
        'path'     => defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/',
        'secure'   => is_ssl(),
        'httponly' => true,
        'samesite' => 'Lax',
    ];
    if ( defined( 'COOKIE_DOMAIN' ) && COOKIE_DOMAIN ) {
        $cookie_args['domain'] = COOKIE_DOMAIN;
    }
    setcookie( 'nsp_lang', $lang, $cookie_args );

    // Also update $_COOKIE so nsp_current_lang() returns the correct
    // value if anything runs after this on the same request.
    $_COOKIE['nsp_lang'] = $lang;
} );

// ── Cache compatibility ──────────────────────────────────────────────────
// The HTML output changes based on the nsp_lang cookie (different CSS,
// different text). Caching plugins must store separate versions per language.

/**
 * 1. HTTP Vary header — tells CDNs / reverse-proxies (Cloudflare, Varnish,
 *    LiteSpeed, nginx fastcgi_cache) that the response varies by cookie.
 */
add_filter( 'wp_headers', function ( $headers ) {
    if ( ! is_admin() ) {
        $headers['Vary'] = 'Cookie';
    }
    return $headers;
} );

/**
 * 2. LiteSpeed Cache — register nsp_lang as a vary cookie so LSCache
 *    stores one cached copy per language value.
 */
add_action( 'litespeed_init', function () {
    if ( method_exists( 'LiteSpeed\Vary', 'add' ) ) {
        // LiteSpeed Cache v4+
        do_action( 'litespeed_vary_add', 'nsp_lang' );
    }
} );
add_filter( 'litespeed_vary_cookies', function ( $cookies ) {
    $cookies[] = 'nsp_lang';
    return array_unique( $cookies );
} );

/**
 * 3. WP Super Cache — tell it to not cache when nsp_lang cookie is present.
 *    (WP Super Cache doesn't support per-cookie variants — only reject.)
 */
add_filter( 'wpsc_reject_cookie', function ( $cookies ) {
    $cookies[] = 'nsp_lang';
    return $cookies;
} );

/**
 * 4. Universal fallback — DONOTCACHEPAGE constant. Respected by
 *    WP Super Cache, W3 Total Cache, WP Rocket, WP Fastest Cache, etc.
 *    Only set when the visitor has actively chosen a language (cookie exists).
 */
if ( ! is_admin() && ( isset( $_COOKIE['nsp_lang'] ) || isset( $_GET['lang'] ) ) && ! defined( 'DONOTCACHEPAGE' ) ) {
    define( 'DONOTCACHEPAGE', true );
}

// ── Translation helpers ───────────────────────────────────────────────────

/**
 * Return $ar when Arabic is active, $en otherwise.
 */
function nsp_t( string $en, string $ar ): string {
    return nsp_is_arabic() ? $ar : $en;
}

/**
 * Echo the translated string, HTML-escaped.
 */
function nsp_te( string $en, string $ar ): void {
    echo esc_html( nsp_t( $en, $ar ) );
}

/**
 * Echo the translated string as an attribute value, escaped.
 */
function nsp_ta( string $en, string $ar ): void {
    echo esc_attr( nsp_t( $en, $ar ) );
}

// ── HTML <html> attributes ────────────────────────────────────────────────

add_filter( 'language_attributes', function ( $output ) {
    if ( is_admin() ) return $output;
    return nsp_is_arabic() ? 'dir="rtl" lang="ar"' : 'dir="ltr" lang="en"';
}, 20 );

// ── Body classes ──────────────────────────────────────────────────────────

add_filter( 'body_class', function ( $classes ) {
    if ( is_admin() ) return $classes;
    $classes[] = nsp_is_arabic() ? 'lang-ar' : 'lang-en';
    return $classes;
} );

// ── Nav menu title translation ────────────────────────────────────────────

/**
 * Translate a menu item label to Arabic when Arabic is active.
 * Called directly from NSP_Nav_Walker::start_el().
 */
function nsp_translate_menu_title( string $title ): string {
    if ( ! nsp_is_arabic() ) return $title;

    static $map = [
        'Home'              => 'الرئيسية',
        'About'             => 'من نحن',
        'About Us'          => 'من نحن',
        'Services'          => 'خدماتنا',
        'Our Services'      => 'خدماتنا',
        'Home Cleaning'             => 'تنظيف المنازل',
        'Home Cleaning Service'     => 'خدمة تنظيف المنازل',
        'Office Cleaning'           => 'تنظيف المكاتب',
        'Office Cleaning Service'   => 'خدمة تنظيف المكاتب',
        'Pest Control'              => 'مكافحة الحشرات',
        'Pest Control Service'      => 'خدمة مكافحة الحشرات',
        'AC Maintenance'            => 'صيانة المكيفات',
        'AC Maintenance Service'    => 'خدمة صيانة المكيفات',
        'Home Shifting'             => 'نقل العفش',
        'Home Shifting Service'     => 'خدمة نقل العفش',
        'Car Wash'                  => 'غسيل السيارات',
        'Car Wash Service'          => 'خدمة غسيل السيارات',
        'Deep Cleaning'             => 'التنظيف العميق',
        'Deep Cleaning Service'     => 'خدمة التنظيف العميق',
        'Carpet Cleaning'           => 'تنظيف السجاد',
        'Carpet Cleaning Service'   => 'خدمة تنظيف السجاد',
        'Pricing'           => 'الأسعار',
        'Our Pricing'       => 'الأسعار',
        'Blog'              => 'المدونة',
        'News'              => 'الأخبار',
        'FAQ'               => 'الأسئلة الشائعة',
        'Testimonials'      => 'آراء العملاء',
        'Gallery'           => 'معرض الصور',
        'Projects'          => 'مشاريعنا',
        'Team'              => 'فريقنا',
        'Contact'           => 'تواصل معنا',
        'Contact Us'        => 'تواصل معنا',
    ];

    $key = trim( $title );
    return isset( $map[ $key ] ) ? $map[ $key ] : $title;
}
