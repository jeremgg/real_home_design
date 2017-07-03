<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package _rhd
 */

get_header(); ?>

<div class="main-content-inner col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="post-inner-content">

				<section class="error-404 not-found">
					<div class="section-top">
						<header class="col-xs-12 section-header page-header">
							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', '_rhd' ); ?></h1>
						</header><!-- .entry-header -->
					</div>

					<div class="section-content row">
						<?php _rhd_the_custom_logo(); ?>
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', '_rhd' ); ?></p>

						<?php get_search_form(); ?>


				</section><!-- .error-404 -->
			</div>
		</main><!-- #main -->
	</div>
</div>

<?php get_footer(); ?>
