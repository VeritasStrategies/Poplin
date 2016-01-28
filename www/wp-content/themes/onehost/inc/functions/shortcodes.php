<?php
/**
 * Define theme shortcodes
 *
 * @package OneHost
 */
class OneHost_Shortcodes {

	/**
	 * Store variables for js
	 *
	 * @var array
	 */
	public $l10n = array();

	/**
	 * Store tabs for tabs shortcodes
	 * @var array
	 */
	private $tabs = array();

	/**
	 * Construction
	 *
	 * @return onehost_Shortcodes
	 */
	function __construct() {
		$shortcodes = array(
			'section_title',
			'section_title_2',
			'testimonial',
			'image_box',
			'icon_box',
			'pricing',
			'images_carousel'
		);

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, $shortcode ) );
		}
		add_action( 'wp_footer', array( $this, 'footer' ) );
	}

	/**
	 * Load custom js in footer
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function footer() {
		// Load Google maps only when needed
		if ( isset( $this->l10n['map'] ) ) {
			echo '<script>if ( typeof google !== "object" || typeof google.maps !== "object" )
				document.write(\'<script src="//maps.google.com/maps/api/js?sensor=false"><\/script>\')</script>';
		}
		wp_localize_script( 'onehost', 'onehostShortCode', $this->l10n );
	}

	/**
	 * Shortcode to display section title
	 *
	 * @param  array $atts
	 * @param  string $content
	 * @return string
	 */
	function section_title( $atts, $content ) {
		$atts = shortcode_atts(array(
			'color'      => '',
			'text_align' => 'align-center',
			'style'      => '',
			'desc'       => '',
			'class_name' => '',
			'animation'  => '',
			'duration'   => '',
			'delay'      => '',
		), $atts );

		$data_animation = '';
		$css_class[] = 'section-title clearfix';
		if( $atts['animation'] ) {
			$css_class[] = 'wow ' . esc_attr( $atts['animation'] );
			if( $atts['duration'] ) {
				$data_animation .= ' data-wow-duration="' . esc_attr( $atts['duration'] ) . 'ms"';
			}
			if( $atts['delay'] ) {
				$data_animation .= ' data-wow-delay="' . esc_attr( $atts['delay'] ) . 'ms"';
			}
		}

		$color = '';
		if( $atts['color'] ) {
			$color = 'style="color:' . esc_attr( $atts['color'] ) . '"' ;
		}

		$desc = '';
		if ( $atts['desc'] ) {
			$desc = sprintf( '<div class="desc col-md-offset-1 col-md-10 col-sm-12" %s>%s</div>',
				$color,
				$atts['desc']
			);
		}

		if( $atts['text_align'] ) {
			$css_class[] = $atts['text_align'] ;
		}
		$css_class[] = $atts['class_name'];
		$css_class[] = $atts['style'];
		return sprintf(
			'<div class="%s" %s><h2 %s>%s</h2>%s</div>',
			implode( ' ', $css_class ),
			$data_animation,
			$color,
			$content,
			$desc
		);
	}


	/**
	 * Shortcode to display section title
	 *
	 * @param  array $atts
	 * @param  string $content
	 * @return string
	 */
	function section_title_2( $atts, $content ) {
		$atts = shortcode_atts(array(
			'color'      => '',
			'text_align' => 'align-center',
			'style'      => '',
			'title'       => '',
			'class_name' => '',
			'animation'  => '',
			'duration'   => '',
			'delay'      => '',
		), $atts );

		$data_animation = '';
		$css_class[] = 'section-title clearfix';
		if( $atts['animation'] ) {
			$css_class[] = 'wow ' . esc_attr( $atts['animation'] );
			if( $atts['duration'] ) {
				$data_animation .= ' data-wow-duration="' . esc_attr( $atts['duration'] ) . 'ms"';
			}
			if( $atts['delay'] ) {
				$data_animation .= ' data-wow-delay="' . esc_attr( $atts['delay'] ) . 'ms"';
			}
		}

		$color = '';
		if( $atts['color'] ) {
			$color = 'style="color:' . esc_attr( $atts['color'] ) . '"' ;
		}

		$desc = '';
		if ( $content ) {
			$desc = sprintf( '<div class="desc col-md-offset-1 col-md-10 col-sm-12" %s>%s</div>',
				$color,
				$content
			);
		}

		$title = '';
		if( $atts['title'] ) {
			$title = sprintf( '<h2 %s>%s</h2>', $color, $atts['title'] );
		}

		if( $atts['text_align'] ) {
			$css_class[] = $atts['text_align'] ;
		}
		$css_class[] = $atts['class_name'];
		$css_class[] = $atts['style'];
		return sprintf(
			'<div class="%s" %s>%s %s</div>',
			implode( ' ', $css_class ),
			$data_animation,
			$title,
			$content
		);
	}

	/**
	 * Display icon box shortcode
	 *
	 * @param  array $atts
	 * @param  string $content
	 * @return string
	 */
	function icon_box( $atts, $content ) {
		$title = $link = $icon = $icon_position = $bg_color = $border_circle = $icon_class = $animation = $duration = $delay = '';
		extract( shortcode_atts( array(
			'title'         => '',
			'link'          => '',
			'icon'          => '',
			'border_circle' => '',
			'icon_position' => 'top',
			'icon_class'    => '',
			'bg_color'      => '',
			'animation'     => '',
			'duration'      => '',
			'delay'         => '',
		), $atts ) );

		$data_animation = '';
		if( $animation ) {
			$icon_class .= ' wow ' . esc_attr( $animation );
			if( $duration ) {
				$data_animation .= ' data-wow-duration="' . esc_attr( $duration ) . 'ms"';
			}
			if( $delay ) {
				$data_animation .= ' data-wow-delay="' . esc_attr( $delay ) . 'ms"';
			}
		}

		if( $border_circle ) {
			$icon_class .= ' border-circle';
		}

		if( $bg_color ) {
			$bg_color = 'style="background-color:' . esc_attr( $bg_color ) . '"' ;
			$icon_class .= ' bg-color';
		}

		if( $link ) {
			$title = sprintf( '<a class="box-title" href="%s">%s</a>', esc_url( $link ), $title );
		}
		else {
			$title = sprintf( '<span class="box-title">%s</span>', $title );
		}

		return sprintf(
			'<div class="icon-box icon-%s %s" %s %s><i class="b-icon %s fa %s"></i>%s<div class="box-content">%s</div></div>',
			esc_attr( $icon_position ),
			esc_attr( $icon_class ),
			$bg_color,
			$data_animation,
			$border_circle,
			esc_attr( $icon ),
			$title,
			do_shortcode( $content )
		);
	}

	/**
	 * Display image box shortcode
	 *
	 * @param  array $atts
	 * @param  string $content
	 * @return string
	 */
	function image_box( $atts, $content ) {
		$title = $image = $image_position = $image_style = $link = $image_class = $animation = $duration = $delay = '';
		extract( shortcode_atts( array(
			'title'          => '',
			'image'          => '',
			'image_size'     => 'thumbnail',
			'image_position' => 'top',
			'image_class'    => '',
			'image_style'    => '',
			'link'           => '',
			'animation'      => '',
			'duration'       => '',
			'delay'          => '',
		), $atts ) );

		$data_animation = '';
		$css_class = '';
		if( $animation ) {
			$css_class = ' wow ' . esc_attr( $animation );
			if( $duration ) {
				$data_animation .= ' data-wow-duration="' . esc_attr( $duration ) . 'ms"';
			}
			if( $delay ) {
				$data_animation .= ' data-wow-delay="' . esc_attr( $delay ) . 'ms"';
			}
		}

		if( $image ) {
			$image = wp_get_attachment_image_src( $image, $atts['image_size'] );

			if( $image ) {
				$image = sprintf( '<img src="%s" alt="%s" class="img-%s">', esc_url( $image[0] ), esc_attr( $title ), esc_attr( $image_style ) );
			}
		}

		if( $link ) {
			$title = sprintf( '<a class="image-box-title" href="%s">%s</a>', esc_url( $link ), $title );

			if( $image ) {
				$image = sprintf( '<a class="image-box-link" href="%s">%s</a>', esc_url( $link ), $image );
			}
		}
		else {
			$title = sprintf( '<span class="image-box-title">%s</span>', $title );
		}

		return sprintf(
			'<div class="image-box image-%s %s %s" %s>%s %s<div class="image-box-content">%s</div></div>',
			esc_attr( $image_position ),
			esc_attr( $image_class ),
			esc_attr( $css_class ),
			$data_animation,
			$image,
			$title,
			do_shortcode( $content )
		);
	}


	/**
	 * Testimonial shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function testimonial( $atts, $content ) {
		$atts = shortcode_atts( array(
			'style'      => 'short',
			'slider'     => '',
			'number'     => 'all',
			'single'     => '',
			'speed'      => '700',
			'navigation' => '',
			'pagination' => '',
			'class_name' => '',
			'autoplay'   => '',
			'animation'  => '',
			'duration'   => '',
			'delay'      => '',
		), $atts );

		$size = 'widget-thumb';
		$item_class = '';
		$data_animation = '';
		$css_class = array();
		$css_class[] = 'testimonial-list';
		$id  = '';

		if( $atts['slider'] ) {
			$speed = intval( $atts['speed'] );
			$id = uniqid( 'testimonial-slider-' );
			$this->l10n['testimonial'][$id] = array(
				'speed'      => $speed,
				'navigation' => $atts['navigation'] ? $atts['navigation'] : 'false',
				'pagination' => $atts['pagination'] ? $atts['pagination'] : 'false',
				'single'     => $atts['single'] ? $atts['single'] : 'false',
				'autoplay'   => $atts['autoplay'] ? $atts['autoplay'] : 'false'
			);
			$id = 'id="' . $id . '"';
		} else {
			if( $atts['style'] == 'full' ) {
				$size = 'testimonial-thumb';
				$item_class = 'col-sm-6 col-md-6';
				$css_class[] = 'row';
			} elseif( $atts['style'] == 'medium' ) {
				$item_class = 'col-sm-4 col-md-4';
				$css_class[] = 'row';
			}
		}


		if( $atts['animation'] ) {
			$css_class[] = 'wow';
			$css_class[] = esc_attr( $atts['animation'] );

			if( $atts['duration'] ) {
				$data_animation .= ' data-wow-duration="' . esc_attr( $atts['duration'] ) . 'ms"';
			}
			if( $atts['delay'] ) {
				$data_animation .= ' data-wow-delay="' . esc_attr( $atts['delay'] ) . 'ms"';
			}
		}

		$css_class[] = isset( $atts['class_name'] ) ? esc_attr( $atts['class_name'] ) : '';
		$css_class[] = 'testimonial-' . esc_attr( $atts['style'] );

		$number = -1;
		if( strtolower( $atts['number'] ) != 'all' ) {
			$number = intval( $atts['number'] );
		}

		$index = 0;
		$output = array();
		$args = array(
			'post_type'      => 'testimonial',
			'posts_per_page' => $number,
		);
		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) :
			$the_query->the_post();

			$args = array(
				'size'    => $size,
				'echo'    => false,
				'format'  => 'src',
			);
			$image_src = onehost_get_image( $args );
			$cats = wp_get_post_terms( get_the_ID(), 'testimonial_category' );
			$cat_name = $cats ? $cats[0]->name : '';

			if( ! $atts['slider'] ) {
				if( $atts['style'] == 'full' ) {
					if( $index % 2 == 0 && $index != 0 ) $output[] = '<div class="clearfix"></div>';
					$index++;
				} elseif( $atts['style'] == 'medium' ) {
					if( $index % 3 == 0 && $index != 0 ) $output[] = '<div class="clearfix"></div>';
					$index++;
				}
			}

			$output[] = sprintf( '<div class="testi-item %s">', $item_class );
			$star = onehost_get_meta( 'star' );
			if( $star && $star != '0' ) {
				$output[] = '<div class="testi-star">';
				$star = explode('.', $star);
				$num = intval( $star[0] );
				if( $num ) {
					if( $num > 0 ) {
						for ( $i = 0; $i < $num ; $i++ ) {
							$output[] = '<i class="fa fa-star fa-md"></i>';
						}
					}
				}

				if( isset( $star[1] ) ) {
					$output[] = '<i class="fa fa-star-half-empty fa-md"></i>';
				} else {
					$num = 5 - $num;
					if( $num > 0 ) {
						for ( $i = 0; $i < $num ; $i++ ) {
							$output[] = '<i class="fa fa-star-o fa-md"></i>';
						}
					}
				}
				$output[] = '</div>';
			}

			$output[] = sprintf( '<div class="testi-desc">%s</div>', get_the_excerpt() );
			$output[] = sprintf(
				'<div class="testi-author"><img src="%s" alt="%s" class="testi-pic"><div class="testi-company"><strong>%s</strong><span>, %s</span></div></div>',
				esc_url( $image_src ),
				the_title_attribute( 'echo=0' ),
				get_the_title(),
				$cat_name
			);
			$output[] = '</div>';

		endwhile;
		wp_reset_postdata();

		return sprintf( '<div %s class="%s" %s>%s</div>',
			$id,
			implode( ' ', $css_class ),
			$data_animation,
			implode( '', $output )
		);
	}


	/**
	 * Images carousel shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function images_carousel( $atts, $content ) {
		$atts = shortcode_atts( array(
			'images'              => '',
			'image_size'          => 'thumbnail',
			'custom_links'        => '',
			'custom_links_target' => '_self',
			'number'              => '4',
			'speed'               => '5000',
			'autoplay'            => '',
			'navigation'          => '',
			'class_name'          => '',
			'animation'           => '',
			'duration'            => '',
			'delay'               => '',
		), $atts );

		$data_animation = '';
		$css_class = '';
		if( $atts['animation'] ) {
			$css_class = ' wow ' . esc_attr( $atts['animation'] );
			if( $atts['duration'] ) {
				$data_animation .= ' data-wow-duration="' . esc_attr( $atts['duration'] ) . 'ms"';
			}
			if( $atts['delay'] ) {
				$data_animation .= ' data-wow-delay="' . esc_attr( $atts['delay'] ) . 'ms"';
			}
		}

		$output = array();
		$number = intval( $atts['number'] );
		$number = $number ? $number : '4';

		$speed = intval( $atts['speed'] );
		$speed = $speed ? $speed : '5000';

		$custom_links = $atts['custom_links'] ? explode( '<br />', $atts['custom_links'] ) : '';
		$images = $atts['images'] ? explode( ',', $atts['images'] ) : '';

		$id = uniqid( 'images-carousel-' );
		$this->l10n['imagesCarousel'][$id] = array(
			'number'     => $number,
			'speed'      => $speed . 'ms',
			'autoplay'   => $atts['autoplay'] ? $atts['autoplay'] : 'false',
			'navigation' => $atts['navigation'] ? $atts['navigation'] : 'false'
		);
		if( $images ) {
			$i= 0;
			foreach ( $images as $attachment_id ) {
				$image = wp_get_attachment_image_src( $attachment_id, $atts['image_size'] );
				if( $image ) {
					$link = '';
					if( $custom_links &&  isset( $custom_links[$i] ) ) {
						$link = 'href="' . esc_url( $custom_links[$i] ) . '"';
					}
					$output[] =	sprintf( '<div class="item"><a %s target="%s" ><img alt="%s" src="%s"></a></div>',
						$link,
						esc_attr( $atts['custom_links_target'] ),
						esc_attr( $attachment_id ),
						esc_url( $image[0] )
					);
				}
				$i++;
			}
		}

		return sprintf( '<div id="%s" class="images-owl-carousel owl-theme %s %s" %s>%s</div>',
			esc_attr( $id ),
			$atts['class_name'],
			esc_attr( $css_class ),
			$data_animation,
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display pricing table
	 *
	 * @param  array $atts
	 * @param  string $content
	 * @return string
	 */
	function pricing( $atts, $content ) {
		$title = $price = $time_duration = $burl = $btext = $featured = '';
		extract( shortcode_atts(array(
			'title'         => '',
			'price'         => '',
			'time_duration' => '',
			'featured'      => '',
			'btext'         => 'Buy Now',
			'burl'          => '',
		), $atts ) );

		if( function_exists( 'wpb_js_remove_wpautop') ) {
			$content = wpb_js_remove_wpautop( $content, true );
		}

		$output[] = sprintf( '<div class="pricing-title">%s</div>',  $title );
		$output[] = sprintf( '<div class="pricing-info"><span class="p-price">%s</span>', $price );
		$output[] = sprintf( '<span class="p-duration">%s</span></div>', $time_duration );

		$plink = $btext ? sprintf( '<a class="pricing-blink btn-primary" href="%s">%s</a>', esc_url( $burl ), $btext ) : '';
		$output[] = sprintf( '<div class="pricing-desc">%s %s</div>', $content, $plink );

		$feature_class = $featured ? 'pricing-feature' : '';

		if ( $output )
			return sprintf( '<div class="pricing-item %s">%s</div>',
				esc_attr( $feature_class ),
				implode( '', $output )
			);

		return '';
	}


	/**
	 * Helper function to get coordinates for map
	 *
	 * @since 1.0.0
	 *
	 * @param string $address
	 * @param bool   $refresh
	 *
	 * @return array
	 */
	function get_coordinates( $address, $refresh = false ) {
		$address_hash = md5( $address );
		$coordinates  = get_transient( $address_hash );
		$results      = array( 'lat' => '', 'lng' => '' );

		if ( $refresh || $coordinates === false ) {
			$args     = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
			$url      = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/geocode/json' );
			$response = wp_remote_get( $url );

			if ( is_wp_error( $response ) ) {
				$results['error'] = __( 'Can not connect to Google Maps APIs', 'onehost' );

				return $results;
			}

			$data = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $data ) ) {
				$results['error'] = __( 'Can not connect to Google Maps APIs', 'onehost' );

				return $results;
			}

			if ( $response['response']['code'] == 200 ) {
				$data = json_decode( $data );

				if ( $data->status === 'OK' ) {
					$coordinates = $data->results[0]->geometry->location;

					$results['lat']     = $coordinates->lat;
					$results['lng']     = $coordinates->lng;
					$results['address'] = (string) $data->results[0]->formatted_address;

					// cache coordinates for 3 months
					set_transient( $address_hash, $results, 3600 * 24 * 30 * 3 );
				} elseif ( $data->status === 'ZERO_RESULTS' ) {
					$results['error'] = __( 'No location found for the entered address.', 'onehost' );
				} elseif ( $data->status === 'INVALID_REQUEST' ) {
					$results['error'] = __( 'Invalid request. Did you enter an address?', 'onehost' );
				} else {
					$results['error'] = __( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'onehost' );
				}
			} else {
				$results['error'] = __( 'Unable to contact Google API service.', 'onehost' );
			}
		} else {
			$results = $coordinates; // return cached results
		}

		return $results;
	}

	/**
	 * Adjust brightness color
	 *
	 * @param  string $hex
	 * @param  int $steps Steps should be between -255 and 255
	 * @return string
	 */
	function adjust_brightness( $hex, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));

		// Format the hex color string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
		}

		// Get decimal values
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));

		// Adjust number of steps and keep it inside 0 to 255
		$r = max(0,min(255,$r + $steps));
		$g = max(0,min(255,$g + $steps));
		$b = max(0,min(255,$b + $steps));

		$r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
		$g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
		$b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

		return '#' . $r_hex . $g_hex . $b_hex;
	}
}
