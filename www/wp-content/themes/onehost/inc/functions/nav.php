<?php
/**
 * Custom functions for nav menu
 *
 * @package OneHost
 */

/**
 * Display numeric pagination
 *
 * @since 1.0
 * @return void
 */
function onehost_numeric_pagination() {
	global $wp_query;

	if( $wp_query->max_num_pages < 2 ) {
        return;
	}

	?>
	<nav class="navigation paging-navigation numeric-navigation" role="navigation">
		<?php
		$big = 999999999;
		$args = array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'total'     => $wp_query->max_num_pages,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'prev_text' => __( 'Prev', 'onehost' ),
			'next_text' => __( 'Next', 'onehost' ),
			'type'      => 'plain',
		);

		echo paginate_links( $args );
		?>
	</nav>
<?php
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 1.0
 * @return void
 */
function onehost_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'onehost' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'onehost' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php
}


/**
 * Display navigation to next/previous post when applicable.
 *
 * @since 1.0
 * @return void
 */
function onehost_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php
			previous_post_link( '	<div class="nav-previous">%link</div>', '<i class="fa fa-angle-left"></i>' );
			next_post_link(     '<div class="nav-next">%link</div>', '<i class="fa fa-angle-right"></i>' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php
}
