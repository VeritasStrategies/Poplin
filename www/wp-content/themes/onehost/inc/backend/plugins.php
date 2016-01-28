<?php
/**
 * Register required plugins
 *
 * @since  1.0
 * @return void
 */
function onehost_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Meta Box',
			'slug'               => 'meta-box',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'WPBakery Visual Composer',
			'slug'               => 'js_composer',
			'source'             => THEME_DIR . '/plugins/js_composer.zip',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'Revolution Slider',
			'slug'               => 'revslider',
			'source'             => THEME_DIR . '/plugins/revslider.zip',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'Contact Form 7',
			'slug'               => 'contact-form-7',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'TA Portfolio Management',
			'slug'               => 'ta-portfolio',
			'source'             => THEME_DIR . '/plugins/ta-portfolio.zip',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'TA Team Management',
			'slug'               => 'ta-team',
			'source'             => THEME_DIR . '/plugins/ta-team.zip',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'TA Testimonial',
			'slug'               => 'ta-testimonial',
			'source'             => THEME_DIR . '/plugins/ta-testimonial.zip',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'WHMCS Bridge',
			'slug'               => 'whmcs-bridge',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
	);
	$config = array(
		'domain'       		=> 'onehost',
		'default_path' 		=> '',
		'parent_menu_slug' 	=> 'themes.php',
		'parent_url_slug' 	=> 'themes.php',
		'menu'         		=> 'install-required-plugins',
		'has_notices'      	=> true,
		'is_automatic'    	=> false,
		'message' 			=> '',
		'strings'      		=> array(
			'page_title'                      => __( 'Install Required Plugins', 'onehost' ),
			'menu_title'                      => __( 'Install Plugins', 'onehost' ),
			'installing'                      => __( 'Installing Plugin: %s', 'onehost' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'onehost' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'onehost'  ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'onehost' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'onehost' ),
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'onehost' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'onehost' ),
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'onehost' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'onehost' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'onehost' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'onehost' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'onehost' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'onehost' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'onehost' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'onehost' ),
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'onehost_register_required_plugins' );