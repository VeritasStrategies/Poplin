<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Onehost
 */

if ( 'full-content' == onehost_get_layout() ) {
	return;
}
?>
<aside id="secondary" class="widgets-area col-md-4" role="complementary">
	<?php if ( ! dynamic_sidebar( 'primary-sidebar' ) ) : ?>

		<div id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</div>

		<div id="archives" class="widget">
			<h4 class="widget-title"><?php _e( 'Archives', 'onehost' ); ?></h4>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</div>

	<?php endif; // end sidebar widget area ?>
</aside><!-- #secondary -->
