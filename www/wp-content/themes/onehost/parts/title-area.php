<?php
/**
 * The template part for displaying title area
 *
 * @package OneHost
 */

if ( is_page_template( 'one-page.php' ) || ( is_singular() && onehost_get_meta( 'hide_singular_title_area' ) ) ) {
	return;
}
?>

<div id="title-area" class="title-area">
	<div class="container">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
	</div>
</div><!-- .page-header -->
