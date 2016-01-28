<?php
/**
 * Team shortcodes
 *
 * @package TA Team Management
 */

/**
 * Shortcode function to display team members
 *
 * @since  1.0.0
 *
 * @param  array $atts
 *
 * @return string
 */
function ta_team_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'grid'         => 4,
			'style'        => 'round', // default | round | square
			'align'        => 'center',
			'group'        => '',
			'number'       => 4,
			'field'        => 'slug', // slug | term_id
			'order_by'     => '',
			'order'        => 'desc',
			'show_name'     => 'yes',
			'show_job'     => 'yes',
			'show_bio'     => 'yes',
			'show_socials' => 'no',
			'show_address' => 'no',
			'show_phone'   => 'no',
			'bio'          => 'excerpt', // content | excerpt
			'hover'        => 'socials', // none | socials | button | info
		),
		$atts
	);

	// Allow themes or other plugins change content
	$html = apply_filters( 'ta_team_showcase', '', $atts );

	if ( ! empty( $html ) ) {
		return $html;
	}

	$args = array(
		'post_type'      => 'team_member',
		'posts_per_page' => intval( $atts['number'] ),
		'order'          => $atts['order'],
	);

	if ( ! empty( $atts['group'] ) ) {
		$group             = is_string( $atts['group'] ) ? explode( ',', trim( $atts['group'] ) ) : $atts['group'];
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'team_group',
				'field'    => $atts['field'],
				'terms'    => $group,
			)
		);
	}

	if ( $atts['order_by'] ) {
		$args['orderby'] = $atts['order_by'];
	}

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return '';
	}

	while ( $query->have_posts() ) : $query->the_post();
		$info = array();

		$info['image'] = get_the_post_thumbnail( get_the_ID(), apply_filters( 'ta_team_image_size', 'team-member', $atts ) );

		if ( 'yes' == $atts['show_name'] ) {
			$info['name'] = '<h3 class="team-member-name">' . get_the_title() . '</h3>';
		}

		if ( 'yes' == $atts['show_job'] ) {
			$info['job'] = '<div class="team-member-job">' . get_post_meta( get_the_ID(), '_team_member_job', true ) . '</div>';
		}

		if ( 'yes' == $atts['show_bio'] ) {
			if ( 'excerpt' == $atts['bio'] ) {
				$info['bio'] = '<div class="team-member-bio">' . get_the_excerpt() . '</div>';
			} else {
				$info['bio'] = '<div class="team-member-bio">' . get_the_content() . '</div>';
			}
		}

		if ( 'yes' == $atts['show_address'] ) {
			$info['address'] = '<div class="team-member-address">' . get_post_meta( get_the_ID(), '_team_member_address', true ) . '</div>';
		}

		if ( 'yes' == $atts['show_phone'] ) {
			$info['phone'] = '<div class="team-member-phone">' . get_post_meta( get_the_ID(), '_team_member_phone', true ) . '</div>';
		}

		$socials      = get_post_meta( get_the_ID(), '_team_member_socials', true );
		$socials      = array_filter( $socials );
		$social_links = '';

		if ( $socials ) {
			$social_links = array();

			foreach( $socials as $social => $link ) {
				$title  = 'googleplus' == $social ? __( 'Google Plus', 'ta-team' ) : ucfirst( $social );
				$social = 'googleplus' == $social ? 'google-plus' : $social;
				$social = 'vimeo' == $social ? 'vimeo-square' : $social;

				$social_links[] = sprintf( '<a href="%s" class="fa fa-%s" title="%s" target="_blank"></a>', $link, $social, $title );
			}

			$social_links = '<div class="team-member-socials">' . implode( "\n", $social_links ) . '</div>';
		}

		if ( 'yes' == $atts['show_socials'] ) {
			$info['socials'] = $social_links;
		}

		switch ( $atts['hover'] ) {
			case 'socials':
				$info['image'] .= $social_links;
				break;

			case 'button':
				$info['image'] .= sprintf( '<a href="%s" class="view-member-detail"><i class="fa fa-plus"></i></a>', get_permalink() );
				break;

			case 'info':
				$info['image'] .= sprintf( '<a href="%s" class="view-member-detail"><i class="fa fa-plus"></i></a>', get_permalink() );
				$info['image'] .= sprintf(
					'<div class="team-member-info"><h3 class="team-member-name">%s</h3><div class="team-member-job">%s</div></div>',
					get_the_title(),
					get_post_meta( get_the_ID(), '_team_member_job', true )
				);
				break;

			case 'info_socials':
				$info['image'] .= sprintf(
					'<div class="team-member-info"><h3 class="team-member-name">%s</h3><div class="team-member-job">%s</div>%s</div>',
					get_the_title(),
					get_post_meta( get_the_ID(), '_team_member_job', true ),
					$social_links
				);
				break;
		}
		$info['image'] = '<div class="team-member-image">' . $info['image'] . '</div>';

		switch ( $atts['grid'] ) {
			case 1:
				$class = array( 'col-md-12' );
				break;

			case 2:
				$class = array( 'col-md-6', 'col-sm-6', 'col-xs-12' );
				break;

			case 3:
				$class = array( 'col-md-4', 'col-sm-12', 'col-xs-12' );
				break;

			default:
				$class = array( 'col-md-3', 'col-sm-6', 'col-xs-12' );
				break;
		}

		$class      = apply_filters( 'ta_team_shortcode_item_class', $class, $atts['grid'] );
		$attrs      = apply_filters( 'ta_team_shortcode_item_attr', array(), $atts, $query->current_post, $query->post_count );
		$attributes = '';
		if ( ! empty( $attrs ) ) {
			foreach ( $attrs as $attr => $attr_val ) {
				$attributes .= ' ' . $attr . '="' . $attr_val . '"';
			}
		}

		$info      = apply_filters( 'ta_team_shortcode_item_info', $info, $atts, $query->post->ID );

		$html .= sprintf(
			'<div  class="%s clearfix" %s>%s</div>',
			implode( ' ', get_post_class( $class ) ),
			$attributes,
			implode( "\n", $info )
		);
	endwhile;

	wp_reset_postdata();

	$html = sprintf(
		'<div class="ta-team-shortcode ta-team-grid-%s style-%s align-%s hover-%s"><div class="row">%s</div></div>',
		$atts['grid'],
		$atts['style'],
		$atts['align'],
		str_replace( '_', '-', $atts['hover'] ),
		$html
	);

	return apply_filters( __FUNCTION__, $html, $atts );
}

