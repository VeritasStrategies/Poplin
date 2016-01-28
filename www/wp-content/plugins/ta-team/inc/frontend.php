<?php
/**
 * Display Team on frontend
 *
 * @package TA Team Management
 */

/**
 * Load template file for team_member single
 * Check if a custom template exists in the theme folder,
 * if not, load template file in plugin
 *
 * @since  1.0.0
 *
 * @param  string $template Template name with extension
 *
 * @return string
 */
function ta_team_get_template( $template ) {
	if ( $theme_file = locate_template( array( $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = TA_TEAM_DIR . 'template/' . $template;
	}

	return apply_filters( __FUNCTION__, $file, $template );
}

/**
 * Load template file for team member single
 *
 * @since  1.0.0
 *
 * @param  string $template
 *
 * @return string
 */
function ta_team_template_include( $template ) {
	if ( is_singular( 'team_member' ) ) {
		return ta_team_get_template( 'single-team_member.php' );
	}

	return $template;
}

add_filter( 'template_include', 'ta_team_template_include' );

/**
 * Enqueue scripts and styles
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_team_enqueue_scripts() {
	global $wp_query;
	$content = is_404() ? '' : $wp_query->post->post_content;

	if ( ! wp_style_is( 'font-awesome', 'registered' ) && apply_filters( 'ta_team_register_font_awesome', true ) ) {
		wp_register_style( 'font-awesome', TA_TEAM_URL . 'css/font-awesome.min.css', array(), '4.1.0' );
	}

	if ( ! wp_style_is( 'bootstrap-grid-responsive', 'registered' ) && apply_filters( 'ta_team_register_bootstrap', true ) ) {
		wp_register_style( 'bootstrap-grid-responsive', TA_TEAM_URL . 'css/bootstrap.min.css', array(), '3.2.0' );
	}

	wp_register_style( 'ta-team', TA_TEAM_URL . 'css/team.css', array(), TA_TEAM_VER );

	if (
		has_shortcode( $content, 'ta_team' )
		|| has_shortcode( $content, 'ta_team_showcase' )
		|| is_singular( 'team_member' )
		|| apply_filters( 'ta_team_load_scripts', false )
	) {
		$styles = array(
			'font-awesome'              => 'font-awesome',
			'bootstrap-grid-responsive' => 'bootstrap-grid-responsive',
			'ta-team'                   => 'ta-team',
		);
		$styles = apply_filters( 'ta_team_frontend_css', $styles );
		foreach ( $styles as $style ) {
			wp_enqueue_style( $style );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'ta_team_enqueue_scripts' );

/**
 * Display team member image on singular page
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_team_member_image() {
	?>

	<div class="member-image col-md-4 col-sm-6 col-xs-12">
		<?php the_post_thumbnail( 'full' ); ?>
	</div>

	<?php
}

add_action( 'ta_team_member_single_image', 'ta_team_member_image' );

/**
 * Display team member info on singular page
 *
 * @since  1.0.0
 *
 * @return void
 */
function ta_team_member_info() {
	$job     = get_post_meta( get_the_ID(), '_team_member_job', true );
	$address = get_post_meta( get_the_ID(), '_team_member_address', true );
	$phone   = get_post_meta( get_the_ID(), '_team_member_phone', true );
	$email   = get_post_meta( get_the_ID(), '_team_member_email', true );
	$url     = get_post_meta( get_the_ID(), '_team_member_url', true );
	$socials = get_post_meta( get_the_ID(), '_team_member_socials', true );

	$socials = array_filter( $socials );
	?>

	<div class="member-info col-md-8 col-sm-6 col-xs-12">

		<h1 class="member-name entry-title"><?php the_title(); ?></h1>
		<p class="job-title"><?php echo $job; ?></p>

		<p class="member-group"><?php the_terms( get_the_ID(), 'team_group', __( 'Group: ', 'ta-team' ), ', ' ); ?></p>

		<?php
		if ( $socials ) {
			echo '<div class="member-socials">';
			foreach ( $socials as $social => $link ) {
				$title  = 'googleplus' == $social ? __( 'Google Plus', 'ta-team' ) : ucfirst( $social );
				$social = 'googleplus' == $social ? 'google-plus' : $social;
				$social = 'vimeo' == $social ? 'vimeo-square' : $social;

				printf( '<a href="%s" class="fa fa-%s" title="%s" target="_blank"></a>', $link, $social, $title );
			}
			echo '</div>';
		}
		?>

		<div class="member-bio"><?php the_content(); ?></div>

	</div>

	<?php
}

add_action( 'ta_team_member_single_info', 'ta_team_member_info' );

/**
 * Change excerpt more
 *
 * @since  1.0.0
 *
 * @param  string $more
 *
 * @return string
 */
function ta_team_excerpt_more( $more ) {
	if ( 'team_member' == get_post_type() ) {
		$more = '';
	}

	return $more;
}

add_filter( 'excerpt_more', 'ta_team_excerpt_more' );
