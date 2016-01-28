<?php
/**
 * Display portfolio on frontend
 *
 * @package TA Portfolio Management
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load template file for portfolio
 * Check if a custom template exists in the theme folder,
 * if not, load template file in plugin
 *
 * @since  1.0.0
 *
 * @param  string $template Template name with extension
 *
 * @return string
 */
function ta_portfolio_get_template( $template ) {
	if ( $theme_file = locate_template( array( $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = TA_PORTFOLIO_DIR . 'template/' . $template;
	}

	return apply_filters( __FUNCTION__, $file, $template );
}

/**
 * Load template file for portfolio single
 *
 * @since  1.0.0
 *
 * @param  string $template
 *
 * @return string
 */
function ta_portfolio_template_include( $template ) {
	if ( is_singular( 'portfolio_project' ) ) {
		return ta_portfolio_get_template( 'single-portfolio_project.php' );
	}

	return $template;
}

add_filter( 'template_include', 'ta_portfolio_template_include' );

/**
 * Enqueue scripts and styles for display portfolio with special layout and filter
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_portfolio_enqueue_scripts() {
	global $wp_query;
	$content = is_404() ? '' : $wp_query->post->post_content;

	wp_register_script( 'images-loaded', TA_PORTFOLIO_URL . 'js/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.1.8', true );
	wp_register_script( 'isotope', TA_PORTFOLIO_URL . 'js/isotope.pkgd.min.js', array( 'jquery' ), '2.0.0', true );

	if ( has_shortcode( $content, 'ta_portfolio' ) || has_shortcode( $content, 'ta_portfolio_showcase' ) || is_singular( 'portfolio_project' ) || apply_filters( 'ta_portfolio_enqueue_scripts', false ) ) {
		if ( apply_filters( 'ta_portfolio_frontend_css', true ) ) {
			wp_enqueue_style( 'ta-portfolio', TA_PORTFOLIO_URL . 'css/portfolio.css', array(), TA_PORTFOLIO_VER );
		}

		if ( apply_filters( 'ta_portfolio_frontend_js', true ) ) {
			$dev = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
			wp_enqueue_script( 'ta-portfolio', TA_PORTFOLIO_URL . "js/portfolio$dev.js", array( 'images-loaded', 'isotope' ), TA_PORTFOLIO_VER, true );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'ta_portfolio_enqueue_scripts' );

/**
 * Filter function to add classes to portfolio item
 *
 * @since  1.0.0
 *
 * @param  array $classes Default class
 *
 * @return array
 */
function ta_portfolio_class( $classes ) {
	if ( 'portfolio_project' != get_post_type() ) {
		return $classes;
	}

	$terms = get_the_terms( get_the_ID(), 'portfolio_category' );
	if( $terms ) {
		foreach ( $terms as $term ) {
			$classes[] = $term->slug;
		}
	}

	return $classes;
}

add_filter( 'post_class', 'ta_portfolio_class' );

/**
 * Filter function for adding 'portfolio-wide' class to portfolio item when layout is masonry
 *
 * @since  1.0.0
 *
 * @param  array $classes Default classes
 * @param  array $atts    The shortcode attributes
 * @param  int   $current Current post position in query
 * @param  int   $number  The number of posts being displayed
 *
 * @return array
 */
function ta_portfolio_masonry_item_class( $classes, $atts, $current, $number ) {
	if ( 'metro' != $atts['layout'] ) {
		return $classes;
	}

	$mod = $current % 8;
	if ( 5 >= $number ) {
		if ( 1 == $mod || 3 == $mod ) {
			$classes[] = 'portfolio-wide';
		}

		if ( 2 == $mod ) {
			$classes[] = 'portfolio-long';
		}
	} elseif ( 6 == $number ) {
		if ( 4 == $mod ) {
			$classes[] = 'portfolio-wide';
		}

		if ( 2 == $mod ) {
			$classes[] = 'portfolio-long';
		}
	} else {
		if ( 1 == $mod || 7 == $mod ) {
			$classes[] = 'portfolio-wide';
		}

		if ( 2 == $mod || 3 == $mod ) {
			$classes[] = 'portfolio-long';
		}
	}

	return $classes;
}

add_filter( 'ta_portfolio_item_class', 'ta_portfolio_masonry_item_class', 10, 4 );

/**
 * Filter function for changing image size when layout is masonry
 *
 * @since  1.0.0
 *
 * @param  array $size    Default thumbnail size
 * @param  array $atts    The shortcode attributes
 * @param  int   $current Current post position in query
 * @param  int   $number  The number of posts being displayed
 *
 * @return string
 */
function ta_portfolio_masonry_thumbnail_size( $size, $atts, $current, $number ) {
	switch ( $atts['layout'] ) {
		case 'metro':
			$mod = $current % 8;
			if ( 5 >= $number ) {
				if ( 1 == $mod || 3 == $mod ) {
					$size = 'portfolio-thumbnail-wide';
				}

				if ( 2 == $mod ) {
					$size = 'portfolio-thumbnail-long';
				}
			} elseif ( 6 == $number ) {
				if ( 2 == $mod ) {
					$size = 'portfolio-thumbnail-long';
				}

				if ( 4 == $mod ) {
					$size = 'portfolio-thumbnail-wide';
				}
			} else {
				if ( 1 == $mod || 7 == $mod ) {
					$size = 'portfolio-thumbnail-wide';
				}

				if ( 2 == $mod || 3 == $mod ) {
					$size = 'portfolio-thumbnail-long';
				}
			}
			break;

		case 'masonry':
			$size = 'full';
			break;
	}

	return $size;
}

add_filter( 'ta_portfolio_item_thumnail_size', 'ta_portfolio_masonry_thumbnail_size', 10, 4 );

/**
 * Display project url at bottom of portfolio single,
 * before comments area
 *
 * @since  1.0.1
 *
 * @return void
 */
function ta_portfolio_product_url() {
	$project_client = get_post_meta( get_the_ID(), '_project_client', true );
	$project_url    = get_post_meta( get_the_ID(), '_project_url', true );

	if ( empty( $project_url ) ) {
		return;
	}
	?>

	<div class="project-data">
		<div class="project-client">
			<span class="label"><?php _e( 'Project Client', 'ta-portfolio' ) ?></span>:
			<?php echo $project_client; ?>
		</div>

		<div class="project-url">
			<span class="label"><?php _e( 'Project URL', 'ta-portfolio' ) ?></span>:
			<a href="<?php echo $project_url; ?>" target="_blank" rel="nofollow"><?php echo $project_url; ?></a>
		</div>
	</div>

	<?php
}

add_action( 'ta_portfolio_single_after_content', 'ta_portfolio_product_url' );

/**
 * Display portfolio category
 *
 * @since  1.0.1
 *
 * @return void
 */
function ta_portfolio_meta() {
	if ( ! has_term( '', 'portfolio_category' ) ) {
		return;
	}
	?>

	<footer class="entry-footer">
		<div class="portfolio-meta entry-meta">
			<?php the_terms( get_the_ID(), 'portfolio_category', __( 'Category: ', 'ta-portfolio' ), ', ' ) ?>
		</div>
	</footer>

	<?php
}

add_action( 'ta_portfolio_single_before_comments', 'ta_portfolio_meta' );