add_shortcode( 'ta_team', 'ta_team_shortcode' );

/**
 * Shortcode function to display team showcase
 *
 * @since  1.0.0
 *
 * @param  array $atts
 *
 * @return string
 */
function ta_team_showcase_shortcode( $atts ) {
	$atts    = shortcode_atts( array( 'id' => 0 ), $atts );
	$post_id = $atts['id'];

	$group   = get_post_meta( $post_id, '_team_showcase_group', true );
	$limit   = get_post_meta( $post_id, '_team_showcase_limit', true );
	$orderby = get_post_meta( $post_id, '_team_showcase_orderby', true );
	$order   = get_post_meta( $post_id, '_team_showcase_order', true );

	$grid    = get_post_meta( $post_id, '_team_showcase_grid', true );
	$style   = get_post_meta( $post_id, '_team_showcase_style', true );
	$align   = get_post_meta( $post_id, '_team_showcase_align', true );
	$display = get_post_meta( $post_id, '_team_showcase_display', true );

	$args    = array(
		'grid'     => $grid,
		'style'    => $style,
		'align'    => $align,
		'group'    => intval( $group ),
		'number'   => absint( $limit ),
		'field'    => 'term_id',
		'order_by' => $orderby,
		'order'    => $order,
	);

	switch ( $display ) {
		case 'mini':
			$args = array_merge(
				$args,
				array(
					'show_name'    => 'no',
					'show_job'     => 'no',
					'show_bio'     => 'no',
					'show_socials' => 'no',
					'show_address' => 'no',
					'show_phone'   => 'no',
					'hover'        => 'info',
				)
			);
			break;

		case 'short':
			$args = array_merge(
				$args,
				array(
					'show_name'    => 'yes',
					'show_job'     => 'yes',
					'show_bio'     => 'no',
					'show_socials' => 'no',
					'show_address' => 'no',
					'show_phone'   => 'no',
					'hover'        => 'socials',
				)
			);
			break;

		case 'medium':
			$args = array_merge(
				$args,
				array(
					'show_name'    => 'yes',
					'show_job'     => 'yes',
					'show_bio'     => 'yes',
					'show_socials' => 'no',
					'show_address' => 'no',
					'show_phone'   => 'no',
					'bio'          => 'excerpt',
					'hover'        => 'socials',
				)
			);
			break;

		case 'medium_socials':
			$args = array_merge(
				$args,
				array(
					'show_name'    => 'yes',
					'show_job'     => 'yes',
					'show_bio'     => 'yes',
					'show_socials' => 'yes',
					'show_address' => 'no',
					'show_phone'   => 'no',
					'bio'          => 'excerpt',
					'hover'        => 'none',
				)
			);
			break;

		case 'full':
			$args = array_merge(
				$args,
				array(
					'show_name'    => 'yes',
					'show_job'     => 'yes',
					'show_bio'     => 'yes',
					'show_socials' => 'yes',
					'show_address' => 'yes',
					'show_phone'   => 'yes',
					'bio'          => 'content',
					'hover'        => 'none',
				)
			);
			break;

		case 'custom':
			$args = array_merge(
				$args,
				array(
					'show_name'    => get_post_meta( $post_id, '_team_showcase_show_name', true ) ? 'yes' : 'no',
					'show_job'     => get_post_meta( $post_id, '_team_showcase_show_job', true ) ? 'yes' : 'no',
					'show_bio'     => get_post_meta( $post_id, '_team_showcase_show_bio', true ) ? 'yes' : 'no',
					'show_socials' => get_post_meta( $post_id, '_team_showcase_show_socials', true ) ? 'yes' : 'no',
					'show_address' => get_post_meta( $post_id, '_team_showcase_show_address', true ) ? 'yes' : 'no',
					'show_phone'   => get_post_meta( $post_id, '_team_showcase_show_phone', true ) ? 'yes' : 'no',
					'bio'          => get_post_meta( $post_id, '_team_showcase_bio_type', true ),
					'hover'        => get_post_meta( $post_id, '_team_showcase_hover', true ),
				)
			);
			break;
	}

	return apply_filters( __FUNCTION__, ta_team_shortcode( $args ), $atts, $args );
}

add_shortcode( 'ta_team_showcase', 'ta_team_showcase_shortcode' );
