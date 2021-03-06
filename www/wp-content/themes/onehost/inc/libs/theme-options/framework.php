<?php
/**
 * Theme Alien Options Framework
 * Premium theme option framework
 *
 * @package Theme Alien Options Framework
 */

/**
 * Main class to load framework
 *
 * @author Theme Alien
 * @version 1.0.1
 */
class TA_Theme_Options {
	/**
	 * Store theme options
	 *
	 * @var array
	 */
	public static $options;

	/**
	 * Store theme default settings
	 *
	 * @var array
	 */
	public static $defaults = array();

	/**
	 * Initialize framework
	 *
	 * @since  1.0
	 *
	 * @return void
	 */
	public static function init() {
		// Define constants
		self::constants();

		// Theme options
		self::$options = apply_filters( 'ta_theme_options', null );

		if ( empty( self::$options ) ) {
			return;
		}

		// Default settings
		self::default_settings();

		// Register auto loader
		spl_autoload_register( array( __CLASS__, 'autoload' ) );

		if ( is_admin() ) {
			new TA_Theme_Options_Admin( self::$options );
		}
	}

	/**
	 * Define framework constants
	 *
	 * @since  1.0
	 *
	 * @return void
	 */
	public static function constants() {
		$content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
		$content_dir = untrailingslashit( dirname( dirname( get_stylesheet_directory() ) ) );
		$content_dir = str_replace( '\\', '/', $content_dir );

		$dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
		$url = trailingslashit( str_replace( $content_dir, $content_url, $dir ) );

		define( 'TA_OPTIONS_DIR', $dir );
		define( 'TA_OPTIONS_URL', $url );
	}

	/**
	 * Define default settings
	 *
	 * @since  1.0
	 *
	 * @return array fields
	 */
	public static function default_settings() {
		// Just store default values
		foreach ( self::$options['fields'] as $fields ) {
			foreach ( $fields as $field ) {
				if ( isset( $field['name'] ) ) {
					self::$defaults[$field['name']] = isset( $field['default'] ) ? $field['default'] : '';
				}

				// Store children fields of group
				if ( 'group' == $field['type'] ) {
					foreach ( $field['children'] as $child ) {
						self::$defaults[$child['name']] = isset( $child['default'] ) ? $child['default'] : '';
					}
				}
			}
		}
	}

	/**
	 * Register auto loader
	 *
	 * @since  1.0
	 *
	 * @param  string $class Class name
	 *
	 * @return void
	 */
	public static function autoload( $class ) {
		if ( 0 !== strpos( $class, 'TA_Theme_Options' ) ) {
			return;
		}

		$file = strtolower( substr( $class, 16 ) );
		$file = str_replace( '_', '/class-', $file ) . '.php';

		require_once TA_OPTIONS_DIR . 'inc/' . $file;
	}

	/**
	 * Get theme option value
	 *
	 * @since  1.0
	 *
	 * @param  string $name Option name
	 *
	 * @return mixed
	 */
	public static function get_option( $name ) {
		global $_ta_theme_options;

		if ( null === $_ta_theme_options ) {
			$_ta_theme_options = get_theme_mods();
		}

		// Return saved setting
		if ( isset( $_ta_theme_options[$name] ) ) {
			return $_ta_theme_options[$name];
		}

		// Return default setting
		if ( isset( TA_Theme_Options::$defaults[$name] ) ) {
			return TA_Theme_Options::$defaults[$name];
		}

		return false;
	}
}

add_action( 'init', array( 'TA_Theme_Options', 'init' ) );


/**
 * Get theme option value
 *
 * @since  1.0
 *
 * @param  string $name Option name
 *
 * @return mixed
 */
function onehost_theme_option( $name ) {
    return TA_Theme_Options::get_option( $name );
}
