<?php

namespace JWP\JFP\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

   /**
     * Shortcode class constructor
     */
    function __construct() {
        add_shortcode( JWP_FP_SHORTCODE, [ $this, 'render_shortcode' ] );
    }

    /**
     * Renders shortcode
     *
     * @param array $atts
     * @param string $content
     * 
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
        global $wp;

        $terms    = jwp_fp_post_categories();
        $term_ids = [];

        foreach ( $terms as $term ) {
            $term_ids = $term->term_id;
        }

        $number_posts = get_option( 'jwp_fp_number_posts', 10 );
        $categories   = get_option( 'jwp_fp_categories', $term_ids );
        $order        = get_option( 'jwp_fp_order', 'desc' );
        $order_by     = '';

        if ( $order == 'rand' ) {
            $order_by = $order;
            $order    = '';
        }

        $args = array(
            'numberposts'  => $number_posts,
            'category__in' => $categories,
            'orderby'      => $order_by,
            'order'        => $order,
        );

        $featured_posts = get_posts( $args );
        
        $template = __DIR__ . '/views/featured-archive.php';

        if( file_exists( $template ) ) {
            $content = include $template ;
        }

        return $content;
    }
}