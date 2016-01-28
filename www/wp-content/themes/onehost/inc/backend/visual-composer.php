<?php
/**
 * Custom functions for Visual Composer
 *
 * @package OneHost
 * @subpackage Visual Composer
 */

class OneHost_VC {
	public $icons;

	/**
	 * Construction
	 */
	function __construct() {
		// Stop if VC is not installed
		if ( ! in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return false;
		}

		$this->icons = $this->get_icons();

		add_shortcode_param( 'icon', array( $this, 'icon_param' ), THEME_URL . '/js/vc/icon-field.js' );
		add_action( 'vc_before_init', array( $this, 'map_shortcodes' ) );

	}

	/**
	 * Define icon classes
	 *
	 * @return array
	 */
	function get_icons() {
		return array('fa-adjust', 'fa-adn', 'fa-align-center', 'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-ambulance', 'fa-anchor', 'fa-android', 'fa-angellist', 'fa-angle-double-down', 'fa-angle-double-left', 'fa-angle-double-right', 'fa-angle-double-up', 'fa-angle-down', 'fa-angle-left', 'fa-angle-right', 'fa-angle-up', 'fa-apple', 'fa-archive', 'fa-area-chart', 'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-left', 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-up', 'fa-arrow-circle-right', 'fa-arrow-circle-up', 'fa-arrow-down', 'fa-arrow-left', 'fa-arrow-right', 'fa-arrow-up', 'fa-arrows', 'fa-arrows-alt', 'fa-arrows-h', 'fa-arrows-v', 'fa-asterisk', 'fa-at', 'fa-automobile', 'fa-backward', 'fa-ban', 'fa-bank', 'fa-bar-chart', 'fa-bar-chart-o', 'fa-barcode', 'fa-bars', 'fa-beer', 'fa-behance', 'fa-behance-square', 'fa-bell', 'fa-bell-o', 'fa-bell-slash', 'fa-bell-slash-o', 'fa-bicycle', 'fa-binoculars', 'fa-birthday-cake', 'fa-bitbucket', 'fa-bitbucket-square', 'fa-bitcoin', 'fa-bold', 'fa-bolt', 'fa-bomb', 'fa-book', 'fa-bookmark', 'fa-bookmark-o', 'fa-briefcase', 'fa-btc', 'fa-bug', 'fa-building', 'fa-building-o', 'fa-bullhorn', 'fa-bullseye', 'fa-bus', 'fa-cab', 'fa-calculator', 'fa-calendar', 'fa-calendar-o', 'fa-camera', 'fa-camera-retro', 'fa-car', 'fa-caret-down', 'fa-caret-left', 'fa-caret-right', 'fa-caret-square-o-down', 'fa-caret-square-o-left', 'fa-caret-square-o-right', 'fa-caret-square-o-up', 'fa-caret-up', 'fa-cc', 'fa-cc-amex', 'fa-cc-discover', 'fa-cc-mastercard', 'fa-cc-paypal', 'fa-cc-stripe', 'fa-cc-visa', 'fa-certificate', 'fa-chain', 'fa-chain-broken', 'fa-check', 'fa-check-circle', 'fa-check-circle-o', 'fa-check-square', 'fa-check-square-o', 'fa-chevron-circle-down', 'fa-chevron-circle-left', 'fa-chevron-circle-right', 'fa-chevron-circle-up', 'fa-chevron-down', 'fa-chevron-left', 'fa-chevron-right', 'fa-chevron-up', 'fa-child', 'fa-circle', 'fa-circle-o', 'fa-circle-o-notch', 'fa-circle-thin', 'fa-clipboard', 'fa-clock-o', 'fa-close', 'fa-cloud', 'fa-cloud-download', 'fa-cloud-upload', 'fa-cny', 'fa-code', 'fa-code-fork', 'fa-codepen', 'fa-coffee', 'fa-cog', 'fa-cogs', 'fa-columns', 'fa-comment', 'fa-comment-o', 'fa-comments', 'fa-comments-o', 'fa-compass', 'fa-compress', 'fa-copy', 'fa-copyright', 'fa-credit-card', 'fa-crop', 'fa-crosshairs', 'fa-css3', 'fa-cube', 'fa-cubes', 'fa-cut', 'fa-cutlery', 'fa-dashboard', 'fa-database', 'fa-dedent', 'fa-delicious', 'fa-desktop', 'fa-deviantart', 'fa-digg', 'fa-dollar', 'fa-dot-circle-o', 'fa-download', 'fa-dribbble', 'fa-dropbox', 'fa-drupal', 'fa-edit', 'fa-eject', 'fa-ellipsis-h', 'fa-ellipsis-v', 'fa-empire', 'fa-envelope', 'fa-envelope-o', 'fa-envelope-square', 'fa-eraser', 'fa-eur', 'fa-euro', 'fa-exchange', 'fa-exclamation', 'fa-exclamation-circle', 'fa-exclamation-triangle', 'fa-expand', 'fa-external-link', 'fa-external-link-square', 'fa-eye', 'fa-eye-slash', 'fa-eyedropper', 'fa-facebook', 'fa-facebook-square', 'fa-fast-backward', 'fa-fast-forward', 'fa-fax', 'fa-female', 'fa-fighter-jet', 'fa-file', 'fa-file-archive-o', 'fa-file-audio-o', 'fa-file-code-o', 'fa-file-excel-o', 'fa-file-image-o', 'fa-file-movie-o', 'fa-file-o', 'fa-file-pdf-o', 'fa-file-photo-o', 'fa-file-picture-o', 'fa-file-powerpoint-o', 'fa-file-sound-o', 'fa-file-text', 'fa-file-text-o', 'fa-file-video-o', 'fa-file-word-o', 'fa-file-zip-o', 'fa-files-o', 'fa-film', 'fa-filter', 'fa-fire', 'fa-fire-extinguisher', 'fa-flag', 'fa-flag-checkered', 'fa-flag-o', 'fa-flash', 'fa-flask', 'fa-flickr', 'fa-floppy-o', 'fa-folder', 'fa-folder-o', 'fa-folder-open', 'fa-folder-open-o', 'fa-font', 'fa-forward', 'fa-foursquare', 'fa-frown-o', 'fa-futbol-o', 'fa-gamepad', 'fa-gavel', 'fa-gbp', 'fa-ge', 'fa-gear', 'fa-gears', 'fa-gift', 'fa-git', 'fa-git-square', 'fa-github', 'fa-github-alt', 'fa-github-square', 'fa-gittip', 'fa-glass', 'fa-globe', 'fa-google', 'fa-google-plus', 'fa-google-plus-square', 'fa-google-wallet', 'fa-graduation-cap', 'fa-group', 'fa-h-square', 'fa-hacker-news', 'fa-hand-o-down', 'fa-hand-o-left', 'fa-hand-o-right', 'fa-hand-o-up', 'fa-hdd-o', 'fa-header', 'fa-headphones', 'fa-heart', 'fa-heart-o', 'fa-history', 'fa-home', 'fa-hospital-o', 'fa-html5', 'fa-ils', 'fa-image', 'fa-inbox', 'fa-indent', 'fa-info', 'fa-info-circle', 'fa-inr', 'fa-instagram', 'fa-institution', 'fa-ioxhost', 'fa-italic', 'fa-joomla', 'fa-jpy', 'fa-jsfiddle', 'fa-key', 'fa-keyboard-o', 'fa-krw', 'fa-language', 'fa-laptop', 'fa-lastfm', 'fa-lastfm-square', 'fa-leaf', 'fa-legal', 'fa-lemon-o', 'fa-level-down', 'fa-level-up', 'fa-life-bouy', 'fa-life-buoy', 'fa-life-ring', 'fa-life-saver', 'fa-lightbulb-o', 'fa-line-chart', 'fa-link', 'fa-linkedin', 'fa-linkedin-square', 'fa-linux', 'fa-list', 'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-location-arrow', 'fa-lock', 'fa-long-arrow-down', 'fa-long-arrow-left', 'fa-long-arrow-right', 'fa-long-arrow-up', 'fa-magic', 'fa-magnet', 'fa-mail-forward', 'fa-mail-reply', 'fa-mail-reply-all', 'fa-male', 'fa-map-marker', 'fa-maxcdn', 'fa-meanpath', 'fa-medkit', 'fa-meh-o', 'fa-microphone', 'fa-microphone-slash', 'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mobile', 'fa-mobile-phone', 'fa-money', 'fa-moon-o', 'fa-mortar-board', 'fa-music', 'fa-navicon', 'fa-newspaper-o', 'fa-openid', 'fa-outdent', 'fa-pagelines', 'fa-paint-brush', 'fa-paper-plane', 'fa-paper-plane-o', 'fa-paperclip', 'fa-paragraph', 'fa-paste', 'fa-pause', 'fa-paw', 'fa-paypal', 'fa-pencil', 'fa-pencil-square', 'fa-pencil-square-o', 'fa-phone', 'fa-phone-square', 'fa-photo', 'fa-picture-o', 'fa-pie-chart', 'fa-pied-piper', 'fa-pied-piper-alt', 'fa-pinterest', 'fa-pinterest-square', 'fa-plane', 'fa-play', 'fa-play-circle', 'fa-play-circle-o', 'fa-plug', 'fa-plus', 'fa-plus-circle', 'fa-plus-square', 'fa-plus-square-o', 'fa-power-off', 'fa-print', 'fa-puzzle-piece', 'fa-qq', 'fa-qrcode', 'fa-question', 'fa-question-circle', 'fa-quote-left', 'fa-quote-right', 'fa-ra', 'fa-random', 'fa-rebel', 'fa-recycle', 'fa-reddit', 'fa-reddit-square', 'fa-refresh', 'fa-remove', 'fa-renren', 'fa-reorder', 'fa-repeat', 'fa-reply', 'fa-reply-all', 'fa-retweet', 'fa-rmb', 'fa-road', 'fa-rocket', 'fa-rotate-left', 'fa-rotate-right', 'fa-rouble', 'fa-rss', 'fa-rss-square', 'fa-rub', 'fa-ruble', 'fa-rupee', 'fa-save', 'fa-scissors', 'fa-search', 'fa-search-minus', 'fa-search-plus', 'fa-send', 'fa-send-o', 'fa-share', 'fa-share-alt', 'fa-share-alt-square', 'fa-share-square', 'fa-share-square-o', 'fa-shekel', 'fa-sheqel', 'fa-shield', 'fa-shopping-cart', 'fa-sign-in', 'fa-sign-out', 'fa-signal', 'fa-sitemap', 'fa-skype', 'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile-o', 'fa-soccer-ball-o', 'fa-sort', 'fa-sort-alpha-asc', 'fa-sort-alpha-desc', 'fa-sort-amount-asc', 'fa-sort-amount-desc', 'fa-sort-asc', 'fa-sort-desc', 'fa-sort-down', 'fa-sort-numeric-asc', 'fa-sort-numeric-desc', 'fa-sort-up', 'fa-soundcloud', 'fa-space-shuttle', 'fa-spinner', 'fa-spoon', 'fa-spotify', 'fa-square', 'fa-square-o', 'fa-stack-exchange', 'fa-stack-overflow', 'fa-star', 'fa-star-half', 'fa-star-half-empty', 'fa-star-half-full', 'fa-star-half-o', 'fa-star-o', 'fa-steam', 'fa-steam-square', 'fa-step-backward', 'fa-step-forward', 'fa-stethoscope', 'fa-stop', 'fa-strikethrough', 'fa-stumbleupon', 'fa-stumbleupon-circle', 'fa-subscript', 'fa-suitcase', 'fa-sun-o', 'fa-superscript', 'fa-support', 'fa-table', 'fa-tablet', 'fa-tachometer', 'fa-tag', 'fa-tags', 'fa-tasks', 'fa-taxi', 'fa-tencent-weibo', 'fa-terminal', 'fa-text-height', 'fa-text-width', 'fa-th', 'fa-th-large', 'fa-th-list', 'fa-thumb-tack', 'fa-thumbs-down', 'fa-thumbs-o-down', 'fa-thumbs-o-up', 'fa-thumbs-up', 'fa-ticket', 'fa-times', 'fa-times-circle', 'fa-times-circle-o', 'fa-tint', 'fa-toggle-down', 'fa-toggle-left', 'fa-toggle-off', 'fa-toggle-on', 'fa-toggle-right', 'fa-toggle-up', 'fa-trash', 'fa-trash-o', 'fa-tree', 'fa-trello', 'fa-trophy', 'fa-truck', 'fa-try', 'fa-tty', 'fa-tumblr', 'fa-tumblr-square', 'fa-turkish-lira', 'fa-twitch', 'fa-twitter', 'fa-twitter-square', 'fa-umbrella', 'fa-underline', 'fa-undo', 'fa-university', 'fa-unlink', 'fa-unlock', 'fa-unlock-alt', 'fa-unsorted', 'fa-upload', 'fa-usd', 'fa-user', 'fa-user-md', 'fa-users', 'fa-video-camera', 'fa-vimeo-square', 'fa-vine', 'fa-vk', 'fa-volume-down', 'fa-volume-off', 'fa-volume-up', 'fa-warning', 'fa-wechat', 'fa-weibo', 'fa-weixin', 'fa-wheelchair', 'fa-wifi', 'fa-windows', 'fa-won', 'fa-wordpress', 'fa-wrench', 'fa-xing', 'fa-xing-square', 'fa-yahoo', 'fa-yelp', 'fa-yen', 'fa-youtube', 'fa-youtube-play', 'fa-youtube-square',);
	}

	/**
	 * Add new params or add new shortcode to VC
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function map_shortcodes() {
		// Add attribues to vc_row
		vc_remove_param( 'vc_row', 'video_bg' );
		vc_remove_param( 'vc_row', 'video_bg_url' );
		$attributes = array(
			array(
				'type'        => 'textfield',
				'heading'     => 'ID',
				'param_name'  => 'css_id',
				'value'       => '',
				'description' => __( 'Set CSS id for this row', 'onehost' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Full width content', '' ),
				'param_name'  => 'full_content',
				'value'       => array( __( 'Enable', 'onehost' ) => 'yes' ),
				'description' => __( 'Select it if you want your content to be displayed in full width of page', 'onehost' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Enable Parallax effect', 'onehost' ),
				'param_name'  => 'parallax',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => array( __( 'Enable', 'onehost' ) => 'yes' ),
				'description' => __( 'Enable this option if you want to have parallax effect on this row. When you enable this option, please set background repeat option as "Theme defaults" to make it works.', 'onehost' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => __( 'Overlay', 'onehost' ),
				'param_name'  => 'overlay',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => '',
				'description' => __( 'Select an overlay color for this row', 'onehost' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Particleground animated', 'onehost' ),
				'param_name'  => 'particleground_bg',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => array( __( 'Show', 'onehost' ) => 'true' ),
				'description' => __( 'Show particleground animated', 'onehost' ),

			),
			array(
				'type'        => 'colorpicker',
				'heading'     => __( 'Dot Color', 'onehost' ),
				'param_name'  => 'dot_color',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => '',
				'description' => __( 'Select an dot color for particleground', 'onehost' ),
				'dependency'  => array( 'element' => 'particleground_bg', 'value' => 'true' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => __( 'Line Color', 'onehost' ),
				'param_name'  => 'line_color',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => '',
				'description' => __( 'Select an line color for particleground', 'onehost' ),
				'dependency'  => array( 'element' => 'particleground_bg', 'value' => 'true' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Youtube Video Background', 'onehost' ),
				'param_name'  => 'yt_video_bg',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => array( __( 'Show', 'onehost' ) => 'true' ),
				'description' => __( 'Show Youtube Video Background', 'onehost' ),

			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Youtube URL', 'onehost' ),
				'param_name'  => 'video_bg',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => '',
				'description' => __( 'Enter an valid Youtube URL for video background. For better performance, this option does not work on mobile.', 'onehost' ),
				'dependency'  => array( 'element' => 'yt_video_bg', 'value' => 'true' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Mute Youtube Video', 'onehost' ),
				'param_name'  => 'mute_video',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => array( __( 'Mute', 'onehost' ) => 'yes' ),
				'dependency'  => array( 'element' => 'yt_video_bg', 'value' => 'true' ),
				'description' => __( 'Enable this option if you want to mute video by default.', 'onehost' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Show Sound Toggle Icon', 'onehost' ),
				'param_name'  => 'show_sound_toggle',
				'group'       => __( 'Design Options', 'onehost' ),
				'value'       => array( __( 'Show', 'onehost' ) => 'yes' ),
				'dependency'  => array( 'element' => 'yt_video_bg', 'value' => 'true' ),
				'description' => __( 'Enable this option if you want to show a sound toggle icon at the bottom of this row.', 'onehost' ),
			),
		);

		vc_add_params( 'vc_row', $attributes );
		vc_remove_param( 'vc_row', 'full_width' );
		vc_remove_param( 'vc_row', 'parallax_image' );
        vc_remove_param( 'vc_row', 'video_bg_parallax' );
		vc_remove_param( 'vc_row', 'full_height' );
		vc_remove_param( 'vc_row', 'content_placement' );
		vc_remove_param( 'vc_row', 'el_id' );

		// Add section title shortcode
		vc_map( array(
			'name'     => __( 'Section Title', 'onehost' ),
			'base'     => 'section_title',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'admin_enqueue_css' => THEME_URL . '/css/vc/icon-field.css',
			'params'   => array(
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Title', 'onehost' ),
					'param_name'  => 'content',
					'value'       => '',
					'description' => __( 'Enter the title content', 'onehost' ),
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'heading'     => __( 'Text Color', 'onehost' ),
					'param_name'  => 'color',
					'value'       => '',
					'description' => __( 'Set text color for this section title. Leave empty to use the default color of theme.', 'onehost' ),
				),

				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Text Alignment', 'onehost' ),
					'param_name'  => 'text_align',
					'value'       => array(
						__( 'Align Center', 'onehost' ) => 'align-center',
						__( 'Align Left', 'onehost' )   => 'align-left',
						__( 'Align Right', 'onehost' )  => 'align-right',
					),
					'description' => __( 'Select text alignment for this section title.', 'onehost' ),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Style', 'onehost' ),
					'param_name'  => 'style',
					'value'       => array(
						__( 'Default', 'onehost' ) => '',
						__( 'Border', 'onehost' )  => 's-border',
					),
					'description' => __( 'Select style for this section title.', 'onehost' ),
				),
				array(
					'type'        => 'textarea',
					'holder'      => 'div',
					'heading'     => __( 'Description', 'onehost' ),
					'param_name'  => 'desc',
					'value'       => '',
					'description' => __( 'Enter a short description for section', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Extra class name', 'onehost' ),
					'param_name'  => 'class_name',
					'value'       => '',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'onehost' ),
				),
			),
		) );

		// Add section title shortcode
		vc_map( array(
			'name'     => __( 'Section Title 2', 'onehost' ),
			'base'     => 'section_title_2',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'admin_enqueue_css' => THEME_URL . '/css/vc/icon-field.css',
			'params'   => array(
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Title', 'onehost' ),
					'param_name'  => 'title',
					'value'       => '',
					'description' => __( 'Enter the title content', 'onehost' ),
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'heading'     => __( 'Text Color', 'onehost' ),
					'param_name'  => 'color',
					'value'       => '',
					'description' => __( 'Set text color for this section title. Leave empty to use the default color of theme.', 'onehost' ),
				),

				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Text Alignment', 'onehost' ),
					'param_name'  => 'text_align',
					'value'       => array(
						__( 'Align Center', 'onehost' ) => 'align-center',
						__( 'Align Left', 'onehost' )   => 'align-left',
						__( 'Align Right', 'onehost' )  => 'align-right',
					),
					'description' => __( 'Select text alignment for this section title.', 'onehost' ),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Style', 'onehost' ),
					'param_name'  => 'style',
					'value'       => array(
						__( 'Default', 'onehost' ) => '',
						__( 'Border', 'onehost' )  => 's-border',
					),
					'description' => __( 'Select style for this section title.', 'onehost' ),
				),
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'heading'     => __( 'Description', 'onehost' ),
					'param_name'  => 'content',
					'value'       => '',
					'description' => __( 'Enter a short description for section', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Extra class name', 'onehost' ),
					'param_name'  => 'class_name',
					'value'       => '',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'onehost' ),
				),
			),
		) );

		// Add Icon Box shortcode
		vc_map( array(
			'name'     => __( 'Icon Box', 'onehost' ),
			'base'     => 'icon_box',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'params'   => array(
				array(
					'type'        => 'icon',
					'holder'      => 'div',
					'heading'     => __( 'Icon', 'onehost' ),
					'param_name'  => 'icon',
					'value'       => '',
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Icon Position', 'onehost' ),
					'param_name'  => 'icon_position',
					'value'       => array(
						__( 'Top', 'onehost' )      => 'top',
						__( 'Left', 'onehost' )     => 'left',
						__( 'Right', 'onehost' )    => 'right',
					),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Border Circle Icon', 'onehost' ),
					'param_name'  => 'border_circle',
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'heading'     => __( 'Background Color', 'onehost' ),
					'param_name'  => 'bg_color',
					'value'       => '',
					'description' => __( 'Set background color for this icon box.', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Title', 'onehost' ),
					'param_name'  => 'title',
					'value'       => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Link', 'onehost' ),
					'param_name'  => 'link',
					'value'       => '',
					'description' => __( 'Enter URL if you want this title to have a link.', 'onehost' ),
				),
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'heading'     => __( 'Content', 'onehost' ),
					'param_name'  => 'content',
					'value'       => '',
					'description' => __( 'Enter the content of this box', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Extra class name', 'onehost' ),
					'param_name'  => 'icon_class',
					'value'       => '',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'onehost' ),
				)
			),
		) );

		// Add Image Box shortcode
		vc_map( array(
			'name'     => __( 'Image Box', 'onehost' ),
			'base'     => 'image_box',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'params'   => array(
				array(
					'type'        => 'attach_image',
					'holder'      => 'div',
					'heading'     => __( 'Image', 'onehost' ),
					'param_name'  => 'image',
					'value'       => '',
					'description' => __( 'Select images from media library', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Image size', 'onehost' ),
					'param_name'  => 'image_size',
					'description' => __( 'Enter image size. Example: tiny, thumbnail, medium, large, full. Leave empty to use "thumbnail" size.', 'onehost' ),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Image Style', 'onehost' ),
					'param_name'  => 'image_style',
					'value'       => array(
						__( 'Default', 'onehost' ) => '',
						__( 'Rounded', 'onehost' ) => 'rounded',
						__( 'Circle', 'onehost' )  => 'circle',
					),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Image Position', 'onehost' ),
					'param_name'  => 'image_position',
					'value'       => array(
						__( 'Top', 'onehost' )      => 'top',
						__( 'Left', 'onehost' )     => 'left',
						__( 'Right', 'onehost' )    => 'right',
					),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Title', 'onehost' ),
					'param_name'  => 'title',
					'value'       => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Link', 'onehost' ),
					'param_name'  => 'link',
					'value'       => '',
					'description' => __( 'Enter URL if you want this title to have a link.', 'onehost' ),
				),
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'heading'     => __( 'Content', 'onehost' ),
					'param_name'  => 'content',
					'value'       => '',
					'description' => __( 'Enter the content of this box', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Extra class name', 'onehost' ),
					'param_name'  => 'icon_class',
					'value'       => '',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'onehost' ),
				)
			),
		) );


		// Add testimonial shortcode
		vc_map( array(
			'name'     => __( 'Testimonials', 'onehost' ),
			'base'     => 'testimonial',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'params'   => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Style', 'onehost' ),
					'param_name'  => 'style',
					'value'       => array(
						__( 'Short Info', 'onehost' )  => 'short',
						__( 'Medium Info', 'onehost' ) => 'medium',
						__( 'Full Info', 'onehost' )   => 'full',
					),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Number Of Testimonials', 'onehost' ),
					'param_name'  => 'number',
					'value'       => 'All',
					'description' => __( 'How many testimonials to show? Enter number or word "All".', 'onehost' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Enable Slider', 'onehost' ),
					'param_name'  => 'slider',
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Single Item', 'onehost' ),
					'param_name'  => 'single',
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
					'dependency'  => array( 'element' => 'slider', 'value' => 'true' ),
					'description' => __( 'Display only one item.', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Slide Show Speed', 'onehost' ),
					'param_name'  => 'speed',
					'value'       => '700',
					'dependency'  => array( 'element' => 'slider', 'value' => 'true' ),
					'description' => __( 'Set the speed of the slideshow cycling(in ms).', 'onehost' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Auto Play', 'onehost' ),
					'param_name'  => 'autoplay',
					'dependency'  => array( 'element' => 'slider', 'value' => 'true' ),
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Show navigation control', 'onehost' ),
					'param_name'  => 'navigation',
					'dependency'  => array( 'element' => 'slider', 'value' => 'true' ),
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Show pagination control', 'onehost' ),
					'param_name'  => 'pagination',
					'dependency'  => array( 'element' => 'slider', 'value' => 'true' ),
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Extra class name', 'onehost' ),
					'param_name'  => 'class_name',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'onehost' ),
				),
			),
		) );

		// Add images carousel shortcode
		vc_map( array(
			'name'     => __( 'OneHost Images Carousel', 'onehost' ),
			'base'     => 'images_carousel',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'params'   => array(
				array(
					'type'        => 'attach_images',
					'holder'      => 'div',
					'heading'     => __( 'Images', 'onehost' ),
					'param_name'  => 'images',
					'value'       => '',
					'description' => __( 'Select images from media library', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Image size', 'onehost' ),
					'param_name'  => 'image_size',
					'description' => __( 'Enter image size. Example: thumbnail, medium, large, full. Leave empty to use "thumbnail" size.', 'onehost' ),
				),
				array(
					'type'        => 'textarea',
					'holder'      => 'div',
					'heading'     => __( 'Custom links', 'onehost' ),
					'param_name'  => 'custom_links',
					'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter).', 'onehost' ),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'heading'     => __( 'Custom link target', 'onehost' ),
					'param_name'  => 'custom_links_target',
					'value'       => array(
						__( 'Same window', 'onehost' ) => '_self',
						__( 'New window', 'onehost' )  => '_blank',
					),
					'description' => __( 'Select where to open custom links.', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Slides per view', 'onehost' ),
					'param_name'  => 'number',
					'value'       => 4,
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Slider speed', 'onehost' ),
					'param_name'  => 'speed',
					'description' => __( 'Duration of animation between slides (in ms).', 'onehost' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Slider autoplay', 'onehost' ),
					'param_name'  => 'autoplay',
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Show navigation control', 'onehost' ),
					'param_name'  => 'navigation',
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Extra class name', 'onehost' ),
					'param_name'  => 'class_name',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'onehost' ),
				),
			),
		) );

		// Add pricing shortcode
		vc_map( array(
			'name'     => __( 'Pricing Table', 'onehost' ),
			'base'     => 'pricing',
			'class'    => '',
			'category' => __( 'Content', 'onehost' ),
			'params'   => array(
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Title', 'onehost' ),
					'param_name'  => 'title',
					'value'       => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Price', 'onehost' ),
					'param_name'  => 'price',
					'value'       => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Time Duration', 'onehost' ),
					'param_name'  => 'time_duration',
					'value'       => '',
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'heading'     => __( 'Featured', 'onehost' ),
					'param_name'  => 'featured',
					'value'       => array( __( 'Yes', 'onehost' ) => 'true' ),
				),
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'heading'     => __( 'Description', 'onehost' ),
					'param_name'  => 'content',
					'value'       => '',
					'description' => __( 'Enter a short description', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Button text', 'onehost' ),
					'param_name'  => 'btext',
					'value'       => __( 'Buy Now', 'onehost' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => __( 'Button URL', 'onehost' ),
					'param_name'  => 'burl',
					'value'       => '',
				),
			),
		) );

		// Add Animation
		$attributes = array(
			array(
				'type'        => 'dropdown',
				'holder'      => 'div',
				'heading'     => __( 'Animation', 'onehost' ),
				'param_name'  => 'animation',
				'group'       => __( 'Animation', 'onehost' ),
				'description' => __( 'Select an animation for this column. You can see more about animation <a href="http://daneden.github.io/animate.css" target="_blank">here</a>', 'onehost' ),
				'value'       => onehost_list_animation(),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => __( 'Duration', 'onehost' ),
				'param_name'  => 'duration',
				'group'       => __( 'Animation', 'onehost' ),
				'value'       => '1000',
				'description' => __( 'Duration of animation (in ms).', 'onehost' ),

			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => __( 'Delay', 'onehost' ),
				'group'       => __( 'Animation', 'onehost' ),
				'param_name'  => 'delay',
				'value'       => '200',
				'description' => __( 'Delay of animation (in ms).', 'onehost' ),

			),
		);

		$elements = array(
			'vc_column',
			'vc_column_inner',
			'vc_custom_heading',
			'vc_button2',
			'vc_button',
			'vc_progress_bar',
			'vc_gallery',
			'vc_single_image',
			'vc_column_text',
			'section_title',
			'section_title_2',
			'icon_box',
			'image_box',
			'testimonial',
			'images_carousel'
		);
		foreach ( $elements as $element ) {
			vc_add_params( $element, $attributes );
		}
	}

	/**
	 * Return setting UI for icon param type
	 *
	 * @param  array $settings
	 * @param  string $value
	 *
	 * @return string
	 */
	function icon_param( $settings, $value ) {
		// Generate dependencies if there are any
		$dependency = vc_generate_dependencies_attributes( $settings );
		$icons = array();
		foreach( $this->icons as $icon ) {
			$icons[] = sprintf(
				'<i data-icon="fa %1$s" class="fa %1$s %2$s"></i>',
				$icon,
				$icon == $value ? 'selected' : ''
			);
		}

		return sprintf(
			'<div class="icon_block">
				<span class="icon-preview"><i class="fa %s"></i></span>
				<input type="text" class="icon-search" placeholder="%s">
				<input type="hidden" name="%s" value="%s" class="wpb_vc_param_value wpb-textinput %s %s_field" %s>
				<div class="icon-selector">%s</div>
			</div>',
			esc_attr( $value ),
			__( 'Quick Search', 'onehost' ),
			esc_attr( $settings['param_name'] ),
			esc_attr( $value ),
			esc_attr( $settings['param_name'] ),
			esc_attr( $settings['type'] ),
			$dependency,
			implode( '', $icons )
		);
	}
}

// Define classes for Icon box tabs shortcode
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Icon_Box_Tabs extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Icon_Box_Tab extends WPBakeryShortCode {
	}
}

