<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Return an absolute URL to a theme asset.
 */
function nsp_asset( string $path ): string {
    return NSP_THEME_URI . '/' . ltrim( $path, '/' );
}

/**
 * Return the public social profile links used across the theme.
 */
function nsp_social_links(): array {
    $links = [
        [
            'key'     => 'snapchat',
            'label'   => 'Snapchat',
            'icon'    => 'fab fa-snapchat-ghost',
            'setting' => 'nsp_social_snapchat',
            'default' => 'https://www.snapchat.com/add/newsuperprime',
        ],
        [
            'key'     => 'facebook',
            'label'   => 'Facebook',
            'icon'    => 'fab fa-facebook-f',
            'setting' => 'nsp_social_facebook',
            'default' => 'https://www.facebook.com/newsuperprime',
        ],
        [
            'key'     => 'tiktok',
            'label'   => 'TikTok',
            'icon'    => 'fab fa-tiktok',
            'setting' => 'nsp_social_tiktok',
            'default' => 'https://www.tiktok.com/@new_super_prime_company',
        ],
        [
            'key'     => 'x',
            'label'   => 'X',
            'icon'    => 'fab fa-twitter',
            'setting' => 'nsp_social_x',
            'default' => 'https://x.com/NewSuperPrime',
        ],
        [
            'key'     => 'instagram',
            'label'   => 'Instagram',
            'icon'    => 'fab fa-instagram',
            'setting' => 'nsp_social_instagram',
            'default' => 'https://www.instagram.com/newsuperprimecompany?utm_source=qr&igsh=dTE4Mm56dmF3Ymhm',
        ],
    ];

    foreach ( $links as &$link ) {
        $url = get_theme_mod( $link['setting'], $link['default'] );
        $link['url'] = ( ! $url || '#' === $url ) ? $link['default'] : $url;
    }
    unset( $link );

    return $links;
}

/**
 * Echo social profile links. Set $list_items when links live inside a <ul>.
 */
