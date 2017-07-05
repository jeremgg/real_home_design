<?php
/**
 * Template Name: contact
*/
?>


<?php get_header(); ?>

<div class="main-content-inner col-md-12 col-lg-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="map-contact">
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

							<div class="section-content map row">
								<?php
									// Contrôler si ACF est actif
									if ( !function_exists('get_field') ) return;
								?>

										<?php the_field('google_map'); ?>
								<?php wp_reset_query(); ?>
							</div>
						</article><!-- #post-## -->

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
			</section>


			<section id="contact">
				<div class="section-inner-content row">
					<div class="contact-info col-sm-4 col-md-4 col-lg-4">
						<div class="section-top">
							<header class="col-xs-12 section-header page-header">
								<h2 class="section-title">contact info</h2>
							</header><!-- .entry-header -->
						</div>
						<div class="section-content">
							<?php the_content(); ?>

							<?php
								// Contrôler si ACF est actif
								if ( !function_exists('get_field') ) return;
							?>

							<div class="adresse">
								<h4><?php the_field('adresse'); ?></h4>
								<h4><?php the_field('adresse_bis'); ?></h4>
								<h4><?php the_field('adresse_bis_2'); ?></h4>
							</div>

							<div class="coordonnees">
								<p>Telephone : <span>+<?php the_field('telephone'); ?></span></p>
								<p>Fax : <span>+<?php the_field('fax'); ?></span></p>
								<p>E-mail : <a href="mailto:<?php the_field('mail'); ?>"><span><?php the_field('mail'); ?></span></a></p>
							</div>
						</div>
					</div>

					<div class="contact-form col-sm-8 col-md-8 col-lg-8">
						<div class="section-top">
							<header class="col-xs-12 section-header page-header">
								<h2 class="section-title">leave a comment</h2>
							</header><!-- .entry-header -->
						</div>
						<div class="section-content">
							<?php the_field('formulaire'); ?>
						</div>

				</div>
			</section>





		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
