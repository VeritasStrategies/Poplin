<?php
/**
 * Template for displaying single portfolio
 *
 * @package TA Portfolio Management
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_action( 'ta_portfolio_single_before' ) ?>

				<article <?php post_class() ?>>

					<?php do_action( 'ta_portfolio_single_before_header' ) ?>

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>

					<?php do_action( 'ta_portfolio_single_after_header' ) ?>

					<div class="entry-content">
						<?php do_action( 'ta_portfolio_single_before_content' ) ?>

						<?php the_content(); ?>

						<?php do_action( 'ta_portfolio_single_after_content' ) ?>
					</div>

					<?php do_action( 'ta_portfolio_single_before_comments' ) ?>

					<?php comments_template(); ?>

					<?php do_action( 'ta_portfolio_single_after_comments' ) ?>
				</article>

				<?php do_action( 'ta_portfolio_single_after' ) ?>

			<?php endwhile; ?>

		</div>
		<!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
