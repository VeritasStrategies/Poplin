<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $css_id = $full_content = $parallax = $overlay = $video_bg = $yt_video_bg = $mute_video = $show_sound_toggle = $particleground_bg  = $dot_color = $line_color = '';
extract(shortcode_atts(array(
	'el_class'          => '',
	'bg_image'          => '',
	'bg_color'          => '',
	'bg_image_repeat'   => '',
	'font_color'        => '',
	'padding'           => '',
	'margin_bottom'     => '',
	'full_content'      => '',
	'parallax'          => '',
	'overlay'           => '',
	'video_bg'          => '',
	'yt_video_bg'       => '',
	'mute_video'        => '',
	'show_sound_toggle' => '',
	'particleground_bg' => '',
	'dot_color'         => '#666666',
	'line_color'        => '#666666',
	'css'               => '',
	'css_id'            => '',
), $atts));

// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$container = $full_content == 'yes' ? 'container-fluid' : 'container';
$css_id = $css_id ? 'id="' . $css_id . '" ' : '';

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$data_stellar = '';

if( $particleground_bg ) {
	$css_class .= ' particleground-animated';

	if ( $parallax ) {
		$css_class .= ' parallax';
	}
}
elseif ( $video_bg && $yt_video_bg )
	$css_class .= ' video-bg-enable';
elseif ( $parallax ) {
	$css_class .= ' parallax';
}

if ( $overlay )
	$css_class .= ' overlay-enable';

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$output .= '<section ' . $css_id . 'class="'.$css_class.'"'.$style.'>';
if( $particleground_bg ) {
	$output .= '<div class="particles" dot-color="' . $dot_color . '" line-color="' . $line_color . '">';
}
elseif ( $video_bg && $yt_video_bg && ! wp_is_mobile() ) {
	$mute = $mute_video ? 'mute' : 'unmute';
	parse_str( parse_url( $video_bg, PHP_URL_QUERY ), $video_args );
	$output .= '<div id="' . uniqid( 'ytvideo-bg-' ) . '" class="ytvideo-bg" data-video="' . $video_args['v'] . '" data-sound="' . $mute . '"></div>';
}
elseif ( $video_bg && $yt_video_bg && wp_is_mobile() ) {
	$mobile_bg = array();
	preg_match( '/background-image\s*:\s*url\(\s*([\'"]*)(?P<file>[^\1]+)\1\s*\)/i', $css, $matches );
	if ( $matches ) {
		$mobile_bg[] = $matches[0] . ';';
	}

	preg_match( '/background-color\s*:\s*([^\;]+)\s*\;/i', $css, $matches );
	if ( $matches ) {
		$mobile_bg[] = $matches[0];
	}

	preg_match( '/background-repeat\s*:\s*([^\;]+)\s*\;/i', $css, $matches );
	if ( $matches ) {
		$mobile_bg[] = $matches[0];
	}

	preg_match( '/background-size\s*:\s*([^\;]+)\s*\;/i', $css, $matches );
	if ( $matches ) {
		$mobile_bg[] = $matches[0];
	}

	$mobile_style = $mobile_bg ? ' style="' . implode( '', $mobile_bg ) .'"' : '';
	$output .= '<div class="mobile-video-bg"' . $mobile_style . '></div>';
}

if ( $overlay )
	$output .= '<div class="overlay" style="background-color:' . $overlay . '"></div>';
$output .= '<div class="' . $container . '">';
$output .= '<div class="row">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= '</div>';
if ( $show_sound_toggle ) {
	$icon = $mute_video ? 'fa-volume-off' : 'fa-volume-up';
	$output .= '<span class="toggle-sound"><i class="fa ' . $icon . '"></i></span>';
}
if( $particleground_bg ) {
	$output .= '</div>';
}
$output .= '</section>'.$this->endBlockComment('row');

echo $output;
