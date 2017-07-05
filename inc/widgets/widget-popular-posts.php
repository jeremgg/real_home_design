<?php

/**
 * rhd Top Posts Widget
 * rhd Theme
 */


class rhd_popular_posts extends WP_Widget
{
	 function __construct(){

        $widget_ops = array('classname' => 'rhd-popular-posts','description' => esc_html__( "rhd Popular Posts Widget", 'rhd') );
		    parent::__construct('rhd_popular_posts', esc_html__('rhd Popular Posts Widget','rhd'), $widget_ops);
    }

    function widget($args , $instance) {
    	extract($args);
        $title = isset($instance['title']) ? $instance['title'] : esc_html__('Popular Posts', 'rhd');
        $limit = isset($instance['limit']) ? $instance['limit'] : 5;

      echo $before_widget;
      echo $before_title;
      echo $title;
      echo $after_title;

		/**
		 * Widget Content
		 */
    ?>

    <!-- popular posts -->
          <div class="popular-posts-wrapper">

                <?php

                  $featured_args = array(
                      'posts_per_page' => $limit,
                      'orderby' => 'ID',
                      'order' => 'DESC',
                      'ignore_sticky_posts' => 1
                    );

                  $featured_query = new WP_Query($featured_args);

                  /**
                   * Check if zilla likes plugin exists
                   */
                  if($featured_query->have_posts()) : while($featured_query->have_posts()) : $featured_query->the_post();

                    ?>

                        <?php if(get_the_content() != '') : ?>

                        <!-- post -->
                        <div class="post">

                          <!-- content -->
                          <div class="post-content">

                              <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                              <?php the_excerpt(); ?>
							  <span class="post-date"><?php echo get_the_date('d M , Y'); ?></span>


                          </div><!-- end content -->
                        </div><!-- end post -->

                        <?php endif; ?>

                    <?php

                  endwhile; endif; wp_reset_query();

                 ?>

          </div> <!-- end posts wrapper -->

		<?php

		echo $after_widget;
    }


    function form($instance) {

      if(!isset($instance['title'])) $instance['title'] = esc_html__('Popular Posts', 'rhd');
      if(!isset($instance['limit'])) $instance['limit'] = 5;

    	?>

      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'rhd') ?></label>

      <input  type="text" value="<?php echo esc_attr($instance['title']); ?>"
              name="<?php echo $this->get_field_name('title'); ?>"
              id="<?php $this->get_field_id('title'); ?>"
              class="widefat" />
      </p>

      <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php esc_html_e('Limit Posts Number', 'rhd') ?></label>

      <input  type="text" value="<?php echo esc_attr($instance['limit']); ?>"
              name="<?php echo $this->get_field_name('limit'); ?>"
              id="<?php $this->get_field_id('limit'); ?>"
              class="widefat" />
      <p>

    	<?php
    }
}
?>
