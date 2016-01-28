<?php
/*
 * Plugin Name: TA Testimonial
 * Version: 1.0.0
 * Plugin URI: http://themealien.com/
 * Description: Create and manage testimonial in the easiest way.
 * Author: Theme Alien
 * Author URI: http://themealien.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Define constants **/
define( 'TA_TESTIMONIAL_VER', '1.0.0' );
define( 'TA_TESTIMONIAL_DIR', plugin_dir_path( __FILE__ ) );
define( 'TA_TESTIMONIAL_URL', plugin_dir_url( __FILE__ ) );

/** Load files **/
require_once TA_TESTIMONIAL_DIR . '/inc/class-testimonial.php';
require_once TA_TESTIMONIAL_DIR . '/inc/frontend.php';

new TA_Testimonial;

/**
 * Load language file
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_testimonial_load_text_domain() {
	load_plugin_textdomain( 'ta-testimonial', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

add_action( 'init', 'ta_testimonial_load_text_domain' );
