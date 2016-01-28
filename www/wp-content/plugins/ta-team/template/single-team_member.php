<?php
/**
 * Template for displaying single team member
 *
 * @package TA Team Management
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_action( 'ta_team_member_single_before' ) ?>

				<div <?php post_class() ?>>
					<div class="row">

						<?php do_action( 'ta_team_member_single_before_image' ) ?>
						<?php do_action( 'ta_team_member_single_image' ) ?>
						<?php do_action( 'ta_team_member_single_after_image' ) ?>


						<?php do_action( 'ta_team_member_single_before_info' ) ?>
						<?php do_action( 'ta_team_member_single_info' ); ?>
						<?php do_action( 'ta_team_member_single_after_info' ) ?>

					</div>
				</div>

				<?php do_action( 'ta_team_member_single_after' ) ?>

			<?php endwhile; ?>

		</div>
		<!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
