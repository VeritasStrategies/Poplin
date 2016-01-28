<?php
/**
 * Load and register widgets
 *
 * @package OneHost
 */

require_once THEME_DIR . '/inc/widgets/recent-posts.php';
require_once THEME_DIR . '/inc/widgets/tabs.php';

/**
 * Register widgets
 *
 * @since  1.0
 *
 * @return void
 */
function onehost_register_widgets() {
	register_widget( 'TA_Recent_Posts_Widget' );
	register_widget( 'TA_Tabs_Widget' );
}
add_action( 'widgets_init', 'onehost_register_widgets' );