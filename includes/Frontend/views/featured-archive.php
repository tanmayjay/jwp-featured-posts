<?php 
/**
 * The template for displaying featured posts archive
 *
 * @link https://github.com/tanmayjay/wordpress/tree/master/10-Settings-API/jwp-featured-posts/includes/Frontend/views
 *
 * @package JWP_Featured_Posts
 * @subpackage Archive Featured Posts
 * @version 1.0
 */

get_header();
?>

<div id="primary" class="content-area" style="padding-top:5px">
    <main id="main" class="site-main">

    <?php        
    foreach ( $featured_posts as $post) : setup_postdata( $post );
    ?>
        <h2 class="entry-title">
        <a href="<?php echo get_permalink( $post ) ?>" title="<?php echo get_the_title( $post ) ?>" rel="bookmark"><?php echo get_the_title( $post ); ?></a>
        </h2> 

        <div>
            <?php echo jwp_fp_custom_excerpt( $post, 100 ); ?>
        </div>
        <hr>
    <?php
    wp_reset_postdata();
    endforeach;
    ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
