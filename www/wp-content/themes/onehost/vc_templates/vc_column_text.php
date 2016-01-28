<?php
$output = $el_class = $css_animation = $animation = $duration = $delay = '';

extract(shortcode_atts(array(
    'el_class' => '',
    'css_animation' => '',
    'css' => '',
    'animation'  => '',
    'duration'   => '',
    'delay'      => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

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



$output .= "\n\t".'<div class="'.$css_class.'"' . $data_animation . '>';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content, true);
$output .= "\n\t\t".'</div> ' . $this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> ' . $this->endBlockComment('.wpb_text_column');

echo $output;