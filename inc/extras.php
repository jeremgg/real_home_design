<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package _rhd
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function _rhd_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', '_rhd_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _rhd_body_classes( $classes ) {
  // Adds a class of group-blog to blogs with more than 1 published author.
  if ( is_multi_author() ) {
    $classes[] = 'group-blog';
  }

  return $classes;
}
add_filter( 'body_class', '_rhd_body_classes' );


// Mark Posts/Pages as Untiled when no title is used
add_filter( 'the_title', '_rhd_title' );

function _rhd_title( $title ) {
  if ( $title == '' ) {
    return 'Untitled';
  } else {
    return $title;
  }
}

/**
 * Password protected post form using Boostrap classes
 */
add_filter( 'the_password_form', 'custom_password_form' );

function custom_password_form() {
  global $post;
  $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
  $o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
  <div class="row">
    <div class="col-lg-10">
        <p>' . esc_html__( "This post is password protected. To view it please enter your password below:" ,'_rhd') . '</p>
        <label for="' . $label . '">' . esc_html__( "Password:" ,'_rhd') . ' </label>
      <div class="input-group">
        <input class="form-control" value="' . get_search_query() . '" name="post_password" id="' . $label . '" type="password">
        <span class="input-group-btn"><button type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="' . esc_attr__( "Submit",'_rhd' ) . '">' . esc_html__( "Submit" ,'_rhd') . '</button>
        </span>
      </div>
    </div>
  </div>
</form>';
  return $o;
}

// Add Bootstrap classes for table
add_filter( 'the_content', '_rhd_add_custom_table_class' );
function _rhd_add_custom_table_class( $content ) {
  return preg_replace( '/(<table) ?(([^>]*)class="([^"]*)")?/', '$1 $3 class="$4 table table-hover" ', $content);
}


if ( ! function_exists( '_rhd_social_icons' ) ) :

/**
 * Display social links in footer and widgets
 *
 * @package _rhd
 */
function _rhd_social_icons(){
  if ( has_nav_menu( 'social-menu' ) ) {
  	wp_nav_menu(
  		array(
  			'theme_location'  => 'social-menu',
  			'container'       => 'nav',
  			'container_id'    => 'menu-social',
  			'container_class' => 'social-icons',
  			'menu_id'         => 'menu-social-items',
  			'menu_class'      => 'social-menu',
  			'depth'           => 1,
  			'fallback_cb'     => '',
        'link_before'     => '<i class="social_icon fa"><span>',
        'link_after'      => '</span></i>'
  		)
	  );
  }
}
endif;

//-----------------
//-- HEADER NAV
//-----------------
if ( ! function_exists( '_rhd_header_menu' ) ) :
  //-- Header menu (should you choose to use one)
    function _rhd_header_menu() {
      wp_nav_menu(array(
        'menu'              => 'primary',
        'theme_location'    => 'primary',
        'depth'             => 2,
        'container'         => 'div',
        'container_class'   => 'navigation',
        'menu_class'        => 'nav navbar-nav',
        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
        'walker'            => new wp_bootstrap_navwalker()
      ));
    }

    //-- Header social links (should you choose to use one)
      function _rhd_header_rs() {
        wp_nav_menu(array(
          'menu'              => 'social-media',
          'theme_location'    => 'social-media',
          'depth'             => 2,
          'container'         => 'div',
          'container_class'   => 'rs',
          'menu_class'        => 'nav navbar-nav rs',
          'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
          'walker'            => new wp_bootstrap_navwalker()
        ));
      }
endif;

//-----------------


if ( ! function_exists( '_rhd_footer_links' ) ) :
/**
 * Footer menu (should you choose to use one)
 */
function _rhd_footer_links() {
  // display the WordPress Custom Menu if available
  wp_nav_menu(array(
    'container'       => '',                              // remove nav container
    'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    'menu'            => esc_html__( 'Footer Links', '_rhd' ),   // nav name
    'menu_class'      => 'nav footer-nav clearfix',      // adding custom nav class
    'theme_location'  => 'footer-links',             // where it's located in the theme
    'before'          => '',                                 // before the menu
    'after'           => '',                                  // after the menu
    'link_before'     => '',                            // before each link
    'link_after'      => '',                             // after each link
    'depth'           => 0,                                   // limit the depth of the nav
    'fallback_cb'     => '_rhd_footer_links_fallback'  // fallback function
  ));
} /* end _rhd footer link */
endif;


if ( ! function_exists( '_rhd_call_for_action' ) ) :
/**
 * Call for action text and button displayed above content
 */
