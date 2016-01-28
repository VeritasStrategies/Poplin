<?php
/**
 * The template part for displaying portfolio single content.
 *
 * @package Onehost
 */
?>
<article id="portfolio-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header clearfix">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ) ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'onehost' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<div class="portfolio-project-details row">
		<div class="col-sm-8 col-md-8 portfolio-slider">
			<?php
			$gallery = get_post_meta( get_the_ID(), 'images', false );
			if( $gallery ) {
				echo '<div class="flexslider"><div class="slides">';
				foreach ( $gallery as $image ) {
					echo '<div class="entry-item">' . wp_get_attachment_image( $image, 'portfolio-project' ) . '</div>';
				}
				echo '</div></div>';
			}
			else {
				echo get_the_post_thumbnail( get_the_ID(), 'portfolio-project' );
			}

			?>
		</div><!-- .grid-8 -->

		<div class="col-sm-4 col-md-4 portfolio-description">
			<h4 class="portfolio-title"><span><?php _e( 'Project Description', 'onehost' ); ?></span></h4>
			<div class="portfolio-item">
				<span><?php _e( 'Client:', 'onehost' ) ?></span>
				<?php echo get_post_meta( get_the_ID(), '_project_client', true ) ?>
			</div>
			<div class="portfolio-item">
				<span><?php _e( 'Skills:', 'onehost' ) ?></span>
				<?php echo get_post_meta( get_the_ID(), '_project_skills', true ) ?>
			</div>
			<div class="portfolio-item">
				<span><?php _e( 'URL:', 'onehost' ) ?></span>
				<?php echo get_post_meta( get_the_ID(), '_project_url', true ) ?>
			</div>
			<div class="portfolio-item">
				<span><?php _e( 'Category:', 'onehost' ) ?></span>
				<?php echo get_the_term_list( get_the_ID(), 'portfolio_category', '', ', ', '' ); ?>
			</div>
			<?php
			$size = 'widget-thumb';
			$image = onehost_get_image( array(
				'size'     => $size,
				'format'   => 'src',
				'meta_key' => 'image',
				'echo'     => false,
			) );
			?>
		</div><!-- .entry-footer -->
	</div>
	<footer class="entry-footer portfolio-footer">
		<?php onehost_post_nav(); ?>
	</footer>
</article><!-- #post-## -->