/**
 * Get List Animation
 *
 * @since  1.0
 *
 * @return string
 */
function onehost_list_animation() {
    $icons = array(
        __( 'No Animation', 'onehost' )       => '',
        __( 'Bounce', 'onehost' )             => 'bounce',
        __( 'Flash', 'onehost' )              => 'flash',
        __( 'Pulse', 'onehost' )              => 'pulse',
        __( 'Rubberband', 'onehost' )         => 'rubberBand',
        __( 'Shake', 'onehost' )              => 'shake',
        __( 'Swing', 'onehost' )              => 'swing',
        __( 'Tada', 'onehost' )               => 'tada',
        __( 'Wobble', 'onehost' )             => 'wobble',
        __( 'Bouncein', 'onehost' )           => 'bounceIn',
        __( 'Bounceindown', 'onehost' )       => 'bounceInDown',
        __( 'Bounceinleft', 'onehost' )       => 'bounceInLeft',
        __( 'Bounceinright', 'onehost' )      => 'bounceInRight',
        __( 'Bounceinup', 'onehost' )         => 'bounceInUp',
        __( 'Bounceout', 'onehost' )          => 'bounceOut',
        __( 'Bounceoutdown', 'onehost' )      => 'bounceOutDown',
        __( 'Bounceoutleft', 'onehost' )      => 'bounceOutLeft',
        __( 'Bounceoutright', 'onehost' )     => 'bounceOutRight',
        __( 'Bounceoutup', 'onehost' )        => 'bounceOutUp',
        __( 'Fadein', 'onehost' )             => 'fadeIn',
        __( 'Fadeindown', 'onehost' )         => 'fadeInDown',
        __( 'Fadeindownbig', 'onehost' )      => 'fadeInDownBig',
        __( 'Fadeinleft', 'onehost' )         => 'fadeInLeft',
        __( 'Fadeinleftbig', 'onehost' )      => 'fadeInLeftBig',
        __( 'Fadeinright', 'onehost' )        => 'fadeInRight',
        __( 'Fadeinrightbig', 'onehost' )     => 'fadeInRightBig',
        __( 'Fadeinup', 'onehost' )           => 'fadeInUp',
        __( 'Fadeinupbig', 'onehost' )        => 'fadeInUpBig',
        __( 'Fadeout', 'onehost' )            => 'fadeOut',
        __( 'Fadeoutdown', 'onehost' )        => 'fadeOutDown',
        __( 'Fadeoutdownbig', 'onehost' )     => 'fadeOutDownBig',
        __( 'Fadeoutleft', 'onehost' )        => 'fadeOutLeft',
        __( 'Fadeoutleftbig', 'onehost' )     => 'fadeOutLeftBig',
        __( 'Fadeoutright', 'onehost' )       => 'fadeOutRight',
        __( 'Fadeoutrightbig', 'onehost' )    => 'fadeOutRightBig',
        __( 'Fadeoutup', 'onehost' )          => 'fadeOutUp',
        __( 'Fadeoutupbig', 'onehost' )       => 'fadeOutUpBig',
        __( 'Flip', 'onehost' )               => 'flip',
        __( 'Flipinx', 'onehost' )            => 'flipInX',
        __( 'Flipiny', 'onehost' )            => 'flipInY',
        __( 'Flipoutx', 'onehost' )           => 'flipOutX',
        __( 'Flipouty', 'onehost' )           => 'flipOutY',
        __( 'Lightspeedin', 'onehost' )       => 'lightSpeedIn',
        __( 'Lightspeedout', 'onehost' )      => 'lightSpeedOut',
        __( 'Rotatein', 'onehost' )           => 'rotateIn',
        __( 'Rotateindownleft', 'onehost' )   => 'rotateInDownLeft',
        __( 'Rotateindownright', 'onehost' )  => 'rotateInDownRight',
        __( 'Rotateinupleft', 'onehost' )     => 'rotateInUpLeft',
        __( 'Rotateinupright', 'onehost' )    => 'rotateInUpRight',
        __( 'Rotateout', 'onehost' )          => 'rotateOut',
        __( 'Rotateoutdownleft', 'onehost' )  => 'rotateOutDownLeft',
        __( 'Rotateoutdownright', 'onehost' ) => 'rotateOutDownRight',
        __( 'Rotateoutupleft', 'onehost' )    => 'rotateOutUpLeft',
        __( 'Rotateoutupright', 'onehost' )   => 'rotateOutUpRight',
        __( 'Hinge', 'onehost' )              => 'hinge',
        __( 'Rollin', 'onehost' )             => 'rollIn',
        __( 'Rollout', 'onehost' )            => 'rollOut',
        __( 'Zoomin', 'onehost' )             => 'zoomIn',
        __( 'Zoomindown', 'onehost' )         => 'zoomInDown',
        __( 'Zoominleft', 'onehost' )         => 'zoomInLeft',
        __( 'Zoominright', 'onehost' )        => 'zoomInRight',
        __( 'Zoominup', 'onehost' )           => 'zoomInUp',
        __( 'Zoomout', 'onehost' )            => 'zoomOut',
        __( 'Zoomoutdown', 'onehost' )        => 'zoomOutDown',
        __( 'Zoomoutleft', 'onehost' )        => 'zoomOutLeft',
        __( 'Zoomoutright', 'onehost' )       => 'zoomOutRight',
        __( 'Zoomoutup', 'onehost' )          => 'zoomOutUp',
    );
    return $icons;
}
