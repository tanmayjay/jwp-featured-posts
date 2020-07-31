<?php

/**
 * Plugin Name:       JWP Featured Posts
 * Plugin URI:        https://github.com/tanmayjay/wordpress/tree/master/10-Settings-API/jwp-featured-posts
 * Description:       A plugin to add add a settings page under settings menu, and a shortcode to show featured posts by using filters from the settings page.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tanmay Kirtania
 * Author URI:        https://linkedin.com/in/tanmay-kirtania
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       jwp-featured-posts
 * 
 * 
 * Copyright (c) 2020 Tanmay Kirtania (jktanmay@gmail.com). All rights reserved.
 * 
 * This program is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see the License URI.
 */

if ( ! defined('ABSPATH') ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class JWP_Featured_Posts {
    
    /**
     * Static class object
     *
     * @var object
     */
    private static $instance;

    const version   = '1.0.0';
    const domain    = 'jwp-featured-posts';
    const shortcode = 'jwp_featured_posts';

    /**
     * Private class constructor
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Private class cloner
     */
    private function __clone() {}

    /**
     * Initializes a singleton instance
     * 
     * @return \JWP_Featured_Posts
     */
    public static function get_instance() {

        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Defines the required constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'JWP_FP_VERSION', self::version );
        define( 'JWP_FP_FILE', __FILE__ );
        define( 'JWP_FP_PATH', __DIR__ );
        define( 'JWP_FP_URL', plugins_url( '', JWP_FP_FILE ) );
        define( 'JWP_FP_ASSETS', JWP_FP_URL . '/assets' );
        define( 'JWP_FP_DOMAIN', self::domain );
        define( 'JWP_FP_SHORTCODE', self::shortcode );
    }

    /**
     * Updates info on plugin activation
     *
     * @return void
     */
    public function activate() {
        $activator = new JWP\JFP\Activator();
        $activator->run();
    }

    /**
     * Initializes the plugin
     *
     * @return void
     */
    public function init_plugin() {

        if ( is_admin() ) {
            new JWP\JFP\Admin();
        }

        new JWP\JFP\Frontend();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \JWP_Featured_Posts
 */
function jwp_featured_posts() {
    return JWP_Featured_Posts::get_instance();
}

//kick off the plugin
jwp_featured_posts();