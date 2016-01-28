<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package OneHost
 */
?>		<?php if ( ! is_page_template( 'one-page.php' ) ) : ?>
				</div>
			</div><!-- .container -->
		</div><!-- #site-content -->
		<?php endif; ?>

	<footer id="site-footer" class="site-footer" role="contentinfo">
		<?php if ( onehost_theme_option( 'footer_widgets' ) ) : ?>

			<div class="footer-sidebars clearfix">
				<div class="container">
					<div class="row">
						<?php
							$columns = intval( onehost_theme_option( 'footer_widget_columns' ) );
							$col_class = 12 / max( 1, $columns );
							$col_class = "col-sm-$col_class col-md-$col_class";
							for ( $i = 1; $i <= $columns ; $i++ ) {
							?>
								<div class="widget-area footer-sidebar-<?php echo $i ?> <?php echo esc_attr( $col_class ) ?>">
									<?php dynamic_sidebar( __( 'Footer ', 'onehost' ) . $i ) ?>
								</div>
							<?php
							}
						?>
					</div>
				</div>
			</div><!-- .footer-sidebars -->

		<?php endif; ?>
		<div class="site-info clearfix">
			<div class="container">
				<?php onehost_socials(); ?>
				<?php echo wpautop( onehost_theme_option( 'footer_copyright' ) ); ?>
				<a id="scroll-top" class="backtotop" href="#page-top">
					<i class="fa fa-arrow-up"></i>
				</a>
			</div>
		</div><!-- .site-info -->
		<?php if ( onehost_theme_option( 'preloader' ) ) : ?>
			<div id="loader">
				<div class="loader"></div>
			</div>
		<?php endif; ?>
	</footer><!-- #site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

</body>
</html>
