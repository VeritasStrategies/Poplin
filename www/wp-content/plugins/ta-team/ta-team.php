<?php
/*
 * Plugin Name: TA Team Management
 * Version: 1.0.0
 * Plugin URI: http://themealien.com/
 * Description: Create and manage your team member present them in the easiest way.
 * Author: Theme Alien
 * Author URI: http://themealien.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Define constants **/
define( 'TA_TEAM_VER', '1.0.0' );
define( 'TA_TEAM_DIR', plugin_dir_path( __FILE__ ) );
define( 'TA_TEAM_URL', plugin_dir_url( __FILE__ ) );

/** Load files **/
require_once TA_TEAM_DIR . '/inc/class-team-member.php';
require_once TA_TEAM_DIR . '/inc/class-showcase.php';
require_once TA_TEAM_DIR . '/inc/shortcodes.php';
require_once TA_TEAM_DIR . '/inc/frontend.php';

new TA_Team_Member;
new TA_Team_Showcase;

/**
 * Add image sizes
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_team_image_sizes_init() {
	add_image_size( 'team-member', 300, 300, true );
}

add_action( 'init', 'ta_team_image_sizes_init' );

/**
 * Load language file
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_team_load_text_domain() {
	load_plugin_textdomain( 'ta-team', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

add_action( 'init', 'ta_team_load_text_domain' );
