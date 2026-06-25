<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
   Register sidebars
   ============================================================ */
function nsp_register_sidebars() {
    $shared = [
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar( array_merge( $shared, [
        'name' => esc_html__( 'Blog Sidebar', 'newsuperprime' ),
        'id'   => 'blog-sidebar',
        'description' => esc_html__( 'Right column on blog and single post pages.', 'newsuperprime' ),
    ] ) );

    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array_merge( $shared, [
            'name' => sprintf( esc_html__( 'Footer Column %d', 'newsuperprime' ), $i ),
            'id'   => 'footer-' . $i,
        ] ) );
    }
}
add_action( 'widgets_init', 'nsp_register_sidebars' );

/* ============================================================
   Custom widget: NSP Recent Posts
   ============================================================ */
class NSP_Recent_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'nsp_recent_posts',
            esc_html__( 'NSP: Recent Posts', 'newsuperprime' ),
            [ 'description' => esc_html__( 'Displays recent posts with thumbnail, title, and date.', 'newsuperprime' ) ]
        );
    }

    public function widget( $args, $instance ) {
        $title  = ! empty( $instance['title'] ) ? $instance['title'] : nsp_t( 'Popular Posts', 'المقالات الشائعة' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 4;

        echo wp_kses_post( $args['before_widget'] );
        echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );

        $recent = new WP_Query( [
            'posts_per_page'      => $number,
            'post_status'         => 'publish',
            'no_found_rows'       => true,
            'ignore_sticky_posts' => true,
        ] );

        if ( $recent->have_posts() ) :
            echo '<div class="recent-blog-wrap">';
            while ( $recent->have_posts() ) :
                $recent->the_post();
                echo '<div class="recent-blog-img-text d-flex align-items-center">';
                $_raw_title  = get_the_title();
                $_ar_title   = nsp_get_post_ar( get_the_ID(), 'title' );
                $_post_title = ( $_ar_title !== '' ) ? $_ar_title : ( nsp_is_arabic() ? nsp_missing_post_ar_text( 'title' ) : $_raw_title );
                if ( has_post_thumbnail() ) {
                    echo '<div class="recent-img">';
                    echo '<a href="' . esc_url( get_permalink() ) . '">';
                    the_post_thumbnail( 'nsp-blog-thumb', [ 'alt' => $_post_title ] );
                    echo '</a></div>';
                }
                echo '<div class="recent-text headline pera-content">';
                echo '<h4><a href="' . esc_url( get_permalink() ) . '">' . esc_html( $_post_title ) . '</a></h4>';
                echo '<span>' . esc_html( nsp_get_the_date() ) . '</span>';
                echo '</div>';
                echo '</div>';
            endwhile;
            wp_reset_postdata();
            echo '</div>';
        endif;

        echo wp_kses_post( $args['after_widget'] );
    }

    public function form( $instance ) {
        $title  = isset( $instance['title'] )  ? esc_attr( $instance['title'] )  : esc_html__( 'Popular Posts', 'newsuperprime' );
        $number = isset( $instance['number'] ) ? absint( $instance['number'] )   : 4;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'newsuperprime' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'newsuperprime' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" min="1" max="20" value="<?php echo $number; ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance           = [];
        $instance['title']  = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = absint( $new_instance['number'] );
        return $instance;
    }
}

/* ============================================================
   Custom widget: NSP Newsletter
   ============================================================ */
class NSP_Newsletter_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'nsp_newsletter',
            esc_html__( 'NSP: Newsletter', 'newsuperprime' ),
            [ 'description' => esc_html__( 'Email subscription form.', 'newsuperprime' ) ]
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Newsletter', 'newsuperprime' );

        echo wp_kses_post( $args['before_widget'] );
        echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );

        $subscribed = isset( $_GET['nsp_subscribed'] ) && '1' === $_GET['nsp_subscribed'];
        if ( $subscribed ) {
            echo '<p>' . esc_html__( 'Thank you for subscribing!', 'newsuperprime' ) . '</p>';
        } else {
            echo '<div class="newsleter-form">';
            echo '<form action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" method="post">';
            echo '<input type="hidden" name="action" value="nsp_subscribe">';
            wp_nonce_field( 'nsp_newsletter_subscribe', 'nsp_newsletter_nonce' );
            echo '<input type="email" name="nsp_email" placeholder="' . esc_attr__( 'Email', 'newsuperprime' ) . '" required>';
            echo '<button type="submit">' . esc_html__( 'Subscribe Now', 'newsuperprime' ) . '</button>';
            echo '</form>';
            echo '</div>';
        }

        echo wp_kses_post( $args['after_widget'] );
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Newsletter', 'newsuperprime' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'newsuperprime' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        return [ 'title' => sanitize_text_field( $new_instance['title'] ) ];
    }
}

/* ============================================================
   Register custom widgets
   ============================================================ */
function nsp_register_widgets() {
    register_widget( 'NSP_Recent_Posts_Widget' );
    register_widget( 'NSP_Newsletter_Widget' );
}
add_action( 'widgets_init', 'nsp_register_widgets' );
