<?php
/* *
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package _rhd
 */

if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) header('X-UA-Compatible: IE=edge,chrome=1'); ?>
<!doctype html>
<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="<?php echo of_get_option( 'nav_bg_color' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<a class="sr-only sr-only-focusable" href="#content">Skip to main content</a>
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<nav class="navbar navbar-default <?php if( of_get_option( 'sticky_header' ) ) echo 'navbar-fixed-top'; ?>" role="navigation">
			<div class="container">
				<div class="row">
					<div class="site-navigation-inner col-sm-12">
						<div class="navbar-header">
							<?php _rhd_the_custom_logo(); ?>
							<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>




						</div>
						<div id="navbar" class="collapse navbar-collapse navbar-ex1-collapse pull-right">
							<?php _rhd_header_menu(); // main navigation ?>
							<?php _rhd_header_rs(); // main navigation ?>
						</div>
					</div>
				</div>
			</div>
		</nav><!-- .site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">

		<div class="top-section">
			<?php _rhd_featured_slider(); ?>
			<?php _rhd_call_for_action(); ?>
		</div>

		<?php if ( is_page_template( 'templates/tmp-about.php') || is_page_template( 'templates/tmp-home.php') ): ?>
			<div class="main-content-area">
		<?php else : ?>
			<div class="container main-content-area">
		<?php endif; ?>

      <?php $layout_class = get_layout_class(); ?>
			<div class="row <?php echo $layout_class; ?>">

				<?php if ( is_page_template( 'templates/tmp-about.php' ) ): ?>
					<div class="container">
						<div class="col-xs-12 fil_ariane">
						<?php
							if(function_exists('fil_ariane')){
								echo fil_ariane();
							}
						?>
						</div>
					</div>
				<?php elseif ( is_page_template( 'templates/tmp-home.php') ) : ?>
					<div class="container">
				<?php else : ?>
						<div class="fil_ariane">
						<?php
							if(function_exists('fil_ariane')){
								echo fil_ariane();
							}
						?>
						</div>
				<?php endif; ?>

				<?php if ( is_archive()) : ?>
				<header class="col-xs-12 col-md-8 page-header">
			    <?php
			      the_archive_title( '<h1 class="page-title">', '</h1>' );
			      the_archive_description( '<div class="archive-description">', '</div>' );
			    ?>
			  </header><!-- .page-header -->
				<?php
				endif;
				?>

				<?php if ( is_singular( 'post' ) || is_archive() || is_home() || is_search() ): ?>
					<div class="main-content-inner <?php echo _rhd_main_content_bootstrap_classes(); ?>">
				<?php endif; ?>
