<?php
/**
 * @package _rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner-content">

		<div class="section-top">
			<header class="col-xs-12 section-header page-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->
		</div>

		<div class="entry-content">
			<?php the_content(); ?>

			<div class="entry-meta">
				<?php _rhd_posted_on(); ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( esc_html__( ', ', '_rhd' ) );
					if ( $categories_list && _rhd_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( esc_html__( 'IN %1$s', '_rhd' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>

				<a href="<?php the_permalink(); ?>" class="permalink">permalink</a>

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
			<?php
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

		<footer class="entry-meta">

	    	<?php if(has_tag()) : ?>
	      <!-- tags -->
	      <div class="tagcloud">

	          <?php
	              $tags = get_the_tags(get_the_ID());
	              foreach($tags as $tag){
	                  echo '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a> ';
	              } ?>

	      </div>
	      <!-- end tags -->
	      <?php endif; ?>

		</footer><!-- .entry-meta -->
	</div>



</article><!-- #post-## -->



<?php if (get_the_author_meta('description')) :  ?>
	<div class="post-inner-content well blog-author">
		<!-- author bio -->
		<div class="author-bio row">

			<!-- avatar -->
			<div class="avatar col-xs-2 col-lg-2">
					<?php echo get_avatar(get_the_author_meta('ID') , '60'); ?>
			</div>
			<!-- end avatar -->

			<!-- user bio -->
			<div class="author-bio-content col-xs-10 col-lg-10">

				<h3 class="author-name"><?php _e( 'Written by ', '_rhd' ); ?><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="inverse"><?php echo get_the_author_meta('display_name'); ?></a></h3>
				<p class="author-description">
						<?php echo get_the_author_meta('description'); ?>
				</p>
				<h4 class="author-name"><?php _e( 'View all posts by : ', '_rhd' ); ?><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_the_author_meta('display_name'); ?></a></h4>

			</div><!-- end .author-bio-content -->

		</div><!-- end .author-bio  -->

	</div>
	<?php endif; ?>