function _rhd_call_for_action() {
  if ( is_front_page() && of_get_option( 'w2f_cfa_text' )!=''){
    echo '<div class="cfa">';
      echo '<div class="container">';
        echo '<div class="col-sm-8">';
          echo '<span class="cfa-text">'. of_get_option( 'w2f_cfa_text' ).'</span>';
          echo '</div>';
          echo '<div class="col-sm-4">';
          echo '<a class="btn btn-lg cfa-button" href="'. of_get_option( 'w2f_cfa_link' ). '">'. of_get_option( 'w2f_cfa_button' ). '</a>';
          echo '</div>';
      echo '</div>';
    echo '</div>';
  }
}
endif;

if ( ! function_exists( '_rhd_featured_slider' ) ) :
/**
 * Featured image slider, displayed on front page for static page and blog
 */
function _rhd_featured_slider() {
  if ( is_front_page() && of_get_option( '_rhd_slider_checkbox' ) == 1 ) {
    echo '<div class="flexslider">';
      echo '<ul class="slides">';

        $count = of_get_option( '_rhd_slide_number' );
        $slidecat =of_get_option( '_rhd_slide_categories' );

        $query = new WP_Query( array( 'cat' =>$slidecat,'posts_per_page' =>$count ) );
        if ($query->have_posts()) :
          while ($query->have_posts()) : $query->the_post();

          echo '<li><a href="'. get_permalink() .'">';
            if ( (function_exists( 'has_post_thumbnail' )) && ( has_post_thumbnail() ) ) :
              echo get_the_post_thumbnail();
            endif;

              echo '<div class="flex-caption">';
                  if ( get_the_title() != '' ) echo '<h2 class="entry-title">'. get_the_title().'</h2>';
                  if ( get_the_excerpt() != '' ) echo '<div class="excerpt">' . get_the_excerpt() .'</div>';
              echo '</div>';
              echo '</a></li>';
              endwhile;
            endif;

      echo '</ul>';
    echo ' </div>';
  }
}
endif;

/**
 * function to show the footer info, copyright information
 */
function _rhd_footer_info() {
global $_rhd_footer_info;
  printf( esc_html__( 'Theme by %1$s Powered by %2$s', '_rhd' ) , '<a href="http://colorlib.com/" target="_blank">Colorlib</a>', '<a href="http://wordpress.org/" target="_blank">WordPress</a>');
}


