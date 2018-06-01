<?php
/**
 * Template Name: property
*/
?>

<?php get_header(); ?>

<div class="main-content-inner col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="property">
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
						</article><!-- #post-## -->

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); ?>

						<div class="section-content row">
							<header class="header">
								<div id="options">
									<?php
										//check to see if our custom tag cloud exists and display it
										if( function_exists( 'jss_tag_cloud' )) {
											jss_tag_cloud( $args = '' );
										} else {
											//funny error message. probably need to replace this in your build.
											echo 'Something has gone terribly wrong here!';
										}
									?>
								</div>
							</header><!--end header-->

							<div class="col-lg-12 entry-content">
								<div class="photogal">

									<?php
										//setup new WP_Query
										$wp_query = new WP_Query(
											array(
												'post_type'		  =>	'gallery',
												'posts_per_page'  => '9'
											)
										);

										//begine loop
										while ($wp_query->have_posts()) : $wp_query->the_post();
									?>

									<div class="element<?php if( function_exists('jss_taxonomy_name')){ jss_taxonomy_name(); }?> col-xs-12 col-sm-4">
										<?php $image = get_field('image'); if (!empty($image)): ?>
											<a class="thumbs" href="<?php the_permalink(); ?>">
												<img src="<?php echo $image['url']; ?>" class="attachment-album-grid size-album-grid wp-post-image" width="450" height="297">
											</a>
										<?php endif; ?>

										<!-- <a class="thumbs" href="<?php //the_permalink(); ?>"><?php //the_post_thumbnail('album-grid'); ?></a> -->

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
								   </div><!--end li-->

								<?php endwhile; // end of the loop. ?>
							</div><!--end photogallery-->

							</div><!--end content-->
						</div>
				</div>
		</section>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
