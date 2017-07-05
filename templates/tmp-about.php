<?php
/**
 * Template Name: about
*/
?>


<?php get_header(); ?>

<div class="main-content-inner col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="about">
				<div class="container">
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
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 entry-content-thumbnail">
										<?php the_post_thumbnail('_rhd-featured', ['class' => 'img-responsive']); ?>
									</div>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 entry-content">
										<?php the_content(); ?>
									</div>
								</div>
							</article><!-- #post-## -->

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
				</div><!-- ./container-->
			</section>

			<section id="skills">
				<div class="container">
						<div class="section-inner-content row">
						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<?php $skills = new WP_Query(array(
							'post_type' => 'skills',
							'showposts' => 4,
							'orderby' => 'ID',
							'order' => 'ASC'
						)); ?>

						<?php while ($skills->have_posts()) : $skills->the_post(); ?>
							<div class="skills-single col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<?php the_field('icon'); ?>
								<h3 class="skills-title"><?php the_title(); ?></h3>
								<div class="section-content"><?php the_content(); ?></div>
							</div>
						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
				</div>
			</section>

			<section id="team">
				<div class="container">
					<div class="section-inner-content row">
						<div class="section-top">
							<header class="col-xs-12 section-header page-header">
								<h2 class="section-title">Our Team</h2>
							</header><!-- .entry-header -->

							<div class="entry-footer pull-right">
								<a href="#">Want to be a part of this team?</a>
							</div>
						</div>
						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<?php $team = new WP_Query(array(
							'post_type' => 'team',
							'showposts' => 4,
							'orderby' => 'ID',
							'order' => 'ASC'
						)); ?>

						<?php while ($team->have_posts()) : $team->the_post(); ?>
							<div class="team-single col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<div class="entry-content-thumbnail">
									<?php the_post_thumbnail('_rhd-featured', ['class' => 'img-responsive']); ?>
								</div>

								<div class="section-title">
									<h3><?php the_title(); ?></h3>
								</div>

								<div class="section-content">
									<p><?php the_field('job'); ?></p>
								</div>
							</div>
						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
				</div>
			</section>

			<section id="newsletters">
				<div class="container">
					<div class="section-inner-content row">
						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<?php $page = new WP_Query(array(
							'post_type' => 'page'
						));  ?>

						<div class="section-title col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<h2><?php the_field('titre_newsletters'); ?></h2>
						</div>

						<div class="form_newsletter col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<?php the_field('newsletters'); ?>
						</div>
					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
