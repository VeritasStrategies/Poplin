<?php
/**
 * @package OneHost
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'fadeInLeft' ); ?>>
	<header class="entry-header clearfix">
		<?php onehost_entry_thumbnail(); ?>

		<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title() ?></a></h2>
		<?php
		$time_string = '<time class="entry-date published" datetime="%s"><span class="entry-day">%s</span><span class="entry-month">%s</span></time>';

		printf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( 'd' ) ),
			esc_html( get_the_date( 'M' ) )
		);
		?>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<span>
			<i class="fa fa-user"></i>
			<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'onehost' ), get_the_author() ) ) ?>" rel="author">
				<?php _e( 'By:', 'onehost' ); ?>
				<?php the_author(); ?>
			</a>
		</span>

		<span>
			<i class="fa fa-tag"></i>
			<span class="entry-tags">
				<?php the_category( ', ' ); ?>
			</span>
		</span>

		<span>
			<i class="fa fa-comment"></i>
			<?php comments_popup_link( __( '0 comment', 'onehost' ), __( '1 comments', 'onehost' ), __( '% comments', 'onehost' ), 'comments-link' ); ?>
		</span>

		<span>
			<i class="fa fa-arrow-right"></i>
			<a href="<?php the_permalink() ?>"><?php _e( 'Read more', 'onehost' ) ?></a>
		</span>
	</footer>
</article><!-- #post-## -->
