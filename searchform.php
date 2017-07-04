<?php
/**
 * The template for displaying search forms in _rhd
 *
 * @package _rhd
 */
?>

<form role="search" method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="input-group">
  	<label class="screen-reader-text" for="s"><?php _e( 'Search for:', '_rhd' ); ?></label>
    <input type="text" class="form-control search-query" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', '_rhd' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', '_rhd' ); ?>" />
    <span class="input-group-btn">
      <button type="submit" class="btn btn-primary" name="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', '_rhd' ); ?>"><span class="glyphicon glyphicon-search"></span></button>
    </span>
  </div>
</form>
