<?php
/**
 * Portfolio shortcodes
 *
 * @package TA Portfolio Management
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode function to display portfolio
 *
 * @since  1.0.0
 *
 * @param  array $atts
 *
 * @return string
 */
function ta_portfolio_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'layout'   => 'masonry',
			'cats'     => '',
			'field'    => 'slug',
			'limit'    => 8,
			'filter'   => 'yes',
			'paginate' => 'yes',
			'gutter'   => 0,
		),
		$atts
	);

	// Allow themes or other plugins change content
	$html = apply_filters( 'ta_portfolio_showcase', '', $atts );

	if ( ! empty( $html ) ) {
		return $html;
	}

	$args = array(
		'post_type'      => 'portfolio_project',
		'posts_per_page' => intval( $atts['limit'] ),
		'paged'          => max( 1, get_query_var( 'paged' ) ),
	);

	if ( ! empty( $atts['cats'] ) ) {
		$cats              = is_string( $atts['cats'] ) ? explode( ',', trim( $atts['cats'] ) ) : $atts['cats'];
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'portfolio_category',
				'field'    => $atts['field'],
				'terms'    => $cats,
			)
		);
	}

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return '';
	}

	/*
	 * Filter
	 */
	$filter = '';
	if ( 'yes' == $atts['filter'] ) {
		if ( empty( $cats ) ) {
			$cats = get_terms( 'portfolio_category' );
		}

		$filter .= '<div id="' . uniqid( 'portfolio-filter-' ) . '" class="portfolio-filter clearfix">';

		$filter .= sprintf(
			'<a href="#" data-filter="*" title="%s" class="active">%s</a>',
			__( 'View all items', 'ta-portfolio' ),
			__( 'All', 'ta-portfolio' )
		);

		foreach ( $cats as $cat ) {
			if ( is_string( $cat ) ) {
				$type = 'slug' == $atts['field'] ? 'slug' : 'id';
				$cat  = get_term_by( $type, $cat, 'portfolio_category' );
			}

			$filter .= sprintf(
				'<a href="#" data-filter=".%s" title="%s">%s</a>',
				$cat->slug,
				__( 'View all items under', 'ta-portfolio' ) . ' ' . $cat->name,
				$cat->name
			);
		}

		$filter .= '</div>';
	}

	/*
	 * Works
	 */
	$works = '';
	$tag   = current_theme_supports( 'html5' ) ? 'article' : 'div';
	if ( in_array( $atts['layout'], array( 'metro', 'masonry' ) ) ) {
		$works .= '<div class="portfolio-sizer"></div>';
	}

	while ( $query->have_posts() ) : $query->the_post();
		// Allow theme themes and plugins create portfolio item in another markup
		if ( $item = apply_filters( 'ta_portfolio_item_content', '', $atts, $query->current_post, $tag ) ) {
			$works .= $item;
		} else {
			// Allow filters by themes and other plugins
			// We use it as well: ta_portfolio_item_classes
			$classes    = apply_filters( 'ta_portfolio_item_class', array(), $atts, $query->current_post, $query->post_count );
			$attrs      = apply_filters( 'ta_portfolio_item_attr', array(), $atts, $query->current_post, $query->post_count );
			$attributes = '';
			if ( ! empty( $attrs ) ) {
				foreach ( $attrs as $attr => $attr_val ) {
					$attributes .= ' ' . $attr . '="' . $attr_val . '"';
				}
			}

			list( $full ) = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

			$works .= '<' . $tag . ' class="' . implode( ' ', get_post_class( $classes ) ) . '" '. $attributes .'><div class="portfolio-detail">';
			$works .= get_the_post_thumbnail( get_the_ID(), apply_filters( 'ta_portfolio_item_thumnail_size', 'portfolio-thumbnail-normal', $atts, $query->current_post, $query->post_count ) );
			$works .= sprintf( '<h3><a href="%s">%s</a></h3>', get_permalink(), get_the_title() );
			$works .= sprintf( '<div class="portfolio-cats">%s</div>', get_the_term_list( get_the_ID(), 'portfolio_category', '', ', ' ) );
			$works .= sprintf( '<a href="%s" class="view-portfolio-image">%s</a>', $full, __( 'View Image', 'ta-portfolio' ) );
			$works .= sprintf( '<a href="%s" class="view-portfolio-detail">%s</a>', get_permalink(), __( 'View Detail', 'ta-portfolio' ) );
			$works .= "</div></$tag>";
		}
	endwhile;

	$works_class = array( 'portfolio-showcase', 'ta-portfolio-shortcode', 'portfolio-layout-' . $atts['layout'], 'clearfix' );
	$works_class = apply_filters( 'ta_portfolio_showcase_class', $works_class, $atts );
	$works       = sprintf(
		'<div id="%s" data-layout="%s" data-gutter="%d" class="%s">%s</div>',
		uniqid( 'portfolio-showcase-' ),
		$atts['layout'],
		$atts['gutter'],
		implode( ' ', $works_class ),
		$works
	);

	/*
	 * Paging
	 */
	$paging = '';
	if ( 'yes' == $atts['paginate'] && 1 < $query->max_num_pages ) {
		$big = 999999999;

		$paging = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $query->max_num_pages,
				'prev_text' => apply_filters( 'ta_portfolio_paging_prev_text', __( '« Previous', 'ta-portfolio' ), $atts ),
				'next_text' => apply_filters( 'ta_portfolio_paging_next_text', __( 'Next »', 'ta-portfolio' ), $atts ),
			)
		);

		$paging = '<div id="' . uniqid( 'portfolio-pagination-' ) . '" class="portfolio-pagination portfolio-pagination">' . $paging . '</div>';
	}

	wp_reset_postdata();

	return apply_filters( __FUNCTION__, $filter . $works . $paging, $atts, $filter, $works, $paging );
}

add_shortcode( 'ta_portfolio', 'ta_portfolio_shortcode' );

/**
 * Shortcode function to display portfolio showcase
 *
 * @since  1.0.0
 *
 * @param  array $atts
 *
 * @return string
 */
function ta_portfolio_showcase_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'id' => 0 ), $atts );

	$args = array(
		'layout'   => get_post_meta( $atts['id'], '_portfolio_showcase_layout', true ),
		'cats'     => get_post_meta( $atts['id'], '_portfolio_showcase_cat', true ),
		'field'    => 'term_id',
		'limit'    => get_post_meta( $atts['id'], '_portfolio_showcase_limit', true ),
		'filter'   => get_post_meta( $atts['id'], '_portfolio_showcase_filter', true ),
		'paginate' => get_post_meta( $atts['id'], '_portfolio_showcase_pagination', true ),
		'gutter'   => get_post_meta( $atts['id'], '_portfolio_showcase_gutter', true ),
	);

	return apply_filters( __FUNCTION__, ta_portfolio_shortcode( $args ), $atts, $args );
}

add_shortcode( 'ta_portfolio_showcase', 'ta_portfolio_showcase_shortcode' );
