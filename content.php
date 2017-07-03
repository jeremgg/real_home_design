<?php
/**
 * @package _rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-item-wrap">
		<div class="post-inner-content">

			<div class="section-top">
				<header class="col-xs-12 section-header page-header">
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark" class="inverse"><?php the_title(); ?></a>
					</h1>
				</header><!-- .entry-header -->

				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="section-footer pull-right">

				<?php if ( get_edit_post_link() ) : ?>
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
				<?php endif; ?>

				</div><!-- .entry-meta -->
				<?php endif; ?>
			</div>

			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail( '_rhd-featured', array( 'class' => 'single-featured' )); ?>
				</a>
			</div>

			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">
				<?php
					the_excerpt();



					wp_link_pages( array(
						'before'            => '<div class="page-links">'.esc_html__( 'Pages:', '_rhd' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1
		       		) );
		    	?>

			</div><!-- .entry-content -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-## -->
