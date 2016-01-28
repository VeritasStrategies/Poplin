<?php
/**
 * The Template for displaying single portfolio.
 *
 * @package Onehost
 */

get_header(); ?>

<div id="primary" class="content-area col-sm-12 col-md-12">
	<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'parts/content', 'portfolio' ); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( onehost_theme_option( 'portfolio_comments' ) ) :
				comments_template();
			endif;
		?>

	<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
