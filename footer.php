<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package _rhd
 */
?>
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .site-content -->

	<div id="footer-area">
		<div class="container footer-inner">
			<div class="row">
				<?php get_sidebar( 'footer' ); ?>
			</div>
		</div>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info container">
				<div class="row">
					<div class="footer-social col-xs-12 col-sm-3">
						<!-- <?php _rhd_the_custom_logo(); ?> -->
						<a href="<?php bloginfo( 'url' ); ?>">
							<img src="<?php bloginfo('template_directory'); ?>/assets/images/logo-inverse.png" />
						</a>
						<?php _rhd_header_rs(); ?>
					</div>

					<div class="footer-navigation col-xs-12 col-sm-3">
						<h3 class="title-footer">Navigation</h3>
						<?php _rhd_footer_links(); ?>
					</div>

					<div class="clients col-xs-12 col-sm-3">
						<h3 class="title-footer">Last posts</h3>
						<ul class="nav footer-nav clearfix">
							<?php $posts = new WP_Query(array(
								'post_type' => 'post',
								'showposts' => 5,
								'orderby' => 'ID',
							)); ?>

							<?php while ($posts->have_posts()) : $posts->the_post(); ?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php endwhile; // end of the loop. ?>
							<?php wp_reset_query(); ?>
						</ul>
					</div>

					<div class="contacts col-xs-12 col-sm-3">
						<h3 class="title-footer">Contact us</h3>

						<?php
							// Contrôler si ACF est actif
							if ( !function_exists('get_field') ) return;
						?>

						<?php $contact = new WP_Query(array(
							'post_type' => 'page',
							'pagename' => 'contacts'
						)); ?>

						<?php if ($contact->have_posts()) : $contact->the_post(); ?>
							<p class="adresse"><?php the_field('adresse_bis'); ?></p>
							<p class="adresse"><?php the_field('adresse_bis_2'); ?></p>
							<p class="phone">Téléphone : +<?php the_field('telephone'); ?></p>
							<p class="fax">fax : +<?php the_field('fax'); ?></p>
							<a class="mail" href="mailto:<?php the_field('mail'); ?>"><?php the_field('mail'); ?></a>
						<?php endif; // end of the loop. ?>
						<?php wp_reset_query(); ?>
					</div>
				</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
