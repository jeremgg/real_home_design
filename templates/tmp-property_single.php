<?php
/**
 * Template Name: property single
*/
?>

<?php get_header(); ?>

<div class="main-content-inner col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="property-single">
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

								<div class="section-content row">
									<?php
										// Contrôler si ACF est actif
										if ( !function_exists('get_field') ) return;
									?>

									<?php $propriete = new WP_Query(array(
										'post_type' => 'gallery',
										'showposts' => 1,
										'orderby' => 'ID',
										'order' => 'ASC'
									)); ?>

									<div class="col-xs-12 col-sm-8 property-image">
										<?php while ($propriete->have_posts()) : $propriete->the_post(); ?>
											<?php the_post_thumbnail('_rhd-featured', ['class' => 'img-responsive']); ?>
										<?php endwhile; // end of the loop. ?>
										<?php wp_reset_query(); ?>


										<?php get_sidebar('property'); ?>



										<ul class="pager">
				              <li class="previous">
												<?php previous_post_link('%link', 'Previous object'); ?>
											</li>
				              <li class="next">
												<?php next_post_link('%link', 'Next object'); ?>
											</li>
				            </ul>


										<div class="related-property row">
											<h2 class="section-title">Related post</h2>
											<div class="property-list row">

												<?php
													//setup new WP_Query
													$wp_query = new WP_Query(
														array(
															'posts_per_page'	=>	-1,
															'post_type'			=>	'gallery',
															'nopaging'  => false,
															'posts_per_page'  => '3',
															'order'  => 'ASC',
														)
													);

													//begine loop
													while ($wp_query->have_posts()) : $wp_query->the_post();
													?>
														<div class="element col-xs-12 col-sm-4">
															<a class="thumbs" href="<?php the_permalink(); ?>">
																<?php the_post_thumbnail('album-grid'); ?>
															</a>
															<a class="inverse element-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
															<p class="element-place"><?php the_field('lieu'); ?></p>
														</div><!--end element-->

													<?php endwhile; // end of the loop. ?>
													<?php wp_reset_query(); ?>

											</div>
										</div><!-- ./related-property -->

										<?php comments_template(); ?>
									</div>


									<?php get_sidebar('property-2'); ?>



								</div>




							</article><!-- #post-## -->

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
