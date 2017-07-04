<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package _rhd
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="post-inner-content">
				<section class="results">

					<?php
					if ( have_posts() ) : ?>

					<div class="section-top">
						<header class="col-xs-12 section-header page-header">
							<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', '_rhd' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header><!-- .page-header -->
					</div>

					<div class="section-content row">
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'content', 'search' );

						endwhile;

						echo custom_pagination();

					else :

						get_template_part( 'content', 'none' );

					endif; ?>
				</div>

			</section>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