if ( ! function_exists( 'get__rhd_theme_options' ) ) {
/**
 * Get information from Theme Options and add it into wp_head
 */
    function get__rhd_theme_options(){

      echo '<style type="text/css">';

      if ( of_get_option('link_color')) {
        echo 'a, #infinite-handle span, #secondary .widget .post-content a {color:' . of_get_option('link_color') . '}';
      }
      if ( of_get_option('link_hover_color')) {
        echo 'a:hover, a:active, #secondary .widget .post-content a:hover,
        .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li span.current  {color: '.of_get_option('link_hover_color').';}';
      }
      if ( of_get_option('element_color')) {
        echo '.btn-default, .label-default, .flex-caption h2, .btn.btn-default.read-more,button,
              .navigation .wp-pagenavi-pagination span.current,.navigation .wp-pagenavi-pagination a:hover,
              .woocommerce a.button, .woocommerce button.button,
              .woocommerce input.button, .woocommerce #respond input#submit.alt,
              .woocommerce a.button, .woocommerce button.button,
              .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { background-color: '.of_get_option('element_color').'; border-color: '.of_get_option('element_color').';}';

        echo '.site-main [class*="navigation"] a, .more-link, .pagination>li>a, .pagination>li>span { color: '.of_get_option('element_color').'}';
      }

      if ( of_get_option('element_color_hover')) {
        echo '.btn-default:hover, .label-default[href]:hover, .tagcloud a:hover,button, .main-content [class*="navigation"] a:hover,.label-default[href]:focus, #infinite-handle span:hover,.btn.btn-default.read-more:hover, .btn-default:hover, .scroll-to-top:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .site-main [class*="navigation"] a:hover, .more-link:hover, #image-navigation .nav-previous a:hover, #image-navigation .nav-next a:hover, .cfa-button:hover,.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover{ background-color: '.of_get_option('element_color_hover').'; border-color: '.of_get_option('element_color_hover').'; }';
      }
      if ( of_get_option('element_color_hover')) {
        echo '.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {color: '.of_get_option('element_color_hover').';}';
      }
      if ( of_get_option('cfa_bg_color')) {
        echo '.cfa { background-color: '.of_get_option('cfa_bg_color').'; } .cfa-button:hover a {color: '.of_get_option('cfa_bg_color').';}';
      }
      if ( of_get_option('cfa_color')) {
        echo '.cfa-text { color: '.of_get_option('cfa_color').';}';
      }
      if ( of_get_option('cfa_btn_color') || of_get_option('cfa_btn_txt_color') ) {
        echo '.cfa-button {border-color: '.of_get_option('cfa_btn_color').'; color: '.of_get_option('cfa_btn_txt_color').';}';
      }
      if ( of_get_option('heading_color')) {
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title {color: '.of_get_option('heading_color').';}';
      }
      if ( of_get_option('nav_bg_color')) {
        echo '.navbar.navbar-default, .navbar-default .navbar-nav .open .dropdown-menu > li > a {background-color: '.of_get_option('nav_bg_color').';}';
      }
      if ( of_get_option('nav_link_color')) {
        echo '.navbar-default .navbar-nav > li > a, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus { color: '.of_get_option('nav_link_color').';}';
      }
      if ( of_get_option('nav_item_hover_color')) {
        echo '.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {color: '.of_get_option('nav_item_hover_color').';}';
      }
      if ( of_get_option('nav_dropdown_bg_hover') || of_get_option('nav_dropdown_item_hover') ) {
        echo '@media (max-width: 767px) {.navbar-default .navbar-nav .open .dropdown-menu>.active>a, .navbar-default .navbar-nav .open .dropdown-menu>.active>a:focus, .navbar-default .navbar-nav .open .dropdown-menu>.active>a:hover {background: '.of_get_option('nav_dropdown_bg_hover').'; color:'.of_get_option('nav_dropdown_item_hover').';} }';
      }
      if ( of_get_option('nav_dropdown_bg')) {
        echo '.dropdown-menu {background-color: '.of_get_option('nav_dropdown_bg').';}';
      }
      if ( of_get_option('nav_dropdown_item')) {
        echo '.navbar-default .navbar-nav .open .dropdown-menu > li > a, .dropdown-menu > li > a { color: '.of_get_option('nav_dropdown_item').';}';
      }
      if ( of_get_option('nav_dropdown_bg_hover') || of_get_option('nav_dropdown_item_hover') ) {
        echo '.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li.active > a {background-color: '.of_get_option('nav_dropdown_bg_hover').'; color:'.of_get_option('nav_dropdown_item_hover').';}';
      }
      if ( of_get_option('nav_dropdown_item_hover') ) {
        echo '.navbar-default .navbar-nav .current-menu-ancestor a.dropdown-toggle { color: '.of_get_option('nav_dropdown_item_hover').';}';
      }
      if ( of_get_option('footer_bg_color')) {
        echo '#colophon {background-color: '.of_get_option('footer_bg_color').';}';
      }
      if ( of_get_option('footer_text_color')) {
        echo '#footer-area, .site-info {color: '.of_get_option('footer_text_color').';}';
      }
      if ( of_get_option('footer_widget_bg_color')) {
        echo '#footer-area {background-color: '.of_get_option('footer_widget_bg_color').';}';
      }
      if ( of_get_option('footer_link_color')) {
        echo '.site-info a, #footer-area a {color: '.of_get_option('footer_link_color').';}';
      }
      if ( of_get_option('social_color')) {
        echo '.social-icons li a {background-color: '.of_get_option('social_color').' !important ;}';
      }
      if ( of_get_option('social_footer_color')) {
        echo '#footer-area .social-icons li a {background-color: '.of_get_option('social_footer_color').' !important ;}';
      }
      global $typography_options;
      $typography = of_get_option('main_body_typography');
      if ( $typography ) {
        echo '.entry-content {font-family: ' . $typography_options['faces'][$typography['face']] . '; font-size:' . $typography['size'] . '; font-weight: ' . $typography['style'] . '; color:'.$typography['color'] . ';}';
      }
      if ( of_get_option('custom_css')) {
        echo html_entity_decode( of_get_option( 'custom_css', 'no entry' ) );
      }
        echo '</style>';
    }
}
add_action( 'wp_head', 'get__rhd_theme_options', 10 );

// Theme Options sidebar
add_action( 'optionsframework_after', '_rhd_options_display_sidebar' );

