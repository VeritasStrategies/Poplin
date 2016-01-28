<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package OneHost
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<span> <?php echo __( 'Comments', 'onehost' ) . ' (' . get_comments_number() . ')' ?> </span>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( 'type=comment&avatar_size=80&callback=onehost_comment' );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation numeric-navigation" role="navigation">
			<?php echo paginate_comments_links(); ?>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'onehost' ); ?></p>
	<?php endif; ?>

	<?php
		$fields = comment_form_onehost_fields();
		$comment_field = '<p class="comment-form-comment col-md-12 col-sm-12"><textarea id="comment" placeholder="' . __( 'Your Comment', 'onehost' ) . '" name="comment" cols="45" rows="7" aria-required="true"></textarea></p>';
	?>
	<div class="clearfix"></div>
	<?php comment_form(
		array(
			'title_reply'   => __( 'Add A Comment', 'onehost' ),
			'fields'        => $fields,
			'comment_field' => $comment_field,
			'label_submit'  => __( 'Send Message', 'onehost' ),
		)
	)?>

</div><!-- #comments -->
