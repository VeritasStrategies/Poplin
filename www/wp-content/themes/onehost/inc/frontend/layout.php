<?php
/**
 * Hooks for frontend display
 *
 * @package OneHost
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 * @param array $classes Classes for the body element.
 * @return array
 */
function onehost_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add a class of layout
	$classes[] = onehost_get_layout();

	// Add a class when choose no animation
	if ( onehost_theme_option( 'no_animation' ) ) {
		$classes[] = 'no-animation';
	}

	// Add a class when choose no animation
	$classes[] = onehost_theme_option( 'site_style' ) . '-version';

	// Add a class for color scheme
	if ( onehost_theme_option( 'custom_color_scheme' ) && onehost_theme_option( 'custom_color_1' ) ) {
		$classes[] = 'custom-color-scheme';
	} else {
		$classes[] = onehost_theme_option( 'color_scheme' );
	}

	if(  onehost_get_meta( 'hide_singular_title' ) ) {
		$classes[] = 'hide-singular-title';
	}

	return $classes;
}
add_filter( 'body_class', 'onehost_body_classes' );
