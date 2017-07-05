<?php
/**
 * Template Name: testimonials
*/
?>

<?php get_header(); ?>

<div class="main-content-inner col-xs-12 col-lg-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="testimonial">
					<div class="section-inner-content row">
						<?php while ( have_posts() ) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="section-top">
									<header class="col-xs-12 section-header page-header">
										<h1 class="entry-title"><?php the_title(); ?></h1>
									</header><!-- .entry-header -->

									<?php if ( get_edit_post_link() ) : ?>
										<div class="section-footer pull-right">
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
										</div><!-- .entry-footer -->
									<?php endif; ?>
								</div>

								<div class="section-content col-xs-12 col-lg-8">
									<?php
										// Contrôler si ACF est actif
										if ( !function_exists('get_field') ) return;
									?>

									<?php $testimonial = new WP_Query(array(
										'post_type' => 'testimonials',
										'showposts' => 4,
										'orderby' => 'ID',
										'order' => 'ASC'
									)); ?>

									<?php while ($testimonial->have_posts()) : $testimonial->the_post(); ?>
										<div class="testimonial-single well row">
											<div class="col-xs-2 col-lg-2 author-thumbnail">
												<?php the_post_thumbnail('_rhd-featured', ['class' => 'img-responsive']); ?>
											</div>

											<div class="col-xs-10 col-lg-10 entry-content">
												<?php the_content(); ?>

												<p class="author">
													<span><?php the_title(); ?></span>, <?php the_field('metier'); ?>
												</p>

												<a href="<?php the_field('site_web'); ?>"><?php the_field('site_web'); ?></a>
											</div>
										</div>
									<?php endwhile; // end of the loop. ?>
									<?php wp_reset_query(); ?>

									<?php get_sidebar(); ?>
								</div>
							</article><!-- #post-## -->

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
			</section>



		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
