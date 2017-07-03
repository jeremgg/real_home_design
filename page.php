<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package _rhd
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section id="about">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_post_thumbnail( '_rhd-featured', array( 'class' => 'single-featured' )); ?>

					<div class="post-inner-content">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header page-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php
								the_content();
								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_rhd' ),
									'after'  => '</div>',
								) );
							?>

					    <?php
					      // Checks if this is homepage to enable homepage widgets
					      if ( is_front_page() ) :
					        get_sidebar( 'home' );
					      endif;
					    ?>
						</div><!-- .entry-content -->

						<?php if ( get_edit_post_link() ) : ?>
							<footer class="entry-footer">
								<?php
									edit_post_link(
										sprintf(
											/* translators: %s: Name of current post */
											esc_html__( 'Edit %s', '_rhd' ),
											the_title( '<span class="screen-reader-text">"', '"</span>', false )
										),
										'<i class="fa fa-pencil-square-o"></i><span class="edit-link">',
										'</span>'
									);
								?>
							</footer><!-- .entry-footer -->
						<?php endif; ?>
					</article><!-- #post-## -->
					</div>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( get_theme_mod( '_rhd_page_comments', 1 ) == 1 ) :
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						endif;
					?>

				<?php endwhile; // end of the loop. ?>
			</section>

			<section id="skills">

			</section>

			<section id="team">

			</section>





		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
