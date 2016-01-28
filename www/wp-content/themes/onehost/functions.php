<?php
/**
 * Core functions and definitions
 *
 * @package OneHost
 */

/**
 * Define theme's constant
 */
if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', '1.0' );
}
if ( ! defined( 'onehost' ) ) {
	define( 'onehost', 'stcore' );
}
if ( ! defined( 'THEME_DIR' ) ) {
	define( 'THEME_DIR', get_template_directory() );
}
if ( ! defined( 'THEME_URL' ) ) {
	define( 'THEME_URL', get_template_directory_uri() );
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0
 *
 * @return void
 */
function onehost_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'onehost', get_template_directory() . '/lang' );

	// Theme supports
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'quote', 'link', ) );
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );

	// Register theme nav menu
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'onehost' ),
	) );
}
add_action( 'after_setup_theme', 'onehost_setup' );

/**
 * Initialize additional functions/classes
 *
 * @since 1.0
 */
function onehost_init() {
	new OneHost_VC;

	if ( is_admin() ) {
	} else {
		new OneHost_Shortcodes;
	}
}
add_action( 'after_setup_theme', 'onehost_init' );

/**
 * Add image sizes.
 * Must be added to init hook to remove sizes of portfolio plugin.
 *
 * @since 1.0
 */
function onehost_add_image_sizes() {
	add_image_size( 'blog-thumb', 670, 335, true );
	add_image_size( 'blog-full-thumb', 1140, 470, true );
	add_image_size( 'tiny', 80, 80, true );
	add_image_size( 'widget-thumb', 50, 50, true );

	if ( in_array( 'ta-testimonial/ta-testimonial.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		add_image_size( 'testimonial-thumb', '120', '120', true );
	}

	if ( in_array( 'ta-team/ta-team.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		add_image_size( 'team-member', 261, 261, true );
	}

	if ( in_array( 'ta-portfolio/ta-portfolio.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		add_image_size( 'portfolio-thumbnail-normal', 285, 215, true );
		add_image_size( 'portfolio-thumbnail-wide', 570, 215, true );
		add_image_size( 'portfolio-thumbnail-long', 285, 430, true );
		add_image_size( 'portfolio-project', 770, 450, true );
	}
}
add_action( 'init', 'onehost_add_image_sizes', 20 );

/**
 * Register widgetized area and update sidebar with default widgets.
 *
 * @since 1.0
 *
 * @return void
 */
function onehost_register_sidebar() {
	// Register primary sidebar
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'onehost' ),
		'id'            => 'primary-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register footer sidebar
	register_sidebars( 4, array(
		'name'          => __( 'Footer %d', 'onehost' ),
		'id'            => 'footer-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

    register_sidebar( array(
        'name'          => __( 'WHMCS Sidebar', 'onehost' ),
        'id'            => 'whmcs-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'onehost_register_sidebar' );

/**
 * Load theme
 */

// Theme Options
require THEME_DIR . '/inc/libs/theme-options/framework.php';
require THEME_DIR . '/inc/backend/theme-options.php';

// Widgets
require THEME_DIR . '/inc/widgets/widgets.php';

// Visual composer
require THEME_DIR . '/inc/backend/visual-composer.php';

if ( is_admin() ) {
	require THEME_DIR . '/inc/libs/class-tgm-plugin-activation.php';
	require THEME_DIR . '/inc/backend/plugins.php';
	require THEME_DIR . '/inc/backend/meta-boxes.php';
} else {
	// Frontend functions and shortcodes
	require THEME_DIR . '/inc/functions/media.php';
	require THEME_DIR . '/inc/functions/layout.php';
	require THEME_DIR . '/inc/functions/nav.php';
	require THEME_DIR . '/inc/functions/entry.php';
	require THEME_DIR . '/inc/functions/shortcodes.php';

	// Frontend hooks
	require THEME_DIR . '/inc/frontend/layout.php';
	require THEME_DIR . '/inc/frontend/header.php';
	require THEME_DIR . '/inc/frontend/nav.php';
	require THEME_DIR . '/inc/frontend/entry.php';
}
