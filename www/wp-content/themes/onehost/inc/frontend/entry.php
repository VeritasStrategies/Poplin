<?php
/**
 * Hooks for template archive
 *
 * @package OneHost
 */


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @since 1.0
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function onehost_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'onehost_setup_author' );

/**
 * Archive title
 *
 * @param  string $title
 * @return string
 */
function onehost_the_archive_title( $title ) {
	if ( is_404() ) {
		$title = __( 'Page not found', 'onehost' );
	} elseif ( is_home() ) {
		if ( 'posts' == get_option( 'show_on_front' ) ) {
			$title = __( 'Blog', 'onehost' );
		} else {
			$page_for_posts = get_option( 'page_for_posts' );
			$title = $page_for_posts ? get_the_title( $page_for_posts ) : __( 'Blog', 'onehost' );
		}
	} elseif ( is_singular() ) {
		$title = get_the_title();
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'onehost_the_archive_title' );

/**
 * Template Comment
 *
 * @since  1.0
 *
 * @param  array  $comment
 * @param  array  $args
 * @param  int    $depth
 *
 * @return mixed
 */
function onehost_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>

	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
		<article id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>

	<div class="comment-author vcard">
		<?php
		if ( $args['avatar_size'] != 0 ) {
			echo get_avatar( $comment, $args['avatar_size'] );
		}
		?>
	</div>
	<div class="comment-meta commentmetadata">
		<?php printf( '<cite class="author-name">%s</cite>', get_comment_author_link() ); ?>

		<a class="author-posted" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php printf( '%1$s, %2$s', get_comment_date( 'd M Y' ),  get_comment_time() ); ?>
		</a>

		<?php
		comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
		edit_comment_link( __( 'Edit', 'onehost' ), '  ', '' );
		?>

		<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'onehost' ); ?></em>
		<?php endif; ?>

		<div class="comment-content">
			<?php comment_text(); ?>
		</div>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
		</article>
	<?php endif; ?>
	<?php
}

/**
 * Custom fields comment form
 *
 * @since  1.0
 *
 * @return  array  $fields
 */
function comment_form_onehost_fields() {
	global $commenter, $aria_req;

	$fields =  array(
		'author'=>	'<p class="comment-form-author col-md-4 col-sm-12">' .
					'<input id ="author" placeholder="' . __( 'Name', 'onehost' ) . ' " name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size    ="30"' . $aria_req . ' /></p>',

		'email' =>	'<p class="comment-form-email col-md-4 col-sm-12">' .
					'<input id ="email" placeholder="' . __( 'Email', 'onehost' ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size    ="30"' . $aria_req . ' /></p>',

		'url'   =>	'<p class="comment-form-url col-md-4 col-sm-12">' .
					'<input id ="url" placeholder="' . __( 'Website', 'onehost' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size    ="30" /></p>'
	);
	return $fields;
}
add_filter( 'comment_form_default_fields', 'comment_form_onehost_fields' );
