<?php
/**
 * Hooks for template header
 *
 * @package OneHost
 */

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function onehost_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'onehost' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'onehost_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function onehost_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'onehost_render_title' );
endif;

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0
 */
function onehost_enqueue_scripts() {
	/* Register and enqueue styles */
	wp_register_style( 'onehost-icons', THEME_URL . '/css/font-awesome.min.css', array(), '4.2.0' );
	wp_register_style( 'bootstrap', THEME_URL . '/css/bootstrap.min.css', array(), '3.3.2' );
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto:100,400,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Montserrat:400,700|Raleway:300,500,600,700,400' );

	wp_enqueue_style( 'onehost', get_stylesheet_uri(), array( 'google-fonts', 'bootstrap', 'onehost-icons' ), THEME_VERSION );

	// Load custom color scheme file
	if ( onehost_theme_option( 'custom_color_scheme' ) && onehost_theme_option( 'custom_color_1' ) ) {
		$upload_dir = wp_upload_dir();
		$dir        = path_join( $upload_dir['baseurl'], 'custom-css' );
		$file       = $dir . '/color-scheme.css';
		wp_enqueue_style( 'onehost-color-scheme', $file, THEME_VERSION );
	}

	/** Register and enqueue scripts */
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'onehost-plugins', THEME_URL . "/js/plugins$min.js", array( 'jquery' ), THEME_VERSION, true );

	wp_enqueue_script( 'onehost', THEME_URL . "/js/scripts$min.js", array( 'onehost-plugins' ), THEME_VERSION, true );

	wp_localize_script( 'onehost', 'onehost', array(
		'direction' => is_rtl() ? 'rtl' : '',
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'onehost_enqueue_scripts', 30 );

/**
 * Get favicon and home screen icons
 *
 * @since  1.0
 */
function onehost_header_icons() {
	$favicon = onehost_theme_option( 'favicon' );
	$header_icons =  ( $favicon ) ? '<link rel="shortcut icon" type="image/x-ico" href="' . esc_url( $favicon ) . '" />' : '';

	$icon_ipad_retina = onehost_theme_option( 'icon_ipad_retina' );
	$header_icons .= ( $icon_ipad_retina ) ? '<link rel="apple-touch-icon" href="' . esc_url( $icon_ipad_retina ) . '" />' : '';

	$icon_ipad = onehost_theme_option( 'icon_ipad' );
	$header_icons .= ( $icon_ipad ) ? '<link rel="apple-touch-icon" href="' . esc_url( $icon_ipad ) . '" />' : '';

	$icon_iphone_retina = onehost_theme_option( 'icon_iphone_retina' );
	$header_icons .= ( $icon_iphone_retina ) ? '<link rel="apple-touch-icon" href="' . esc_url( $icon_iphone_retina ). '" />' : '';

	$icon_iphone = onehost_theme_option( 'icon_iphone' );
	$header_icons .= ( $icon_iphone ) ? '<link rel="apple-touch-icon" href="' . esc_url( $icon_iphone ) . '" />' : '';

	echo $header_icons;
}
add_action( 'wp_head', 'onehost_header_icons' );

/**
 * Custom scripts and styles on header
 *
 * @since  1.0
 */
function onehost_header_scripts() {
	$inline_css = '';

	// Logo
	$logo_size_width = intval( onehost_theme_option( 'logo_size_width' ) );
	$logo_css =  ( $logo_size_width ) ? 'width:' . $logo_size_width . 'px; ' : '';

	$logo_size_height = intval( onehost_theme_option( 'logo_size_height' ) );
	$logo_css .=  ( $logo_size_height ) ? 'height:' . $logo_size_height . 'px; ' : '';

	$logo_margin_top = intval( onehost_theme_option( 'logo_margin_top' ) );
	$logo_css .=  ( $logo_margin_top ) ? 'margin-top:' . $logo_margin_top . 'px;' : '';

	$logo_margin_right = intval( onehost_theme_option( 'logo_margin_right' ) );
	$logo_css .=  ( $logo_margin_right ) ? 'margin-right:' . $logo_margin_right . 'px;' : '';

	$logo_margin_bottom = intval( onehost_theme_option( 'logo_margin_bottom' ) );
	$logo_css .=  ( $logo_margin_bottom ) ? 'margin-bottom:' . $logo_margin_bottom . 'px;' : '';

	$logo_margin_left = intval( onehost_theme_option( 'logo_margin_left' ) );
	$logo_css .=  ( $logo_margin_left ) ? 'margin-left:' . $logo_margin_bottom . 'px;' : '';

	if ( ! empty( $logo_css ) ) {
		$inline_css .= '#site-header .site-branding .site-logo img ' . ' {' . $logo_css . '}';
	}


	// Featured Title Area

	$image     = onehost_get_meta( 'singular_title_area_bg' );
	if( $image ) {
		$image = wp_get_attachment_image_src( $image, 'full' );
		$image = $image ? $image[0] : '';
	}

	if( ! $image ) {
		$image        = onehost_theme_option( 'title_area_bg' );
	}

	$featured_css = $image ? "background-image: url($image)" : '';

	if ( ! empty( $featured_css ) ) {
		$inline_css .= '#title-area {' . $featured_css . '}';
	}


	// Custom CSS
	$css_custom = onehost_get_meta( 'custom_css' ) . onehost_theme_option( 'custom_css' );
	if ( ! empty( $css_custom ) ) {
		$inline_css .= $css_custom;
	}

	if ( ! empty( $inline_css ) ) {
		$inline_css = '<style type="text/css">' . $inline_css . '</style>';
	}

	// Custom javascript
	$js_custom = onehost_get_meta( 'custom_js' ) . onehost_theme_option( 'header_scripts' );
	if ( ! empty( $js_custom ) ) {
		$js_custom =  '<script type="text/javascript">' . $js_custom . '</script>' ;
	}

	$inline_css .= $inline_css . $js_custom;
	if( $inline_css ) {
		echo $inline_css;
	}
}
add_action( 'wp_head', 'onehost_header_scripts' );
