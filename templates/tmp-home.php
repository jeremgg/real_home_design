<?php
/**
 * Template Name: home
*/
?>


<?php get_header(); ?>

<div class="main-content-inner col-lg-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="intro">
				<div class="container">
					<div class="section-inner-content row">
						<!-- Carousel -->
						<div id="carousel-intro" class="carousel slide" data-ride="carousel">
							<?php
								$propertySlider = new WP_Query(array(
									'post_type' => 'gallery',
									'showposts' => 4,
									'orderby' => 'ID',
									'order' => 'ASC'
								));
							?>

							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php if(have_posts()) : while ($propertySlider->have_posts()) : $propertySlider->the_post(); ?>
									<li <?php if($propertySlider->current_post == 0) : ?>class="active<?php endif; ?>" data-slide-to="<?php echo $propertySlider->current_post; ?>" data-target="#carousel-intro"></li>
								<?php endwhile; endif; ?>
							</ol>

							<?php rewind_posts(); ?>

							<div class="carousel-inner" role="listbox">
								<?php if(have_posts()) : while ($propertySlider->have_posts()) : $propertySlider->the_post(); ?>

									<?php
										$image_id = get_post_thumbnail_id();
										$image_url = wp_get_attachment_image_src($image_id, 'large', true);
										$image_alt_tag = get_post_meta($image_id, '_wp_attachment_image_alt', true);
									?>

									<div class="item <?php if($propertySlider->current_post == 0) : ?>active<?php endif; ?>">
										<?php //the_post_thumbnail(); ?>
										<img src="<?php echo $image_url[0]; ?>" alt="<?php echo $image_alt_tag; ?>">

										<div class="container">
											<div class="carousel-caption">
												<h2 class="slide-title"><?php the_title(); ?></h2>
												<p class="price"><?php the_field('prix'); ?> €</p>
												<a href="<?php the_permalink(); ?>" class="btn btn-primary">more info</a>
											</div>
										</div>
									</div>

								<?php endwhile; ?>
								<?php endif; ?>
								<?php wp_reset_query(); ?>
							</div>
						</div><!-- /.carousel -->
					</div>
				</div><!-- ./container-->
			</section>

			<section id="offer">
				<div class="container">
						<div class="section-inner-content row">
							<div class="offer-title col-xs-12 col-sm-4">
								<h2 class="section-title"><?php the_title(); ?></h2>
							</div>
							<div class="offer-content col-xs-12 col-sm-8">
								<?php the_content(); ?>
							</div>
						</div>
				</div>
			</section>


			<section id="skills">
				<div class="container">
						<div class="section-inner-content row">
						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<?php $skillsList = new WP_Query(array(
							'post_type' => 'skills',
							'showposts' => 4,
							'orderby' => 'ID',
							'order' => 'ASC'
						)); ?>

						<?php while ($skillsList->have_posts()) : $skillsList->the_post(); ?>
							<div class="skills-single col-xs-12 col-sm-3 col-lg-3">
								<?php the_field('icon'); ?>
								<h3 class="skills-title"><?php the_title(); ?></h3>
								<div class="section-content"><?php the_content(); ?></div>
							</div>
						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
				</div>
			</section>


			<section id="property">
				<div class="container">
					<div class="section-inner-content row">
						<div class="section-top row">
							<header class="col-xs-12 section-header page-header">
								<h2 class="entry-title">Featured Properties</h2>
								<p class="col-xs-12 col-sm-6 col-lg-6"><?php the_field('intro_property'); ?></p>
							</header><!-- .entry-header -->
						</div>

						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<div class="section-content row">
							<div class="col-lg-12 entry-content content">
								<div class="gallery-box row">

									<?php
										//setup new WP_Query
										$propertyList = new WP_Query(
											array(
												// 'posts_per_page'	=>	-1,
												'post_type'	=>	'gallery',
												'nopaging'  => false,
												'posts_per_page'  => '6',
												'orderby' => 'ID',
												'order' => 'DESC'
											)
										);

										//begine loop
										while ($propertyList->have_posts()) : $propertyList->the_post();
									?>

									<div class="element col-xs-12 col-sm-4">
										<?php $image = get_field('image'); if (!empty($image)): ?>
											<a class="thumbs" href="<?php the_permalink(); ?>">
												<img src="<?php echo $image['url']; ?>" class="attachment-album-grid size-album-grid wp-post-image" width="450" height="297">
											</a>
										<?php endif; ?>

										<!-- <a class="thumbs" href="<?php //the_permalink(); ?>">
											<?php //the_post_thumbnail('album-grid'); ?>
									   </a> -->



											<a class="inverse element-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											<p class="element-place"><?php the_field('lieu'); ?></p>
											<h4 class="element-price"><?php the_field('prix'); ?> €</h4>
											<div class="element-room">
												<ul>
													<li><p><?php the_field('adresse'); ?></p></li>
													<li><p><?php the_field('nombre_de_chambres'); ?> Bedrooms</p></li>
													<li><p><?php the_field('nombre_de_salles_de_bains'); ?> bathroom</p></li>
												</ul>
											</div>
										</div><!--end element-->

								<?php endwhile; // end of the loop. ?>
								<?php wp_reset_query(); ?>

							</div><!--end photogallery-->
							</div>
						</div>

						<?php $linkProperty = new WP_Query(array(
							'post_type' => 'page',
							'page_id' => '31'
						));  ?>

						<?php if ($linkProperty->have_posts()) : $linkProperty->the_post(); ?>
							<a href="<?php the_permalink(); ?>" class="btn btn-primary">all property</a>
						<?php endif; ?>
						<?php wp_reset_query(); ?>
					</div>
				</div>
			</section>


			<section id="team">
				<div class="container">
					<div class="section-inner-content row">
						<header class="col-xs-12 section-header page-header">
							<h2 class="entry-title">Our agents</h2>
						</header><!-- .entry-header -->

						<!-- Carousel -->
						<div id="carousel-team" class="carousel slide" data-ride="carousel">
							<?php
								$teamSlider = new WP_Query(array(
									'post_type' => 'team',
									'showposts' => 10,
									'orderby' => 'ID',
									'order' => 'ASC'
								));
							?>

							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php if(have_posts()) : while ($teamSlider->have_posts()) : $teamSlider->the_post(); ?>
									<li <?php if($teamSlider->current_post == 0) : ?>class="active<?php endif; ?>" data-slide-to="<?php echo $teamSlider->current_post; ?>" data-target="#carousel-team"></li>
								<?php endwhile; endif; ?>
							</ol>

							<?php rewind_posts(); ?>

							<div class="carousel-inner" role="listbox">
								<?php if(have_posts()) : while ($teamSlider->have_posts()) : $teamSlider->the_post(); ?>
									<div class="item <?php if($teamSlider->current_post == 0) : ?>active<?php endif; ?>">
										<div class="container">
											<div class="thumbs col-xs-12 col-sm-4">
												<?php $image = get_field('photo_home');
													if (!empty($image)): ?>
														<img class="img-responsive" src="<?php echo $image['url']; ?>">
														<?php endif; ?>
													</div>

													<div class="carousel-caption col-xs-12 col-sm-8">
														<div class="content-caption">
															<header class="col-xs-12 section-header page-header">
																<h2 class="entry-title">Our agents</h2>
															</header><!-- .entry-header -->

															<h3 class="team-name"><?php the_title(); ?></h3>
															<p><?php the_content(); ?></p>
															<p class="fa fa-phone phone"><?php the_field('phone'); ?></p>
															<i class="fa fa-envelope"></i><a href="mailto:<?php the_field('mail'); ?>"><?php the_field('mail'); ?></a>
														</div>
													</div>
												</div>
											</div>

										<?php endwhile; ?>
										<?php endif; ?>

										<?php wp_reset_query(); ?>
									</div>
								</div><!-- /.carousel -->
							</div>
						</div><!-- ./container-->
					</section>

					<section id="more-about">
						<div class="container">
					<div class="section-inner-content row">
						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<?php $linkAbout = new WP_Query(array(
							'post_type' => 'page',
							'page_id' => '29'
						));  ?>

						<div class="section-title col-xs-8 col-sm-9">
							<h2 class="entry-title">Get Started on Buying Your New Home</h2>
						</div>

						<div class="section-btn col-xs-4 col-sm-3">
							<?php if ($linkAbout->have_posts()) : $linkAbout->the_post(); ?>
								<a href="<?php the_permalink(); ?>" class="btn btn-primary pull-right">more about us</a>
							<?php endif; ?>
							<?php wp_reset_query(); ?>
						</div>
					</div>
				</div>
			</section>


			<section id="testimonials">
				<div class="container">
						<div class="section-inner-content row">
							<header class="section-header page-header">
								<h2 class="entry-title">Testimonials</h2>
							</header><!-- .entry-header -->

						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<div id="carousel-testimonials" class="carousel slide" data-ride="carousel">
							<?php
								$testimonialSlider = new WP_Query(array(
									'post_type' => 'testimonials',
									'showposts' => 10,
									'orderby' => 'ID',
									'order' => 'ASC'
								));
							?>

							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php if(have_posts()) : while ($testimonialSlider->have_posts()) : $testimonialSlider->the_post(); ?>
									<li <?php if($testimonialSlider->current_post == 0) : ?>class="active<?php endif; ?>" data-slide-to="<?php echo $testimonialSlider->current_post; ?>" data-target="#carousel-testimonials"></li>
								<?php endwhile; endif; ?>
							</ol>

							<?php rewind_posts(); ?>

							<div class="carousel-inner" role="listbox">
								<?php if(have_posts()) : while ($testimonialSlider->have_posts()) : $testimonialSlider->the_post(); ?>

									<div class="item <?php if($testimonialSlider->current_post == 0) : ?>active<?php endif; ?>">
										<div class="container">
											<div class="carousel-caption">
												<p><?php the_excerpt(); ?></p>
												<p class="testimonials-author"><?php the_title(); ?></p>
											</div>
										</div>
									</div>

								<?php
									endwhile;
									endif;
								 ?>

							</div>
							<a class="left carousel-control" href="#carousel-testimonials" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#carousel-testimonials" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div><!-- /.carousel -->

					</div>
				</div>
			</section>


			<section id="partenairs">
				<div class="container">
						<div class="section-inner-content row">
							<div class="section-title col-xs-12 col-md-3">
								<h3 class="entry-title">Our Partners</h3>
							</div>

							<div class="partenairs-list col-xs-12 col-md-9">
								<?php
									// Contrôler si ACF est actif
									if ( !function_exists('get_field') ) return;
								?>

								<?php $partenairsList = new WP_Query(array(
									'post_type' => 'partenaires',
									'showposts' => 4,
									'orderby' => 'ID',
									'order' => 'ASC'
								)); ?>

								<?php while ($partenairsList->have_posts()) : $partenairsList->the_post(); ?>
										<div class="partenairs-single col-xs-12 col-md-3">
											<?php the_post_thumbnail('_rhd-featured', ['class' => 'img-responsive']); ?>
										</div>
								<?php endwhile; // end of the loop. ?>
								<?php wp_reset_query(); ?>
							</div>
					</div>
				</div>
			</section>
			<?php wp_reset_query(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
