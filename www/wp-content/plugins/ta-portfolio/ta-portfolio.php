<?php
/*
 * Plugin Name: TA Portfolio Management
 * Version: 1.0.2
 * Plugin URI: http://themealien.com/
 * Description: Create and manage your works you have done and present them in the easiest way.
 * License: GPL-2.0+
 * Author: Theme Alien
 * Author URI: http://themealien.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Define constants */
if ( ! defined( 'TA_PORTFOLIO_VER' ) ) {
	define( 'TA_PORTFOLIO_VER', '1.0.2' );
}
if ( ! defined( 'TA_PORTFOLIO_DIR' ) ) {
	define( 'TA_PORTFOLIO_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'TA_PORTFOLIO_URL' ) ) {
	define( 'TA_PORTFOLIO_URL', plugin_dir_url( __FILE__ ) );
}

/** Load files */
require_once TA_PORTFOLIO_DIR . '/inc/class-portfolio.php';
require_once TA_PORTFOLIO_DIR . '/inc/class-showcase.php';
require_once TA_PORTFOLIO_DIR . '/inc/shortcodes.php';
require_once TA_PORTFOLIO_DIR . '/inc/frontend.php';

/**
 * Init plugin
 *
 * @since 1.1
 *
 * @return void
 */
function ta_portfolio_init() {
	new TA_Portfolio;
	new TA_Portfolio_Showcase;
}

add_action( 'plugins_loaded', 'ta_portfolio_init' );

/**
 * Add image sizes
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_portfolio_image_sizes_init() {
	add_image_size( 'portfolio-thumbnail-normal', 400, 260, true );
	add_image_size( 'portfolio-thumbnail-wide', 800, 260, true );
	add_image_size( 'portfolio-thumbnail-long', 400, 520, true );
}

add_action( 'init', 'ta_portfolio_image_sizes_init' );

/**
 * Load language file
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_portfolio_load_text_domain() {
	load_plugin_textdomain( 'ta-portfolio', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

add_action( 'init', 'ta_portfolio_load_text_domain' );
