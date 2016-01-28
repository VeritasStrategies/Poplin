<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package OneHost
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="error-404 not-found">
			<div class="page-content">
				<div class="col-sm-12 col-md-12">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'onehost' ); ?></p>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-6">
					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php _e( 'Most Used Categories', 'onehost' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
				</div>

				<div class="col-sm-6 col-md-6">
				<?php
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'onehost' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
				</div>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
