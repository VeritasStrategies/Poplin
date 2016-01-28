<?php
/**
 * Template Name: One Page
 *
 * The template file for displaying one page.
 *
 * @package OneHost
 */

get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;
?>

<?php get_footer(); ?>
