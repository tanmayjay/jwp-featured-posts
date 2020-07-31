<?php

namespace JWP\JFP\Admin;

/**
 * Menu handler class
 */
class Menu {

    const settings_page    = 'jwp-featured-posts';
    const settings_section = 'jwp_fp_settings';

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'admin_init', [ $this, 'settings_page_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Initializes settings page
     *
     * @return void
     */
    public function settings_page_init() {
        register_setting( self::settings_page, 'jwp_fp_number_posts' );
        register_setting( self::settings_page, 'jwp_fp_categories' );
        register_setting( self::settings_page, 'jwp_fp_order' );

        add_settings_section( 
            self::settings_section, 
            __( 'Featured Posts Settings', JWP_FP_DOMAIN ), 
            [ $this, 'settings_fields' ], 
            self::settings_page 
        );
    }

    /**
     * Defines the settings fields
     *
     * @return void
     */
    public function settings_fields() {

        add_settings_field( 
            'jwp_fp_number_posts', 
            __( 'Number of {osts', JWP_FP_DOMAIN ), 
            [ $this, 'number_posts_select_list' ], 
            self::settings_page, 
            self::settings_section,
            [ 
                'label_for'    => 'jwp_fp_number_posts',
                'total_posts'  => jwp_fp_count_posts(),
                'number_posts' => 10   
            ]
        );

        add_settings_field( 
            'jwp_fp_categories', 
            __( 'Select Categories', JWP_FP_DOMAIN ), 
            [ $this, 'category_checkbox' ], 
            self::settings_page, 
            self::settings_section,
            [ 
                'label_for'  => 'jwp_fp_categories',
                'categories' => jwp_fp_post_categories(), 
            ]
        );

        add_settings_field( 
            'jwp_fp_order', 
            __( 'Select Order', JWP_FP_DOMAIN ), 
            [ $this, 'order_select_list' ], 
            self::settings_page, 
            self::settings_section,
            [ 
                'label_for' => 'jwp_fp_order',
                'orders'    => [ 
                    'Ascending'  => 'asc', 
                    'Descending' => 'desc', 
                    'Random'     => 'rand' 
                ],
            ]
        );
    }

    /**
     * Renders admin menu
     *
     * @return void
     */
    public function admin_menu() {
        add_options_page( 
            __( 'JWP Featured Posts', JWP_FP_DOMAIN ),
            __( 'Featured Posts', JWP_FP_DOMAIN ),
            'manage_options',
            self::settings_page, 
            [ $this, 'settings_page' ],
            0
        );
    }

    /**
     * Renders settings page
     *
     * @return void
     */
    public function settings_page() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error( 'jwp_fp_messages', 'jwp_fp_message', __( 'Settings Saved', JWP_FP_DOMAIN ), 'updated' );
        }
        
        settings_errors( 'jwp_fp_messages' );
        ?>
        <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
        <?php
        settings_fields( self::settings_page );

        do_settings_sections( self::settings_page );

        submit_button( __( 'Save Settings', JWP_FP_DOMAIN ) );
        ?>
        </form>
        </div>
        <?php
    }

    /**
     * Renders select list for number of posts
     *
     * @param array $args
     * 
     * @return void
     */
    public function number_posts_select_list( $args ) {
        $field_id    = $args['label_for'];
        $total_posts = $args['total_posts'];
        $value       = get_option( $field_id );
        
        if ( ! $value ) {
            $value = $args['number_posts'];
        }
        
        printf( "<select name='%s' id='%s'>", $field_id, $field_id );

        for ( $i = 1; $i <= $total_posts; ++ $i ) {
            $selected = '';

            if ( $i == $value ) {
                $selected = 'selected';
            }

            printf( "<option value=%d %s>%d</option>", $i, $selected, $i );
        }
        
        printf( "</select>" );
    }

    /**
     * Renders checkbox for category
     *
     * @param array $args
     * 
     * @return void
     */
    public function category_checkbox( $args ) {
        $field_id   = $args['label_for'];
        $categories = $args['categories'];
        $values     = get_option( $field_id );

        foreach ( $categories as $category ) {
            $checked = '';
            
            if ( is_array( $values ) && in_array( $category->term_id, $values ) ) {
                $checked = 'checked';
            }

            printf( "<input type='checkbox' name=%s id=%s value=%d %s />%s<br/>", $field_id . '[]', $field_id, $category->term_id, $checked, $category->name );
        }
    }

    /**
     * Renders select list for order
     *
     * @param array $args
     * 
     * @return void
     */
    public function order_select_list( $args ) {
        $field_id     = $args['label_for'];
        $orders       = $args['orders'];
        $option_value = get_option( $field_id );
        
        if ( ! $option_value ) {
            $option_value = $orders['Descending'];
        }
        
        printf( "<select name='%s' id='%s'>", $field_id, $field_id );

        foreach ( $orders as $order => $value ) {
            $selected = '';

            if ( $value == $option_value ) {
                $selected = 'selected';
            }

            printf( "<option value=%s %s>%s</option>", $value, $selected, $order );
        }
        
        printf( "</select>" );
    }
}