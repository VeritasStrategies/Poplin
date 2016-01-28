<?php

$output = $text = $google_fonts = $font_container = $el_class = $css = $google_fonts_data = $font_container_data =  $animation = $duration = $delay = '';
extract( $this->getAttributes( $atts ) );
extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );
$settings = get_option( 'wpb_js_google_fonts_subsets' );
$subsets  = '';
if ( is_array( $settings ) && ! empty( $settings ) ) {
	$subsets = '&subset=' . implode( ',', $settings );
}
wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );

extract( shortcode_atts( array(
    'animation'  => '',
    'duration'   => '',
    'delay'      => '',
    'text_align' => '',
), $atts ) );

$data_animation = '';
if( $animation ) {
    $css_class .= ' wow ' . $animation;

    if( $duration ) {
        $data_animation .= ' data-wow-duration="' . $duration . 'ms"';
    }
    if( $delay ) {
        $data_animation .= ' data-wow-delay="' . $delay . 'ms"';
    }
}




$output .= '<div class="' . $css_class . $text_align . '"' . $data_animation . ' >';
$output .= '<' . $font_container_data['values']['tag'] . ' style="' . implode( ';', $styles ) . '">';
$output .= $text;
$output .= '</' . $font_container_data['values']['tag'] . '>';
$output .= '</div>';

echo $output;