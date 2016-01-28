<?php
/**
 * Register meta boxes
 *
 * @since 1.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function onehost_register_meta_boxes( $meta_boxes ) {
	// Post format
	$meta_boxes[] = array(
		'id'       => 'format_detail',
		'title'    => __( 'Format Details', 'onehost' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'             => __( 'Image', 'onehost' ),
				'id'               => 'image',
				'type'             => 'image_advanced',
				'class'            => 'image',
				'max_file_uploads' => 1,
			),
			array(
				'name'  => __( 'Gallery', 'onehost' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => __( 'Audio', 'onehost' ),
				'id'    => 'audio',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'audio',
			),
			array(
				'name'  => __( 'Video', 'onehost' ),
				'id'    => 'video',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'video',
			),
			array(
				'name'  => __( 'Link', 'onehost' ),
				'id'    => 'url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => __( 'Text', 'onehost' ),
				'id'    => 'url_text',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => __( 'Quote', 'onehost' ),
				'id'    => 'quote',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'quote',
			),
			array(
				'name'  => __( 'Author', 'onehost' ),
				'id'    => 'quote_author',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => __( 'URL', 'onehost' ),
				'id'    => 'author_url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => __( 'Status', 'onehost' ),
				'id'    => 'status',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'status',
			),
		),
	);

	// Page/Post Settings
	$meta_boxes[] = array(
		'id'       => 'page_settings',
		'title'    => __( 'Display Settings', 'onehost' ),
		'pages'    => array( 'post', 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __( 'Title Area', 'onehost' ),
				'id'   => 'heading_title_area',
				'type' => 'heading',
			),
			array(
				'name'  => __( 'Hide Title Area', 'onehost' ),
				'id'    => 'hide_singular_title_area',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name'             => __( 'Title Area Background', 'onehost' ),
				'id'               => 'singular_title_area_bg',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'class'            => 'bg-title-area'
			),
			array(
				'name' => __( 'Title', 'onehost' ),
				'id'   => 'heading_title',
				'type' => 'heading',
			),
			array(
				'name'  => __( 'Hide the Title', 'onehost' ),
				'id'    => 'hide_singular_title',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name' => __( 'Layout & Styles', 'onehost' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name'  => __( 'Custom Layout', 'onehost' ),
				'id'    => 'custom_layout',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name'            => __( 'Layout', 'onehost' ),
				'id'              => 'layout',
				'type'            => 'image_select',
				'class'           => 'custom-layout',
				'options'         => array(
					'full-content'    => THEME_URL . '/inc/libs/theme-options/img/sidebars/empty.png',
					'sidebar-content' => THEME_URL . '/inc/libs/theme-options/img/sidebars/single-left.png',
					'content-sidebar' => THEME_URL . '/inc/libs/theme-options/img/sidebars/single-right.png',
				),
			),
			array(
				'name'  => __( 'Custom Css', 'onehost' ),
				'id'    => 'custom_css',
				'type'  => 'textarea',
				'std'   => false,
			),
			array(
				'name'  => __( 'Custom JavaScript', 'onehost' ),
				'id'    => 'custom_js',
				'type'  => 'textarea',
				'std'   => false,
			),
		),
	);

	$meta_boxes[] = array(
		'id'       => 'testimonial_general',
		'title'    => __( 'General', 'onehost' ),
		'pages'    => array( 'testimonial' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name' => __( 'Star Rating', 'onehost' ),
				'id'   => 'star',
				'type' => 'slider',
				'js_options' => array(
					'min'  => 0,
					'max'  => 5,
					'step' => 0.5,
				),
			),
		)
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'onehost_register_meta_boxes' );

/**
 * Enqueue scripts for admin
 *
 * @since  1.0
 */
function onehost_admin_enqueue_scripts( $hook ) {
	// Detect to load un-minify scripts when WP_DEBUG is enable
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'onehost-backend-js', THEME_URL . "/js/backend/admin$min.js", array( 'jquery' ), THEME_VERSION, true );
	}
}

add_action( 'admin_enqueue_scripts', 'onehost_admin_enqueue_scripts' );

/**
 * Generate custom color scheme css
 *
 * @since 1.0
 */
function onehost_generate_custom_color_scheme() {
	parse_str( $_POST['data'], $data );

    if ( ! isset( $data['custom_color_scheme'] ) || ! $data['custom_color_scheme'] ) {
        return;
    }

    $color_1 = $data['custom_color_1'];
    if ( ! $color_1 ) {
        return;
    }

    // Getting credentials
    $url = wp_nonce_url( 'themes.php?page=theme-options' );
    if ( false === ( $creds = request_filesystem_credentials( $url, '', false, false, null ) ) ) {
        return; // stop the normal page form from displaying
    }

    // Try to get the wp_filesystem running
    if ( ! WP_Filesystem( $creds ) ) {
        // Ask the user for them again
        request_filesystem_credentials( $url, '', true, false, null );
        return;
    }

    global $wp_filesystem;

    // Prepare LESS to compile
    $less = $wp_filesystem->get_contents( THEME_DIR . '/css/color-schemes/mixin.less' );
    $less .= ".custom-color-scheme { .color-scheme($color_1); }";

    // Compile
    require THEME_DIR . '/inc/libs/lessc.inc.php';
    $compiler = new lessc;
    $compiler->setFormatter( 'compressed' );
    $css = $compiler->compile( $less );

    // Get file path
    $upload_dir = wp_upload_dir();
    $dir = path_join( $upload_dir['basedir'], 'custom-css' );
    $file = $dir . '/color-scheme.css';

    // Create directory if it doesn't exists
    wp_mkdir_p( $dir );
    $wp_filesystem->put_contents( $file, $css, FS_CHMOD_FILE );

    wp_send_json_success();
}

add_action( 'theme_alien_generate_custom_css', 'onehost_generate_custom_color_scheme' );
