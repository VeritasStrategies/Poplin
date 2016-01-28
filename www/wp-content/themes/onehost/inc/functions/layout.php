<?php
/**
 * Custom functions for layout.
 *
 * @package OneHost
 */

/**
 * Get layout base on current page
 *
 * @return string
 */
function onehost_get_layout() {
	$layout        = onehost_theme_option( 'default_layout' );
	$custom_layout = onehost_get_meta( 'layout' );

	if ( is_page() ) {
		if ( onehost_get_meta( 'custom_layout' ) && $custom_layout ) {
			$layout = $custom_layout;
		} else {
			$layout = onehost_theme_option( 'page_layout' );
		}
	} elseif ( is_singular( 'post' ) ) {
		if ( onehost_get_meta( 'custom_layout' ) && $custom_layout ) {
			$layout = $custom_layout;
		} else {
			$layout = onehost_theme_option( 'single_layout' );
		}
	} elseif ( is_404() ) {
		$layout = 'full-content';
	}

	return $layout;
}

/**
 * Get Bootstrap column classes for content area
 *
 * @since  1.0
 *
 * @return array Array of classes
 */
function onehost_get_content_columns( $layout = null ) {
	$layout = $layout ? $layout : onehost_get_layout();
	if ( 'full-content' == $layout ) {
		return array( 'col-md-12' );
	}

	return array( 'col-md-8', 'col-sm-8', 'col-xs-12' );
}

/**
 * Echos Bootstrap column classes for content area
 *
 * @since 1.0
 */
function onehost_content_columns( $layout = null ) {
	echo implode( ' ', onehost_get_content_columns( $layout ) );
}
