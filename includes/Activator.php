<?php

namespace JWP\JFP;

/**
 * Plugin activator class
 */
class Activator {

    /**
     * Runs the activator
     *
     * @return void
     */
    public function run() {
        $this->add_info();
    }

    /**
     * Adds activation info
     *
     * @return void
     */
    public function add_info() {
        $activated = get_option( 'jwp_fp_installed' );

        if ( ! $activated ) {
            update_option( 'jwp_fp_installed', time() );
        }

        update_option( 'jwp_fp_version', JWP_FP_VERSION );
    }
}