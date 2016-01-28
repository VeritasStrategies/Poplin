<?php
/**
 * Template Name: WHMCS
 *
 * The template file for displaying whmcs page.
 *
 * @package Onehost
 */

$css_class = 'col-md-9 col-sm-9';
if ( 'full-content' == onehost_get_layout() ) {
	$css_class = 'col-md-12';
}

get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( $css_class ); ?>">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					the_content();
				?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar( 'whmcs' ); ?>
<?php get_footer(); ?>
