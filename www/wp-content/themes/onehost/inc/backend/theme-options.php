<?php
add_filter( 'ta_theme_options', 'onehost_theme_options' );

/**
 * Register theme options fields
 *
 * @since  1.0
 *
 * @return array Theme options fields
 */
function onehost_theme_options() {
	$options = array();

	// Help information
	$options['help'] = array(
		'document' => 'http://themealien.com/docs/tacore',
		'support'  => 'http://themealien.com/support/tacore',
	);


	// Sections
	$options['sections'] = array(
		'general'   => array(
			'icon'  => 'cog',
			'title' => __( 'General', 'onehost' ),
		),
		'layout'     => array(
			'icon'  => 'grid',
			'title' => __( 'Layout', 'onehost' ),
		),
		'style'     => array(
			'icon'  => 'palette',
			'title' => __( 'Style', 'onehost' ),
		),
		'header'    => array(
			'icon'  => 'browser',
			'title' => __( 'Header', 'onehost' ),
		),
		'title_area'     => array(
			'icon'  => 'pencil',
			'title' => __( 'Title Area', 'onehost' ),
		),
		'footer'     => array(
			'icon'  => 'rss',
			'title' => __( 'Footer', 'onehost' ),
		),
		'export'     => array(
			'icon'  => 'upload-to-cloud',
			'title' => __( 'Backup - Restore', 'onehost' ),
		),
	);

	// Fields
	$options['fields']            = array();
	$options['fields']['general'] = array(
		array(
			'name'  => 'favicon',
			'label' => __( 'Favicon', 'onehost' ),
			'type'  => 'icon',
		),
		array(
			'name'     => 'home_screen_icons',
			'label'    => __( 'Home Screen Icons', 'onehost' ),
			'desc'     => __( 'Select image file that will be displayed on home screen of handheld devices.', 'onehost' ),
			'type'     => 'group',
			'children' => array(
				array(
					'name'    => 'icon_ipad_retina',
					'type'    => 'icon',
					'subdesc' => __( 'IPad Retina (144x144px)', 'onehost' ),
				),
				array(
					'name'    => 'icon_ipad',
					'type'    => 'icon',
					'subdesc' => __( 'IPad (72x72px)', 'onehost' ),
				),

				array(
					'name'    => 'icon_iphone_retina',
					'type'    => 'icon',
					'subdesc' => __( 'IPhone Retina (114x114px)', 'onehost' ),
				),

				array(
					'name'    => 'icon_iphone',
					'type'    => 'icon',
					'subdesc' => __( 'IPhone (57x57px)', 'onehost' ),
				)
			)
		),
		array(
			'type'  => 'divider',
		),
		array(
			'name'    => 'preloader',
			'label'   => __( 'Preloader', 'onehost' ),
			'type'    => 'switcher',
			'default' => true,
			'desc'    => __( 'Display a preloader when page is loading', 'onehost' ),
		),
		array(
			'name'    => 'no_animation',
			'label'   => __( 'No Animation', 'onehost' ),
			'type'    => 'switcher',
			'default' => false,
			'desc'    => __( 'Hide all animations.', 'onehost' ),
		),
		array(
			'type' => 'divider'
		),
		array(
			'name'    => 'page_comments',
			'label'   => __( 'Page Comment', 'onehost' ),
			'type'    => 'switcher',
			'default' => false,
			'desc'    => __( 'Display comment form on page', 'onehost' ),
		),
		array(
			'name'    => 'portfolio_comments',
			'label'   => __( 'Portfolio Comment', 'onehost' ),
			'type'    => 'switcher',
			'default' => false,
			'desc'    => __( 'Display comment form on portfolio single page', 'onehost' ),
		),
		array(
			'type'  => 'divider',
			'label' => __( 'Socials Links', 'onehost' ),
		),
		array(
			'name'    => 'social',
			'label'   => __( 'Socials', 'onehost' ),
			'type'    => 'social',
			'subdesc' => __( 'Click to social icon to add link', 'onehost' ),
		),
	);

	$options['fields']['layout'] = array(
		array(
			'name'    => 'default_layout',
			'label'   => __( 'Default Layout', 'onehost' ),
			'desc'    => __( 'Default layout for whole site', 'onehost' ),
			'type'    => 'image_toggle',
			'default' => 'content-sidebar',
			'options' => array(
				'full-content'    => TA_OPTIONS_URL . 'img/sidebars/empty.png',
				'sidebar-content' => TA_OPTIONS_URL . 'img/sidebars/single-left.png',
				'content-sidebar' => TA_OPTIONS_URL . 'img/sidebars/single-right.png',
			)
		),
		array(
			'name'    => 'single_layout',
			'label'   => __( 'Single Layout', 'onehost' ),
			'desc'    => __( 'Default layout of single post', 'onehost' ),
			'type'    => 'image_toggle',
			'default' => 'content-sidebar',
			'options' => array(
				'full-content'    => TA_OPTIONS_URL . 'img/sidebars/empty.png',
				'sidebar-content' => TA_OPTIONS_URL . 'img/sidebars/single-left.png',
				'content-sidebar' => TA_OPTIONS_URL . 'img/sidebars/single-right.png',
			)
		),
		array(
			'name'    => 'page_layout',
			'label'   => __( 'Page Layout', 'onehost' ),
			'desc'    => __( 'Default layout of single page', 'onehost' ),
			'type'    => 'image_toggle',
			'default' => 'full-content',
			'options' => array(
				'full-content'    => TA_OPTIONS_URL . 'img/sidebars/empty.png',
				'sidebar-content' => TA_OPTIONS_URL . 'img/sidebars/single-left.png',
				'content-sidebar' => TA_OPTIONS_URL . 'img/sidebars/single-right.png',
			)
		),
	);

	$options['fields']['style'] = array(
		array(
			'name'    => 'site_style',
			'label'   => __( 'Site Scheme', 'onehost' ),
			'type'    => 'toggle',
			'default' => 'dark',
			'options' => array(
				'dark'  => __( 'Dark', 'onehost' ),
				'light' => __( 'Light', 'onehost' ),
			),
		),
		array(
			'name'    => 'color_scheme',
			'label'   => __( 'Color Scheme', 'onehost' ),
			'desc'    => __( 'Select color scheme for website', 'onehost' ),
			'type'    => 'color_scheme',
			'default' => '',
			'options' => array(
				''         => '#47a6db',
				'blue'     => '#428bca',
				'green'    => '#88c136',
				'red'      => '#e54242',
				'orange'   => '#DB5E47',
				'yellow'   => '#ff9c00',
				'brown'    => '#987654',
				'cyan'     => '#1ABC9C',
				'sky-blue' => '#00cdcd',
				'gray'     => '#656565',
			)
		),
		array(
			'name'     => 'custom_color_scheme',
			'label'    => __( 'Custom Color Scheme', 'onehost' ),
			'desc'     => __( 'Enable custom color scheme to pick your own color scheme', 'onehost' ),
			'type'     => 'group',
			'layout'   => 'vertical',
			'children' => array(
				array(
					'name'    => 'custom_color_scheme',
					'type'    => 'switcher',
					'default' => false,
				),
				array(
					'name'    => 'custom_color_1',
					'type'    => 'color',
					'subdesc' => __( 'Custom Color', 'onehost' ),
				),
			)
		),
		array(
			'type'  => 'divider',
		),
		array(
			'name'     => 'custom_css',
			'label'    => __( 'Custom CSS', 'onehost' ),
			'type'     => 'code_editor',
			'language' => 'css',
			'subdesc'  => __( 'Enter your custom style rulers here', 'onehost' )
		),
	);

	$options['fields']['header'] = array(
		array(
			'name'  => 'logo',
			'label' => __( 'Logo', 'onehost' ),
			'desc'  => __( 'Select logo from media library or upload new one', 'onehost' ),
			'type'  => 'image',
		),
		array(
			'name'     => 'logo_size',
			'label'    => __( 'Logo Size (Optional)', 'onehost' ),
			'desc'     => __( 'If the Retina Logo uploaded, please enter the size of the Standard Logo just upload above (not the Retina Logo)', 'onehost' ),
			'type'     => 'group',
			'children' => array(
				array(
					'name'    => 'logo_size_width',
					'type'    => 'number',
					'subdesc' => __( '(Width)', 'onehost' ),
					'suffix'  => 'px'
				),
				array(
					'name'    => 'logo_size_height',
					'type'    => 'number',
					'subdesc' => __( '(Height)', 'onehost' ),
					'suffix'  => 'px'
				),
			)
		),
		array(
			'name'     => 'logo_margin',
			'label'    => __( 'Logo Margin', 'onehost' ),
			'type'     => 'group',
			'children' => array(
				array(
					'name'    => 'logo_margin_top',
					'type'    => 'number',
					'size'    => 'mini',
					'subdesc' => __( 'top', 'onehost' ),
					'suffix'  => 'px'
				),
				array(
					'name'    => 'logo_margin_right',
					'type'    => 'number',
					'size'    => 'mini',
					'subdesc' => __( 'right', 'onehost' ),
					'suffix'  => 'px'
				),
				array(
					'name'    => 'logo_margin_bottom',
					'type'    => 'number',
					'size'    => 'mini',
					'subdesc' => __( 'bottom', 'onehost' ),
					'suffix'  => 'px'
				),
				array(
					'name'    => 'logo_margin_left',
					'type'    => 'number',
					'size'    => 'mini',
					'subdesc' => __( 'left', 'onehost' ),
					'suffix'  => 'px'
				),
			)
		),
		array(
			'type'  => 'divider',
		),
		array(
			'name'  => 'header_scripts',
			'label' => __( 'Header Script', 'onehost' ),
			'desc'  => __( 'Enter your custom scripts here like Google Analytics script', 'onehost' ),
			'type'  => 'code_editor',
		),
	);

	$options['fields']['title_area'] = array(
		array(
			'name'  => 'title_area_bg',
			'label' => __( 'Background Image', 'onehost' ),
			'type'  => 'image',
		),
	);

	$options['fields']['footer'] = array(
		array(
			'name'    => 'footer_widgets',
			'label'   => __( 'Enable Footer Widget', 'onehost' ),
			'type'    => 'switcher',
			'default' => 1,
		),
		array(
			'name'    => 'footer_widget_columns',
			'label'   => __( 'Footer Widget Columns', 'onehost' ),
			'desc'    => __( 'How many sidebar you want to show on footer', 'onehost' ),
			'type'    => 'image_toggle',
			'default' => 'three-columns',
			'options' => array(
				'1' => TA_OPTIONS_URL . 'img/footer/one-column.png',
				'2' => TA_OPTIONS_URL . 'img/footer/two-columns.png',
				'3' => TA_OPTIONS_URL . 'img/footer/three-columns.png',
				'4' => TA_OPTIONS_URL . 'img/footer/four-columns.png',
			)
		),
		array(
			'type' => 'divider'
		),
		array(
			'name'    => 'footer_copyright',
			'label'   => __( 'Footer Copyright', 'onehost' ),
			'subdesc' => __( 'Shortcodes are allowed', 'onehost' ),
			'type'    => 'editor',
			'default' => __( 'Copyright &copy; 2014', 'onehost' ),
		),
		array(
			'name'  => 'footer_script',
			'label' => __( 'Footer Scripts', 'onehost' ),
			'type'  => 'code_editor',
		),
	);

	$options['fields']['export'] = array(
		array(
			'name'    => 'backup',
			'label'   => __( 'Backup Settings', 'onehost' ),
			'subdesc' => __( 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options" button above', 'onehost' ),
			'type'    => 'backup',
		),
	);

	return $options;
}