function nsp_social_links_html( bool $list_items = false ): void {
    foreach ( nsp_social_links() as $social ) {
        $link = sprintf(
            '<a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s"><i class="%s"></i></a>',
            esc_url( $social['url'] ),
            esc_attr( $social['label'] ),
            esc_attr( $social['icon'] )
        );

        echo $list_items ? '<li>' . $link . '</li>' : $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/**
 * Return a service image URL, matching the real filename case on Linux servers.
 */
function nsp_service_image_url( string $filename ): string {
    $service_dir = NSP_THEME_DIR . '/assets/img/img-5/service';
    $requested   = basename( $filename );
    static $service_files = null;

    if ( null === $service_files ) {
        $service_files = is_dir( $service_dir ) ? scandir( $service_dir ) : [];
    }

    if ( $service_files ) {
            foreach ( $service_files as $file ) {
                if ( strtolower( $file ) === strtolower( $requested ) ) {
                    return nsp_asset( 'assets/img/img-5/service/' . $file );
                }
                if ( strtolower( pathinfo( $file, PATHINFO_FILENAME ) ) === strtolower( $requested ) ) {
                    return nsp_asset( 'assets/img/img-5/service/' . $file );
                }
            }
    }

    return nsp_asset( 'assets/img/img-5/service/' . $requested );
}

/**
 * Return a post type archive URL with a stable page-slug fallback.
 */
function nsp_post_type_archive_url( string $post_type, string $fallback_slug ): string {
    $archive_url = get_post_type_archive_link( $post_type );
    return $archive_url ? $archive_url : home_url( '/' . trim( $fallback_slug, '/' ) . '/' );
}

/**
 * Return a post date with Arabic month names when Arabic mode is active.
 */
function nsp_get_the_date( string $format = 'F j, Y', $post = null ): string {
    $date = get_the_date( $format, $post );

    if ( ! nsp_is_arabic() ) {
        return $date;
    }

    $months = [
        'January'   => 'يناير',
        'February'  => 'فبراير',
        'March'     => 'مارس',
        'April'     => 'أبريل',
        'May'       => 'مايو',
        'June'      => 'يونيو',
        'July'      => 'يوليو',
        'August'    => 'أغسطس',
        'September' => 'سبتمبر',
        'October'   => 'أكتوبر',
        'November'  => 'نوفمبر',
        'December'  => 'ديسمبر',
    ];

    return strtr( $date, $months );
}

/**
 * Echo-safe alias for esc_html().
 */
function nsp_e( $v ): string {
    return esc_html( (string) $v );
}

/**
 * Newsletter subscription handler (admin-post).
 * Stores emails in an option as a simple list.
 * TODO: Replace option storage with Mailchimp API integration.
 */
function nsp_handle_newsletter_subscribe() {
    check_admin_referer( 'nsp_newsletter_subscribe', 'nsp_newsletter_nonce' );

    $email = isset( $_POST['nsp_email'] ) ? sanitize_email( wp_unslash( $_POST['nsp_email'] ) ) : '';

    if ( is_email( $email ) ) {
        $subscribers = get_option( 'nsp_newsletter_subscribers', [] );
        if ( ! in_array( $email, $subscribers, true ) ) {
            $subscribers[] = $email;
            update_option( 'nsp_newsletter_subscribers', $subscribers );
        }
    }

    wp_safe_redirect( add_query_arg( 'nsp_subscribed', '1', wp_get_referer() ) );
    exit;
}
add_action( 'admin_post_nsp_subscribe',        'nsp_handle_newsletter_subscribe' );
add_action( 'admin_post_nopriv_nsp_subscribe', 'nsp_handle_newsletter_subscribe' );

/**
 * Map an English service title to the URL of its dedicated service page.
 * Falls back to the service archive if no matching page is found.
 *
 * @param string $title  English post/service title.
 * @return string  Permalink.
 */
function nsp_get_service_page_url( string $title ): string {
    static $title_to_slug = null;
    if ( $title_to_slug === null ) {
        $title_to_slug = [];
        foreach ( nsp_get_service_page_definitions() as $svc ) {
            $title_to_slug[ strtolower( $svc['title'] ) ] = $svc['slug'];
        }
    }

    $key  = strtolower( trim( $title ) );
    // Try exact match first, then a whole-word match.
    $slug = $title_to_slug[ $key ] ?? null;
    if ( ! $slug ) {
        $generic_words = [ 'service', 'services', 'cleaning', 'repair', 'repairing' ];
        $title_words = preg_split( '/[^a-z0-9]+/', $key, -1, PREG_SPLIT_NO_EMPTY );
        $title_words = array_diff( $title_words ?: [], $generic_words );
        foreach ( $title_to_slug as $def_title => $def_slug ) {
            $def_words = preg_split( '/[^a-z0-9]+/', $def_title, -1, PREG_SPLIT_NO_EMPTY );
            $def_words = array_diff( $def_words ?: [], $generic_words );
            if ( $title_words && $def_words && array_intersect( $title_words, $def_words ) ) {
                $slug = $def_slug;
                break;
            }
        }
    }

    if ( $slug ) {
        $page = get_page_by_path( $slug );
        if ( $page ) return get_permalink( $page->ID );
        return home_url( '/' . $slug . '/' );
    }

    return nsp_post_type_archive_url( 'service', 'services' );
}

/**
 * Return service CPT terms as an array of ['slug', 'title'] — mirrors the
 * old services-data.php so existing markup can call nsp_get_services().
 */
function nsp_get_services(): array {
    static $cache = null;
    if ( $cache !== null ) return $cache;

    $terms = get_terms( [
        'taxonomy'   => 'service_category',
        'hide_empty' => false,
    ] );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        $cache = [
            [ 'slug' => 'pest-control',                           'title' => nsp_t( 'Pest Control Services', 'خدمات مكافحة الحشرات' ) ],
            [ 'slug' => 'office-house-mosque-schools-cleaning',    'title' => nsp_t( 'Office, House, Mosque & Schools Cleaning', 'تنظيف المكاتب والمنازل والمساجد والمدارس' ) ],
            [ 'slug' => 'ac-repairing-cleaning',                  'title' => nsp_t( 'AC Repairing & Cleaning Services', 'خدمات إصلاح وتنظيف المكيفات' ) ],
            [ 'slug' => 'car-detailing',                          'title' => nsp_t( 'Car Detailing Services', 'خدمات تلميع السيارات' ) ],
            [ 'slug' => 'car-upholstery',                         'title' => nsp_t( 'Car Upholstery Services', 'خدمات تنجيد السيارات' ) ],
            [ 'slug' => 'car-window-tinting-body-ppf',            'title' => nsp_t( 'Car Window Tinting & Body PPF', 'تظليل زجاج السيارة وحماية الطلاء' ) ],
        ];
        return $cache;
    }

    $out = [];
    foreach ( $terms as $t ) {
        $out[] = [ 'slug' => $t->slug, 'title' => $t->name ];
    }
    $cache = $out;
    return $cache;
}

function nsp_seo_keyword_map(): array {
    return [
        'default' => [
            'description' => 'New Super Prime provides deep cleaning, home cleaning, office cleaning, pest control, AC cleaning, water tank cleaning, upholstery cleaning, moving maintenance and commercial cleaning services across Saudi Arabia\'s Eastern Region.',
            'keywords'    => 'deep cleaning Dammam, deep cleaning Eastern Region Saudi Arabia, post construction cleaning, home cleaning Dammam, home cleaning Khobar, hourly maid service Eastern Province, office cleaning Dammam, office cleaning Khobar, commercial cleaning company Eastern Region, janitorial services, villa cleaning Dammam, apartment cleaning Khobar, sofa cleaning, carpet cleaning, curtain cleaning, AC cleaning, water tank cleaning Eastern Region, pest control Dammam, pest control Khobar, cockroach control, bed bug control, home shifting, furniture transport, office relocation, general maintenance',
        ],
        'home-cleaning-service' => [
            'description' => 'Book home cleaning in Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa and Saudi Arabia\'s Eastern Region, including hourly maid service, villa cleaning and apartment cleaning.',
            'keywords'    => 'home cleaning Dammam, home cleaning Khobar, hourly maid service Eastern Province, villa cleaning Dammam, apartment cleaning Khobar',
        ],
        'office-cleaning-service' => [
            'description' => 'Professional office cleaning in Dammam, Khobar and the Eastern Region for businesses, commercial properties and workplaces needing janitorial services.',
            'keywords'    => 'office cleaning Dammam, office cleaning Khobar, commercial cleaning company Eastern Region, janitorial services, B2B commercial cleaning',
        ],
        'carpet-cleaning-service' => [
            'description' => 'Upholstery cleaning for sofas, carpets and curtains with professional stain, dust and odor removal.',
            'keywords'    => 'upholstery cleaning, sofa cleaning, carpet cleaning, curtain cleaning',
        ],
        'ac-maintenance-service' => [
            'description' => 'AC cleaning, HVAC maintenance and water tank cleaning services for homes and commercial properties in the Eastern Region of Saudi Arabia.',
            'keywords'    => 'HVAC cleaning Eastern Region, AC cleaning Dammam, water tank cleaning Khobar, AC maintenance Eastern Province',
        ],
        'pest-control-service' => [
            'description' => 'Pest control in Dammam, Khobar and the Eastern Region including cockroach control, bed bug control and safe pest treatment.',
            'keywords'    => 'pest control Dammam, pest control Khobar, cockroach control, bed bug control, pest control Eastern Region Saudi Arabia',
        ],
        'home-shifting-service' => [
            'description' => 'Moving maintenance services including home shifting, furniture transport, office relocation and general maintenance.',
            'keywords'    => 'home shifting, furniture transport, office relocation, general maintenance, moving maintenance',
        ],
    ];
}

function nsp_current_seo_data(): array {
    $map = nsp_seo_keyword_map();
    $key = 'default';

    if ( is_page() ) {
        $post = get_queried_object();
        if ( $post instanceof WP_Post && ! empty( $map[ $post->post_name ] ) ) {
            $key = $post->post_name;
        }
    }

    return $map[ $key ];
}

add_action( 'wp_head', function () {
    if ( is_admin() || nsp_is_arabic() ) {
        return;
    }

    $seo = nsp_current_seo_data();

    echo '<meta name="description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
    echo '<meta name="keywords" content="' . esc_attr( $seo['keywords'] ) . '">' . "\n";
}, 2 );

/**
 * Return the Arabic title or description for a service post, keyed by its English title.
 * Used to translate WP database service posts without a translation plugin.
 *
 * @param string $en_title  The post title in English.
 * @param string $key       'title' or 'desc'.
 * @return string  Arabic string, or '' if not found / language is English.
 */
function nsp_service_ar( string $en_title, string $key ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $map = [
        'Carpet Cleaning'              => [ 'title' => 'تنظيف السجاد',             'desc' => 'تنظيف عميق للسجاد يزيل البقع والغبار ومسببات الحساسية.' ],
        'Carpet Cleaning Service'      => [ 'title' => 'خدمة تنظيف السجاد',        'desc' => 'تنظيف عميق واحترافي للسجاد يزيل البقع والغبار والروائح ومسببات الحساسية.' ],
        'Car Washing'                  => [ 'title' => 'غسيل السيارات',            'desc' => 'غسيل داخلي وخارجي كامل للسيارة في موقعك.' ],
        'Car Wash'                     => [ 'title' => 'غسيل السيارات',            'desc' => 'غسيل داخلي وخارجي كامل للسيارة في موقعك.' ],
        'Car Wash Service'             => [ 'title' => 'خدمة غسيل السيارات',      'desc' => 'غسيل داخلي وخارجي كامل للسيارة في موقعك.' ],
        'Home Shifting Service'        => [ 'title' => 'خدمة نقل العفش',           'desc' => 'خدمات نقل العفش الآمنة والاحترافية.' ],
        'Home Shifting'                => [ 'title' => 'نقل العفش',                'desc' => 'خدمات نقل العفش الآمنة والاحترافية.' ],
        'Home Cleaning Service'        => [ 'title' => 'خدمة تنظيف المنازل',      'desc' => 'تنظيف منزلي احترافي شامل لجميع الغرف.' ],
        'Home Cleaning'                => [ 'title' => 'تنظيف المنازل',            'desc' => 'تنظيف منزلي احترافي شامل لجميع الغرف.' ],
        'Office Cleaning Service'      => [ 'title' => 'خدمة تنظيف المكاتب',      'desc' => 'تنظيف مكاتب موثوق يحافظ على بيئة عمل صحية.' ],
        'Office Cleaning'              => [ 'title' => 'تنظيف المكاتب',            'desc' => 'تنظيف مكاتب موثوق يحافظ على بيئة عمل صحية.' ],
        'Pest Control'                 => [ 'title' => 'مكافحة الحشرات',           'desc' => 'معالجات آمنة وفعّالة للقضاء على الحشرات والآفات.' ],
        'Pest Control Service'         => [ 'title' => 'خدمة مكافحة الحشرات',     'desc' => 'معالجات آمنة وفعّالة للقضاء على الحشرات والآفات.' ],
        'Pest Control Services'        => [ 'title' => 'خدمات مكافحة الحشرات',    'desc' => 'معالجات آمنة وفعّالة للقضاء على الحشرات والآفات.' ],
        'AC Maintenance'               => [ 'title' => 'صيانة المكيفات',           'desc' => 'صيانة وإصلاح جميع أنواع المكيفات بقطع غيار أصلية.' ],
        'AC Maintenance Service'       => [ 'title' => 'خدمة صيانة المكيفات',     'desc' => 'صيانة وإصلاح جميع أنواع المكيفات بقطع غيار أصلية.' ],
        'AC Service'                   => [ 'title' => 'خدمة المكيفات',            'desc' => 'صيانة وإصلاح جميع أنواع المكيفات بقطع غيار أصلية.' ],
        'AC Cleaning & Repair'             => [ 'title' => 'تنظيف وإصلاح المكيفات',      'desc' => 'صيانة وإصلاح وتنظيف عميق لجميع أنواع المكيفات.' ],
        'AC Repairing & Cleaning Services' => [ 'title' => 'خدمات إصلاح وتنظيف المكيفات', 'desc' => 'صيانة وإصلاح وتنظيف عميق لجميع أنواع المكيفات.' ],
        'Deep Cleaning'                => [ 'title' => 'التنظيف العميق',           'desc' => 'تنظيف عميق وشامل لجميع أركان المنزل أو المنشأة.' ],
        'Sofa Cleaning'                => [ 'title' => 'تنظيف الأرائك',            'desc' => 'تنظيف وتعقيم الأرائك والكنبات بمعدات متخصصة.' ],
        'Window Cleaning'              => [ 'title' => 'تنظيف النوافذ',            'desc' => 'تنظيف النوافذ الداخلية والخارجية بدون آثار.' ],
        'Car Detailing Services'       => [ 'title' => 'خدمات تلميع السيارات',    'desc' => 'تلميع شامل للسيارة داخلياً وخارجياً بمنتجات فاخرة.' ],
        'Car Detailing'                => [ 'title' => 'تلميع السيارات',           'desc' => 'تلميع شامل للسيارة داخلياً وخارجياً بمنتجات فاخرة.' ],
        'Car Upholstery Services'      => [ 'title' => 'خدمات تنجيد السيارات',    'desc' => 'تنجيد واجهات وأسقف السيارات بأعلى معايير الجودة.' ],
        'Car Upholstery'               => [ 'title' => 'تنجيد السيارات',           'desc' => 'تنجيد واجهات وأسقف السيارات بأعلى معايير الجودة.' ],
        'Car Window Tinting & Body PPF'=> [ 'title' => 'تظليل زجاج السيارة وحماية الطلاء', 'desc' => 'تظليل احترافي وحماية الطلاء بأفضل المواد.' ],
        'Office, House, Mosque & Schools Cleaning' => [ 'title' => 'تنظيف المكاتب والمنازل والمساجد والمدارس', 'desc' => 'خدمات تنظيف شاملة لجميع أنواع المباني.' ],
        'Mosque Cleaning'              => [ 'title' => 'تنظيف المساجد',            'desc' => 'تنظيف متخصص للمساجد باستخدام مواد آمنة ومعتمدة.' ],
        'School Cleaning'              => [ 'title' => 'تنظيف المدارس',            'desc' => 'تنظيف وتعقيم شامل للفصول الدراسية والمرافق.' ],
        'Tank Cleaning'                => [ 'title' => 'تنظيف الخزانات',           'desc' => 'تنظيف وتعقيم خزانات المياه بطرق صحية معتمدة.' ],
        'Water Tank Cleaning'          => [ 'title' => 'تنظيف خزانات المياه',      'desc' => 'تنظيف وتعقيم خزانات المياه بطرق صحية معتمدة.' ],
        'Marble Polishing'             => [ 'title' => 'جلي الرخام',               'desc' => 'جلي وتلميع الرخام والأرضيات لإعادة بريقها الأصلي.' ],
        'Tile Polishing'               => [ 'title' => 'تلميع البلاط',             'desc' => 'تلميع البلاط والأرضيات للحصول على لمعة تدوم طويلاً.' ],
    ];

    $title = trim( html_entity_decode( $en_title, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
    return isset( $map[ $title ][ $key ] ) ? $map[ $title ][ $key ] : '';
}

/**
 * Return Arabic title or content for an FAQ post, keyed by its English title.
 *
 * @param string $en_title  The post title in English.
 * @param string $key       'title' or 'content'.
 * @return string  Arabic string, or '' if not found / language is English.
 */
function nsp_faq_ar( string $en_title, string $key ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $map = [
        'What areas do you serve?' => [
            'title'   => 'ما المناطق التي تخدمونها؟',
            'content' => 'نخدم المنطقة الشرقية وجميع مدنها بما فيها الدمام والخبر والظهران والجبيل والقطيف والأحساء ورأس تنورة وحفر الباطن وغيرها.',
        ],
        'Do you offer a satisfaction guarantee?' => [
            'title'   => 'هل تقدمون ضمان الرضا؟',
            'content' => 'نعم، رضا العميل هو أولويتنا. إذا لم تكن راضياً عن الخدمة، سنعود لإعادة التنظيف مجاناً خلال 24 ساعة.',
        ],
        'How long does a typical home cleaning take?' => [
            'title'   => 'كم يستغرق تنظيف المنزل عادةً؟',
            'content' => 'يعتمد الوقت على حجم المنزل. عادةً يستغرق التنظيف من 2 إلى 5 ساعات. سيحدد فريقنا الوقت المناسب عند الحجز.',
        ],
        'Do I need to be home during the cleaning?' => [
            'title'   => 'هل يجب أن أكون في المنزل أثناء التنظيف؟',
            'content' => 'لا، ليس ضرورياً. كثير من عملائنا يمنحوننا مفتاحاً أو يرتبون دخولنا مسبقاً. فريقنا أمين وموثوق تماماً.',
        ],
        'What cleaning products do you use?' => [
            'title'   => 'ما المنتجات التي تستخدمونها في التنظيف؟',
            'content' => 'نستخدم منتجات تنظيف آمنة ومعتمدة، صديقة للبيئة وغير ضارة بالأطفال والحيوانات الأليفة.',
        ],
        'How do I book a cleaning service?' => [
            'title'   => 'كيف أحجز خدمة التنظيف؟',
            'content' => 'يمكنك الحجز بسهولة عبر الاتصال بنا أو ملء نموذج الحجز على الموقع. سيتواصل معك فريقنا لتأكيد الموعد.',
        ],
        'Are your cleaners trained and insured?' => [
            'title'   => 'هل موظفوكم مدربون ومؤمَّن عليهم؟',
            'content' => 'نعم، جميع موظفينا خضعوا لتدريب مكثف وتحققنا من سجلاتهم. كما نحمل تأمينًا شاملاً لحماية ممتلكاتكم.',
        ],
        'Why Tile Polishing Matters' => [
            'title'   => 'لماذا تلميع البلاط مهم؟',
            'content' => 'تلميع البلاط يُطيل عمره ويمنحه مظهراً جديداً ومشرقاً، كما يُسهل التنظيف اليومي ويحمي السطح من الخدوش.',
        ],
        'Office, House, Mosque, Schools Cleaning' => [
            'title'   => 'تنظيف المكاتب والمنازل والمساجد والمدارس',
            'content' => 'نقدم خدمات تنظيف شاملة لجميع أنواع المباني باستخدام معدات متطورة وفريق مدرب على أعلى مستوى.',
        ],
        'Car Detailing Services' => [
            'title'   => 'خدمات تلميع السيارات',
            'content' => 'خدمات تلميع السيارات تشمل التنظيف الداخلي والخارجي الشامل مع الحماية بالشمع لإبراز بريق سيارتك.',
        ],
    ];

    $title = trim( $en_title );
    return isset( $map[ $title ][ $key ] ) ? $map[ $title ][ $key ] : '';
}

/**
 * Return Arabic field for a testimonial post, keyed by the reviewer's English name.
 *
 * @param string $en_name  The post title (reviewer name) in English.
 * @param string $key      'content', 'role', or 'name'.
 * @return string  Arabic string, or '' if not found / language is English.
 */
function nsp_testimonial_ar( string $en_name, string $key ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $map = [
        'Noura Al-Shammari' => [
            'name'    => 'نورا الشمري',
            'content' => 'حجزت تنظيفاً عميقاً للمنزل قبل تجمع عائلي فكانت النتائج مذهلة. كل غرفة كانت نظيفة تماماً. سأستخدم خدماتهم بالتأكيد مرة أخرى!',
            'role'    => 'ربة منزل، الدمام',
        ],
        'Tariq Al-Dosari' => [
            'name'    => 'طارق الدوسري',
            'content' => 'فريق مكافحة الحشرات كان على دراية واسعة واستخدم منتجات آمنة مناسبة للمنازل ذات الأطفال. تم حل المشكلة من أول زيارة.',
            'role'    => 'مدير عقارات، الخبر',
        ],
        'Huda Al-Mutairi' => [
            'name'    => 'هدى المطيري',
            'content' => 'خدمة صيانة المكيفات كانت سريعة وفعّالة. تحوّل جهازي من شبه متوقف إلى عمل كالجديد تماماً. قيمة ممتازة مقابل السعر.',
            'role'    => 'مالكة شقة، الدمام',
        ],
    ];

    $name = trim( $en_name );
    return isset( $map[ $name ][ $key ] ) ? $map[ $name ][ $key ] : '';
}

/**
 * Return Arabic title or excerpt for a project post, keyed by its English title.
 *
 * @param string $en_title  The post title in English.
 * @param string $key       'title', 'excerpt', or 'content'.
 * @return string  Arabic string, or '' if not found / language is English.
 */
function nsp_project_ar( string $en_title, string $key ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $map = [
        'Residential Deep Cleaning'        => [ 'title' => 'تنظيف سكني',                   'excerpt' => 'تنظيف شامل لمنزل في الدمام.' ],
        'Residence Cleaning'               => [ 'title' => 'تنظيف سكني',                   'excerpt' => 'تنظيف شامل لمنزل في الدمام.' ],
        'Corporate Office Pest Control'    => [ 'title' => 'تنظيف غرفة',                   'excerpt' => 'تنظيف مفصل للغرف في الدمام.' ],
        'Room Cleaning'                    => [ 'title' => 'تنظيف غرفة',                   'excerpt' => 'تنظيف مفصل للغرف في الدمام.' ],
        'Hotel AC Servicing Contract'      => [ 'title' => 'تنظيف مكاتب',                  'excerpt' => 'تنظيف احترافي لمكتب في الدمام.' ],
        'Office Cleaning'                  => [ 'title' => 'تنظيف مكاتب',                  'excerpt' => 'تنظيف احترافي لمكتب في الدمام.' ],
        'Shopping Mall Carpet Cleaning'    => [ 'title' => 'تنظيف غرفة جلوس التلفاز',       'excerpt' => 'تنظيف مفصل لغرفة جلوس التلفاز في الدمام.' ],
        'TV Lounge Room'                   => [ 'title' => 'تنظيف غرفة جلوس التلفاز',       'excerpt' => 'تنظيف مفصل لغرفة جلوس التلفاز في الدمام.' ],
        'Mosque Deep Cleaning'             => [ 'title' => 'تنظيف عميق لمسجد',             'excerpt' => 'تنظيف وتعقيم شامل للمسجد قبل شهر رمضان المبارك.' ],
        'School Sanitization Project'      => [ 'title' => 'مشروع تعقيم مدرسة',            'excerpt' => 'تعقيم وتطهير شامل للفصول والمرافق قبل بدء العام الدراسي.' ],
        'Villa Window & Facade Cleaning'   => [ 'title' => 'تنظيف نوافذ وواجهة فيلا',      'excerpt' => 'تنظيف الواجهة الخارجية والنوافذ لفيلا فارهة.' ],
        'Car Fleet Detailing'              => [ 'title' => 'تلميع أسطول سيارات',            'excerpt' => 'تلميع داخلي وخارجي متكامل لأسطول سيارات شركة.' ],
    ];

    $key_title = trim( $en_title );
    return isset( $map[ $key_title ][ $key ] ) ? $map[ $key_title ][ $key ] : '';
}

/**
 * Translate a location string (city, country) to Arabic.
 *
 * @param string $en_location  Location string in English (e.g. "Jeddah, Saudi Arabia").
 * @return string  Arabic location, or original string if not found / language is English.
 */
function nsp_location_ar( string $en_location ): string {
    if ( ! nsp_is_arabic() ) return $en_location;

    static $map = [
        'Dammam, Saudi Arabia'           => 'الدمام، المملكة العربية السعودية',
        'Khobar, Saudi Arabia'           => 'الخبر، المملكة العربية السعودية',
        'Dhahran, Saudi Arabia'          => 'الظهران، المملكة العربية السعودية',
        'Jubail, Saudi Arabia'           => 'الجبيل، المملكة العربية السعودية',
        'Qatif, Saudi Arabia'            => 'القطيف، المملكة العربية السعودية',
        'Al-Ahsa, Saudi Arabia'          => 'الأحساء، المملكة العربية السعودية',
        'Ras Tanura, Saudi Arabia'       => 'رأس تنورة، المملكة العربية السعودية',
        'Hafr Al-Batin, Saudi Arabia'    => 'حفر الباطن، المملكة العربية السعودية',
        'Eastern Province, Saudi Arabia' => 'المنطقة الشرقية، المملكة العربية السعودية',
        'Eastern Province, KSA'          => 'المنطقة الشرقية، المملكة العربية السعودية',
        'Saudi Arabia'                   => 'المملكة العربية السعودية',
    ];

    $loc = trim( $en_location );
    return $map[ $loc ] ?? $en_location;
}

/**
 * Translate a blog post title or excerpt to Arabic.
 *
 * @param string $en_title  English post title.
 * @param string $key       'title' or 'excerpt'.
 * @return string  Arabic string, or '' if not found / language is English.
 */
function nsp_post_ar( string $en_title, string $key = 'title' ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $map = [
        '5 Benefits of Regular Professional Home Cleaning' => [
            'title'   => '5 فوائد للتنظيف المنزلي الاحترافي المنتظم',
            'excerpt' => 'اكتشف كيف يحافظ التنظيف المنزلي الاحترافي المنتظم على صحة عائلتك ويوفر وقتك ويحافظ على منزلك في أفضل حالة.',
        ],
        'Benefits of Regular Professional Home Cleaning 5' => [
            'title'   => 'فوائد التنظيف المنزلي الاحترافي المنتظم',
            'excerpt' => 'اكتشف كيف يحافظ التنظيف المنزلي الاحترافي المنتظم على صحة عائلتك ويُعطيك بيئة أنظف وأصح.',
        ],
        'Benefits of Regular Professional 5 Home Cleaning' => [
            'title'   => 'فوائد التنظيف المنزلي الاحترافي المنتظم',
            'excerpt' => 'اكتشف كيف يحافظ التنظيف المنزلي الاحترافي المنتظم على صحة عائلتك ويُعطيك بيئة أنظف وأصح.',
        ],
        'Signs You Have a Pest Problem (And What to Do About It)' => [
            'title'   => 'علامات وجود مشكلة حشرات وكيفية التعامل معها',
            'excerpt' => 'تعرّف على العلامات التحذيرية الشائعة للإصابة بالحشرات وما يمكنك فعله للقضاء عليها بسرعة وأمان.',
        ],
        'How Often Should You Service Your Air Conditioner?' => [
            'title'   => 'كم مرة يجب خدمة مكيف الهواء؟',
            'excerpt' => 'الصيانة الدورية للمكيف تُطيل عمره وتوفر الطاقة وتمنع الأعطال المكلفة في أشد فصول الصيف حرارة.',
        ],
        'How to Deep Clean Your Kitchen Like a Pro' => [
            'title'   => 'كيف تنظف مطبخك بعمق كالمحترفين',
            'excerpt' => 'دليل خطوة بخطوة لتنظيف المطبخ بعمق باستخدام أدوات ومواد احترافية للحصول على نتائج مبهرة.',
        ],
        'Top 5 Benefits of Professional Carpet Cleaning' => [
            'title'   => 'أبرز 5 فوائد لتنظيف السجاد الاحترافي',
            'excerpt' => 'تنظيف السجاد الاحترافي يزيل البكتيريا والحساسية ويحافظ على مظهره الجميل وألوانه لسنوات.',
        ],
        'Why Regular AC Maintenance Saves You Money' => [
            'title'   => 'لماذا تُوفر صيانة المكيف المنتظمة أموالك',
            'excerpt' => 'الصيانة المنتظمة تمنع الأعطال المكلفة وتحسن كفاءة التبريد وتخفض فاتورة الكهرباء الشهرية.',
        ],
        'The Ultimate Guide to Office Cleaning' => [
            'title'   => 'الدليل الشامل لتنظيف المكاتب',
            'excerpt' => 'بيئة مكتبية نظيفة تعزز إنتاجية الموظفين وتترك انطباعاً احترافياً لدى زوار وعملاء الشركة.',
        ],
        'Home Shifting Tips: How to Move Without the Mess' => [
            'title'   => 'نصائح نقل الأثاث: كيف تنتقل دون فوضى',
            'excerpt' => 'نصائح عملية لتنظيم وتنفيذ الانتقال إلى منزل جديد بأقل قدر ممكن من الفوضى والتوتر.',
        ],
        'Best Car Detailing Services in Saudia Arabia' => [
            'title'   => 'أفضل خدمات تلميع السيارات في السعودية',
            'excerpt' => 'تعرف على خدمات تلميع السيارات الاحترافية للعناية بالداخل والخارج واستعادة مظهر السيارة.',
        ],
        'Best Car Detailing Services in Saudi Arabia' => [
            'title'   => 'أفضل خدمات تلميع السيارات في السعودية',
            'excerpt' => 'تعرف على خدمات تلميع السيارات الاحترافية للعناية بالداخل والخارج واستعادة مظهر السيارة.',
        ],
        'Best Car Upholstery Services in Saudia Arabia' => [
            'title'   => 'أفضل خدمات تنجيد السيارات في السعودية',
            'excerpt' => 'حلول تنجيد احترافية للمقاعد والأبواب والسقف الداخلي لتحسين راحة ومظهر السيارة.',
        ],
        'Best Car Upholstery Services in Saudi Arabia' => [
            'title'   => 'أفضل خدمات تنجيد السيارات في السعودية',
            'excerpt' => 'حلول تنجيد احترافية للمقاعد والأبواب والسقف الداخلي لتحسين راحة ومظهر السيارة.',
        ],
        'Best Car Window Tinting & Body PPF Services in Saudia Arabia' => [
            'title'   => 'أفضل خدمات تظليل زجاج السيارات وحماية الطلاء في السعودية',
            'excerpt' => 'خدمات تظليل وحماية طلاء احترافية تساعد في حماية السيارة وتحسين مظهرها.',
        ],
        'Best Car Window Tinting & Body PPF Services in Saudi Arabia' => [
            'title'   => 'أفضل خدمات تظليل زجاج السيارات وحماية الطلاء في السعودية',
            'excerpt' => 'خدمات تظليل وحماية طلاء احترافية تساعد في حماية السيارة وتحسين مظهرها.',
        ],
        'Hello world!' => [
            'title'   => 'مرحباً بالعالم!',
            'excerpt' => 'أهلاً بك في موقع نيو سوبر برايم.',
        ],
    ];

    $k = trim( wp_strip_all_tags( html_entity_decode( $en_title, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
    if ( isset( $map[ $k ][ $key ] ) ) {
        return $map[ $k ][ $key ];
    }
    if ( 'content' === $key && isset( $map[ $k ]['excerpt'] ) ) {
        return $map[ $k ]['excerpt'];
    }

    $normalize = static function ( string $value ): string {
        $value = strtolower( html_entity_decode( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
        $value = str_replace( [ '&', 'and' ], ' ', $value );
        $value = preg_replace( '/[^a-z0-9]+/', ' ', $value );
        return trim( preg_replace( '/\s+/', ' ', (string) $value ) );
    };

    $lookup = $normalize( $k );
    foreach ( $map as $title => $values ) {
        $map_lookup = $normalize( $title );
        if ( $map_lookup === $lookup ) {
            return $values[ $key ] ?? ( 'content' === $key ? ( $values['excerpt'] ?? '' ) : '' );
        }
        if ( strlen( $lookup ) > 12 && ( false !== strpos( $map_lookup, $lookup ) || false !== strpos( $lookup, $map_lookup ) ) ) {
            return $values[ $key ] ?? ( 'content' === $key ? ( $values['excerpt'] ?? '' ) : '' );
        }
    }

    return '';
}

/**
 * Return Arabic blog content saved on a post, with demo-map fallback.
 *
 * @param int    $post_id Post ID.
 * @param string $key     'title', 'excerpt', or 'content'.
 * @return string Arabic value in Arabic mode, otherwise empty string.
 */
function nsp_get_post_ar( int $post_id, string $key = 'title' ): string {
    if ( ! nsp_is_arabic() || ! $post_id ) return '';

    $meta_keys = [
        'title'   => '_nsp_post_ar_title',
        'excerpt' => '_nsp_post_ar_excerpt',
        'content' => '_nsp_post_ar_content',
    ];

    if ( isset( $meta_keys[ $key ] ) ) {
        $value = trim( (string) get_post_meta( $post_id, $meta_keys[ $key ], true ) );
        if ( '' !== $value ) {
            return $value;
        }
    }

    return nsp_post_ar( get_the_title( $post_id ), $key );
}

/**
 * Arabic placeholder shown when a dashboard blog post has no Arabic fields.
 *
 * @param string $key 'title', 'excerpt', or 'content'.
 * @return string
 */
function nsp_missing_post_ar_text( string $key = 'title' ): string {
    $messages = [
        'title'   => 'المحتوى العربي غير مضاف',
        'excerpt' => 'يرجى إضافة الملخص العربي لهذا المقال من لوحة التحكم.',
        'content' => 'يرجى إضافة المحتوى العربي لهذا المقال من لوحة التحكم.',
    ];

    return $messages[ $key ] ?? $messages['title'];
}

/**
 * Translate a blog category name to Arabic.
 *
 * @param string $en_cat  English category name.
 * @return string  Arabic name, or '' if not found / language is English.
 */
function nsp_cat_ar( string $en_cat ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $map = [
        'Cleaning Tips'  => 'نصائح التنظيف',
        'Pest Control'   => 'مكافحة الحشرات',
        'AC Maintenance' => 'صيانة المكيفات',
        'Home Care'      => 'العناية بالمنزل',
        'Car Care'       => 'العناية بالسيارة',
        'Office Care'    => 'العناية بالمكتب',
        'Tips & Tricks'  => 'نصائح وحيل',
        'Uncategorized'  => 'غير مصنف',
    ];

    $k = trim( $en_cat );
    return $map[ $k ] ?? '';
}

/**
 * Return the SAR price for a pricing plan (both languages).
 *
 * @param string $en_title   English plan title.
 * @param string $fallback   Value to return if plan not found.
 * @return string  SAR price string, or $fallback.
 */
function nsp_pricing_sar( string $en_title, string $fallback = '' ): string {
    static $map = [
        'Basic Plan'          => 'SAR 499',
        'Standard Plan'       => 'SAR 999',
        'Premium Plan'        => 'SAR 1499',
        'One Service'         => 'SAR 499',
        'Add More Services'   => 'SAR 999',
        'All Services Bundle' => 'SAR 1499',
    ];
    return $map[ trim( $en_title ) ] ?? $fallback;
}

/**
 * Translate a pricing plan title or feature line to Arabic.
 *
 * @param string $en   English string (plan title or feature line).
 * @param string $key  'title' or 'feature'.
 * @return string  Arabic string, or '' if not found / language is English.
 */
function nsp_pricing_ar( string $en, string $key ): string {
    if ( ! nsp_is_arabic() ) return '';

    static $titles = [
        'Premium Plan'        => 'باقة كل الخدمات',
        'Standard Plan'       => 'أضف خدمات أكثر',
        'Basic Plan'          => 'خدمة واحدة',
        'One Service'         => 'خدمة واحدة',
        'Add More Services'   => 'أضف خدمات أكثر',
        'All Services Bundle' => 'باقة كل الخدمات',
    ];

    static $features = [
        'Choose any one cleaning service'      => 'اختر أي خدمة تنظيف واحدة',
        'Fixed quote before work starts'       => 'عرض سعر واضح قبل بدء العمل',
        'Single team visit'                    => 'زيارة واحدة من الفريق',
        'Book when needed, no membership'      => 'احجز عند الحاجة بدون اشتراك',
        'Combine any 2 to 3 services'          => 'اجمع من خدمتين إلى ثلاث خدمات',
        'Better value than separate bookings'  => 'قيمة أفضل من الحجوزات المنفصلة',
        'Coordinated same-day schedule'        => 'تنسيق الخدمات في نفس اليوم',
        'One invoice for all services'         => 'فاتورة واحدة لكل الخدمات',
        'Add all required services together'   => 'أضف كل الخدمات المطلوبة معاً',
        'Whole home or office solution'        => 'حل كامل للمنزل أو المكتب',
        'Priority scheduling'                  => 'أولوية في تحديد الموعد',
        'Custom scope after inspection'        => 'نطاق عمل مخصص بعد المعاينة',
        'Deep Cleaning (Full Property)' => 'تنظيف عميق (كامل العقار)',
        'Advanced Pest Control'         => 'مكافحة حشرات متقدمة',
        'AC Full Service'               => 'صيانة مكيف كاملة',
        'Carpet Cleaning'               => 'تنظيف السجاد',
        'Weekly Visit'                  => 'زيارة أسبوعية',
        'Priority Support 24/7'         => 'دعم أولوي ٢٤/٧',
        'Full Home Cleaning'            => 'تنظيف منزل كامل',
        'Pest Control Treatment'        => 'معالجة مكافحة الحشرات',
        'AC Filter Clean'               => 'تنظيف فلتر المكيف',
        'Bi-Weekly Visit'               => 'زيارة كل أسبوعين',
        'Phone Support'                 => 'دعم هاتفي',
        'Home Cleaning (1 Room)'        => 'تنظيف منزل (غرفة واحدة)',
        'Basic Pest Spray'              => 'رش حشرات أساسي',
        'Monthly Visit'                 => 'زيارة شهرية',
        'Email Support'                 => 'دعم عبر البريد الإلكتروني',
    ];

    $map = ( $key === 'title' ) ? $titles : $features;
    $k   = trim( $en );
    return $map[ $k ] ?? '';
}

/**
 * Output the language switcher (no plugin required).
 * Switching appends ?lang=ar or ?lang=en — the init hook in lang.php
 * sets a cookie and redirects to a clean URL.
 */
function nsp_language_switcher(): void {
    $current = nsp_current_lang();
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
    $home_path   = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
    $relative    = $request_uri;

    if ( $home_path && '/' !== $home_path && 0 === strpos( $relative, $home_path ) ) {
        $relative = substr( $relative, strlen( untrailingslashit( $home_path ) ) );
    }

    $base = remove_query_arg( 'lang', home_url( '/' . ltrim( $relative, '/' ) ) );
    $ar_url  = add_query_arg( 'lang', 'ar', $base );
    $en_url  = add_query_arg( 'lang', 'en', $base );
    echo '<div class="nsp-lang-switcher"><ul>';
    echo '<li class="lang-item' . ( $current === 'ar' ? ' current-lang' : '' ) . '">';
    echo '<a href="' . esc_url( $ar_url ) . '">عربي</a></li>';
    echo '<li class="lang-item' . ( $current === 'en' ? ' current-lang' : '' ) . '">';
    echo '<a href="' . esc_url( $en_url ) . '">EN</a></li>';
    echo '</ul></div>';
}

/**
 * Render pagination for archive loops.
 */
function nsp_pagination() {
    the_posts_pagination( [
        'mid_size'  => 2,
        'prev_text' => '<i class="fas fa-angle-left"></i>',
        'next_text' => '<i class="fas fa-angle-right"></i>',
        'class'     => 'nsp-pagination ul-li',
    ] );
}