function _rhd_options_display_sidebar() { ?>
  <!-- Twitter -->
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

  <!-- Facebook -->
    <div id="fb-root"></div>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=328285627269392";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <div id="optionsframework-sidebar" class="metabox-holder">
    <div id="optionsframework" class="postbox">
        <h3><?php esc_html_e('Support and Documentation','_rhd') ?></h3>
        <div class="inside">
          <div id="social-share">
            <div class="fb-like" data-href="<?php echo esc_url( 'https://www.facebook.com/colorlib' ); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="true"></div>
            <div class="tw-follow" ><a href="https://twitter.com/colorlib" class="twitter-follow-button" data-show-count="false">Follow @colorlib</a></div>
          </div>
            <p><b><a href="<?php echo esc_url( 'http://colorlib.com/wp/support/_rhd' ); ?>"><?php esc_html_e('_rhd Documentation','_rhd'); ?></a></b></p>
            <p><?php _e('The best way to contact us with <b>support questions</b> and <b>bug reports</b> is via','_rhd') ?> <a href="<?php echo esc_url( 'http://colorlib.com/wp/forums' ); ?>"><?php esc_html_e('Colorlib support forum','_rhd') ?></a>.</p>
            <p><?php esc_html_e('If you like this theme, I\'d appreciate any of the following:','_rhd') ?></p>
            <ul>
              <li><a class="button" href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/_rhd?filter=5' ); ?>" title="<?php esc_attr_e('Rate this Theme', '_rhd'); ?>" target="_blank"><?php printf(esc_html__('Rate this Theme','_rhd')); ?></a></li>
              <li><a class="button" href="<?php echo esc_url( 'http://www.facebook.com/colorlib' ); ?>" title="Like Colorlib on Facebook" target="_blank"><?php printf(esc_html__('Like on Facebook','_rhd')); ?></a></li>
              <li><a class="button" href="<?php echo esc_url( 'http://twitter.com/colorlib/' ); ?>" title="Follow Colrolib on Twitter" target="_blank"><?php printf(esc_html__('Follow on Twitter','_rhd')); ?></a></li>
            </ul>
        </div>
    </div>
  </div>
<?php }

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function _rhd_caption($output, $attr, $content) {
  if (is_feed()) {
    return $output;
  }

  $defaults = array(
    'id'      => '',
    'align'   => 'alignnone',
    'width'   => '',
    'caption' => ''
  );

  $attr = shortcode_atts($defaults, $attr);

  // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
  if ($attr['width'] < 1 || empty($attr['caption'])) {
    return $content;
  }

  // Set up the attributes for the caption <figure>
  $attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
  $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
  $attributes .= ' style="width: ' . (esc_attr($attr['width']) + 10) . 'px"';

  $output  = '<figure' . $attributes .'>';
  $output .= do_shortcode($content);
  $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
  $output .= '</figure>';

  return $output;
}
add_filter('img_caption_shortcode', '_rhd_caption', 10, 3);

/**
 * Skype URI support for social media icons
 */
function _rhd_allow_skype_protocol( $protocols ){
    $protocols[] = 'skype';
    return $protocols;
}
add_filter( 'kses_allowed_protocols' , '_rhd_allow_skype_protocol' );

/**
 * Fallback option for the old Social Icons.
 */
function _rhd_social(){
  if( of_get_option('footer_social') ) {
    _rhd_social_icons();
  }
}

/**
 * Fallback for removed _rhd_post_nav function
 */
if (!function_exists('_rhd_post_nav')) {
  function _rhd_post_nav() {
    the_post_navigation( array(
      'next_text' 		=> '<span class="post-title">%title <i class="fa fa-chevron-right"></i></span>',
      'prev_text' 		=> '<i class="fa fa-chevron-left"></i> <span class="post-title">%title</span>',
      'in_same_term'  => true,
    ) );
    //
  }
}

/**
 * Fallback for removed _rhd_paging_nav function
 */
if (!function_exists('_rhd_paging_nav')) {
  function _rhd_paging_nav() {
    the_posts_pagination( array(
        'prev_text' => '<i class="fa fa-chevron-left"></i> ' . __( ' posts', '_rhd' ),
        'next_text' => __( ' posts', '_rhd' ) . ' <i class="fa fa-chevron-right"></i>' ,
    ) );
  }
}

/**
 * Adds the URL to the top level navigation menu item
 */
function  _rhd_add_top_level_menu_url( $atts, $item, $args ){
  if ( !wp_is_mobile() && isset($args->has_children) && $args->has_children  ) {
    $atts['href'] = ! empty( $item->url ) ? $item->url : '';
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', '_rhd_add_top_level_menu_url', 99, 3 );

/**
 * Makes the top level navigation menu item clickable
 */
function _rhd_make_top_level_menu_clickable(){
if ( !wp_is_mobile() ) { ?>
  <script type="text/javascript">
    jQuery( document ).ready( function( $ ){
      if ( $( window ).width() >= 767 ){
        $( '.navbar-nav > li.menu-item > a' ).click( function(){
            if( $( this ).attr('target') !== '_blank' ){
                window.location = $( this ).attr( 'href' );
            }else{
                var win = window.open($( this ).attr( 'href' ), '_blank');
                win.focus();
            }
        });
      }
    });
  </script>
<?php }
}
add_action('wp_footer', '_rhd_make_top_level_menu_clickable', 1);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function _s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', '_s_pingback_header' );