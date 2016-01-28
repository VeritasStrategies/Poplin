<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package OneHost
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if(  ! onehost_get_meta( 'hide_singular_title' ) ) : ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'onehost' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'onehost' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
