<?php

/**
 * Counts the number of posts
 *
 * @return int
 */
function jwp_fp_count_posts() {
    return wp_count_posts( 'post' )->publish;
}

/**
 * Retrieves the available post categories
 *
 * @return object
 */
function jwp_fp_post_categories() {

    $terms = get_terms( array(
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ) );

    return $terms;
}

/**
 * Customizes the post excerpt
 *
 * @param object $post
 * @param int $length
 * 
 * @return string
 */
function jwp_fp_custom_excerpt( $post, $length = 200 ) {

    if( '' != $post->post_excerpt ) {
        $excerpt = $post->post_excerpt;
    } else {
        $excerpt = strip_tags( $post->post_content );
    }
    
    if ( strlen( $excerpt )  > $length ) {
        $excerpt  = substr( $excerpt, 0, $length );
        $excerpt  = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );
        $excerpt .= ' . . .<a href="' . get_permalink( $post ) . '"><em>continue reading</em></a>';
    }

    return $excerpt;
}