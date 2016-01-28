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

<div id="secondary" class="widget-area col-md-3 col-sm-3 whmcs-widget" role="complementary">
	<?php if ( ! dynamic_sidebar( 'whmcs-sidebar' ) ) : ?>
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary -->
