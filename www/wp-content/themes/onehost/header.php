<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package OneHost
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!--[if lt IE 9]>
	<script src="//cdn.jsdelivr.net/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="//cdn.jsdelivr.net/respond/1.3.0/respond.min.js"></script>
	<![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="wrap" class="hfeed site">

		<header id="site-header" class="site-header" role="banner">
			<div class="container">
				<div class="site-branding clearfix">
					<?php
					$logo = onehost_theme_option( 'logo' );
					if ( ! $logo ) {
						$logo = THEME_URL . '/img/logo.png';
					}
					?>
					<a href="<?php echo esc_url( home_url() ) ?>" class="logo"><img src="<?php echo esc_url( $logo ) ?>" alt="logo"></a>
					<?php
					printf(
						'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
						is_home() ? 'h1' : 'p',
						esc_url( home_url( '/' ) ),
						get_bloginfo( 'name' )
					);
					?>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<a href="#" class="navbar-toggle">
						<i class="fa fa-bars nav-bars"></i>
					</a>
				</div><!-- .site-branding -->

				<nav id="primary-nav" class="primary-nav nav" role="navigation">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => '',
						'menu_class'     => 'nav navbar-nav',
					) );
					?>
				</nav><!-- #site-navigation -->
			</div>
		</header><!-- #site-header -->

		<?php get_template_part( 'parts/title', 'area' ); ?>

		<?php if ( ! is_page_template( 'one-page.php' ) ) : ?>
			<div id="site-content" class="site-content">

				<div class="container">
					<div class="row">
			<?php endif; ?>
