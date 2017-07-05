<?php
/**
 * theme functions and definitions
 */




//----------------------------------------------------------------------
//-- Set the content width based on the theme's design and stylesheet.
//----------------------------------------------------------------------
if ( ! isset( $content_width ) ) {
	$content_width = 648; /* pixels */
}




//---------------------------------------------------------------
//-- Set the content width for full width pages with no sidebar.
//---------------------------------------------------------------
function _rhd_content_width() {
  if ( is_page_template( 'page-fullwidth.php' ) ) {
    global $content_width;
    $content_width = 1008; /* pixels */
  }
}
add_action( 'template_redirect', '_rhd_content_width' );




//---------------------
//-- THEME SETUP
//---------------------
if ( ! function_exists( '_rhd_setup' ) ) :
	global $cap, $content_width;

	//------------- REGISTER WIDGET ----------------
	function _rhd_widgets_init() {
		register_sidebar( array(
	    'name'          => esc_html__( 'Sidebar', '_rhd' ),
	    'id'            => 'sidebar-1',
	    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget'  => '</aside>',
	    'before_title'  => '<h3 class="widget-title">',
	    'after_title'   => '</h3>',
	  ));

	  register_widget( 'rhd_popular_posts' );
	}
	add_action( 'widgets_init', '_rhd_widgets_init' );


	//------------- REGISTER MENU ----------------//
	function _rhd_menu_init() {
		register_nav_menus( array(
			'primary'      => esc_html__( 'Primary Menu', '_rhd' ),
			'footer-links' => esc_html__( 'Footer Links', '_rhd' ),
			'social-menu' => esc_html__( 'social menu header', '_rhd' ),
			'social-menu-footer' => esc_html__( 'social menu footer', '_rhd' )
		));
	}
	add_action( 'init', '_rhd_menu_init' );



	//------------- REGISTER THEME FEATURES ----------------//
	function _rhd_custom_theme_features()  {

		// Make theme available for translation.
	  load_theme_textdomain( '_rhd', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add theme support for Post Formats
		add_theme_support( 'post-formats', array(
			'status',
			'quote',
			'gallery',
			'image',
			'video',
			'audio',
			'link',
			'aside',
			'chat'
		));

		// Add theme support for Featured Images
		add_theme_support( 'post-thumbnails' );
	  add_image_size( '_rhd_featured', 750, 410, true );
	  add_image_size( 'tab-small', 60, 60 , true); // Small Thumbnail
		add_image_size( 'admin-list-thumb', 80, 80, true); //admin thumbnail
		add_image_size( 'album-grid', 450, 450, true );

		// Enable support for HTML5 markup.
	  add_theme_support( 'html5', array(
	    'comment-list',
	    'search-form',
	    'comment-form',
	    'gallery',
	    'caption',
	  ));

		// Add theme support for Custom Background
		// add_theme_support( 'custom-background', apply_filters( '_rhd_custom_background_args', array(
		// 	'default-color' => 'f2f2f2',
		// 	'default-image' => '',
		// )));

		// Add theme support for Custom Header
		$header_args = array(
			'default-image'          => '',
			'width'                  => 0,
			'height'                 => 0,
			'flex-width'             => false,
			'flex-height'            => false,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => true,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
			'video'                  => true,
			'video-active-callback'  => ''
		);
		add_theme_support( 'custom-header', $header_args );

		// Add theme support for logo
		add_theme_support( 'custom-logo', array(
	    'height'      => 100,
	    'width'       => 400,
	    'flex-height' => true,
	    'flex-width'  => true,
	    'header-text' => array( 'site-title', 'site-description' )
		));

		// Add theme support for custom CSS in the TinyMCE visual editor
		add_editor_style();

	  add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', '_rhd_custom_theme_features' );
endif; // _rhd_setup




/* --------------------------------------------------------------
       Theme Widgets
-------------------------------------------------------------- */
require_once(get_template_directory() . '/inc/widgets/widget-categories.php');
require_once(get_template_directory() . '/inc/widgets/widget-social.php');
require_once(get_template_directory() . '/inc/widgets/widget-popular-posts.php');




//----------------------
//-- LOGO
//----------------------
function _rhd_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
}

function _rhd_change_logo_class($html){
				$html = str_replace('custom-logo-link', 'navbar-brand', $html);
				return $html;
		}

add_filter('get_custom_logo','_rhd_change_logo_class');




//-------------------
//-- ENQUEUE STYLES
//-------------------
function _rhd_styles() {

	//load bootstrap css
		wp_enqueue_style(
			'_rhd_bootstrap',
			get_template_directory_uri().'/assets/stylesheets/css/bootstrap/_bootstrap.css',
			false ,false, 'all'
	  );

	// Add main theme stylesheet
	  wp_enqueue_style( '_rhd_style', get_stylesheet_uri() );

	// Add slider CSS only if is front page ans slider is enabled
	  if( ( is_home() || is_front_page() ) && of_get_option('_rhd_slider_checkbox') == 1 ) {
	    wp_enqueue_style( 'flexslider-css', get_template_directory_uri().'/assets/lib/flexslider/flexslider.css' );
	  }
}
add_action( 'wp_enqueue_scripts', '_rhd_styles' );




//-------------------
//-- ENQUEUE FONTS
//-------------------
function _rhd_fonts() {

	// Add Google Fonts
	  // wp_register_style(
		// 	'_rhd_fonts',
		// 	'//fonts.googleapis.com/css?family=Playfair+Display|Raleway:300,500,700'
		// );
		//
	  // wp_enqueue_style( '_rhd_fonts' );

	//load font css
		wp_enqueue_style(
			'_rhd_font',
			get_template_directory_uri().'/assets/stylesheets/css/webfontkit/stylesheet.css',
			false ,false, 'all'
		);

		//load font-awesome css
		wp_enqueue_style(
			'_rhd_font_awesome',
			get_template_directory_uri().'/assets/stylesheets/css/font-awesome/font-awesome.css',
			false ,false, 'all'
		);
}
add_action( 'wp_enqueue_scripts', '_rhd_fonts' );




//---------------------
//-- ENQUEUE SCRIPTS
//---------------------
function _rhd_scripts() {

	// load bootstrap js
		wp_enqueue_script(
			'_rhd_bootstrap_script',
			get_template_directory_uri().'/assets/lib/bootstrap/bootstrap.min.js',
			array('jquery'),
			true
		);

	// load Modernizr for better HTML5 and CSS3 support
		wp_enqueue_script(
			'_rhd_modernizr_script',
			get_template_directory_uri().'/assets/lib/modernizr/modernizr.min.js',
			array('jquery')
		);

	// load fancybox.js
		wp_enqueue_script(
			'_rhd_fancybox_script',
			'http' . ( $_SERVER["SERVER_PORT"] == 443 ? 's' : '' ) . '://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.4/jquery.fancybox.pack.js',
			array('jquery')
		);

	// load isotope.js
		wp_enqueue_script(
			'_rhd_isotope_script',
			'http' . ( $_SERVER["SERVER_PORT"] == 443 ? 's' : '' ) . '://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/1.5.25/jquery.isotope.min.js',
			array('jquery')
		);

	// load general.js
		wp_enqueue_script(
			'_rhd_general_script',
			get_template_directory_uri().'/assets/js/general.js',
			array('jquery')
		);

	// load main.js
		wp_enqueue_script(
			'_rhd_main_script',
			get_template_directory_uri().'/assets/js/main.js',
			array('jquery')
		);

		// This one is for accessibility
			wp_enqueue_script(
				'_rhd_skip-link-focus-fix_script',
				get_template_directory_uri().'/assets/js/skip-link-focus-fix.js',
				array('jquery')
			);

		// Treaded comments
		  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		    wp_enqueue_script( 'comment-reply' );
		  }

		if( ( is_home() || is_front_page() ) && of_get_option('_rhd_slider_checkbox') == 1 ) {
		   // Add slider JS only if is front page ans slider is enabled
		   		wp_enqueue_script(
						'flexslider-js',
						get_template_directory_uri() . '/assets/lib/flexslider/flexslider.min.js',
						array('jquery'),
						'20140222', true
					);

		   // Flexslider customization
			   wp_enqueue_script(
					 'flexslider-customization',
					 get_template_directory_uri() . '/assets/js/flexslider-custom.js',
					 array('jquery', 'flexslider-js'),
					 '20140716', true
				 );
		}
}
add_action( 'wp_enqueue_scripts', '_rhd_scripts' );




//----------------
//-- FIL ARIANE
//----------------
function fil_ariane(){
	global $post;

		$fil = '<a href="'.get_bloginfo('wpurl').'">';
		$fil .= 'Home';
		$fil .= '</a> ';
		$fil .= '> ';

	$parents = array_reverse(get_ancestors($post->ID,'page'));
	foreach ($parents as $parent) {
		$fil .= '<a href="'.get_permalink($parent).'">';
		$fil .= get_the_title($parent);
		$fil .= '</a> > ';
	}

	$fil .= '<p>'.$post->post_title.'</p>';

	return $fil;
}




//------------
//-- EXCERPT
//------------
function excerpt_new( $output ) {
	global $post;

	return $output.' <a class="btn btn-primary read-more" href="' .get_permalink($post->ID). '">Read More</a>';

}
add_filter( 'the_excerpt', 'excerpt_new' );




//--------------------
//-- LAYOUT OPTIONS
//--------------------
global $site_layout;
$site_layout = array(
	'side-pull-left' => esc_html__('Right Sidebar', '_rhd'),
	'side-pull-right' => esc_html__('Left Sidebar', '_rhd'),
	'no-sidebar' => esc_html__('No Sidebar', '_rhd'),
	'full-width' => esc_html__('Full Width', '_rhd')
);




//-----------------------
//-- TYPOGRAPHY OPTIONS
//-----------------------
global $typography_options;
$typography_options = array(
  'sizes' => array( '6px' => '6px', '8px' => '8px', '10px' => '10px','12px' => '12px','14px' => '14px','15px' => '15px','16px' => '16px','18'=> '18px','20px' => '20px','22px' => '22px', '24px' => '24px','28px' => '28px','32px' => '32px','36px' => '36px','42px' => '42px','48px' => '48px' ),
  'faces' => array(
    	'arial'          => 'Arial',
      'verdana'        => 'Verdana, Geneva',
      'trebuchet'      => 'Trebuchet',
      'georgia'        => 'Georgia',
      'times'          => 'Times New Roman',
      'tahoma'         => 'Tahoma, Geneva',
      'Open Sans'      => 'Open Sans',
      'palatino'       => 'Palatino',
      'helvetica'      => 'Helvetica',
      'playfair_displayregular' => 'playfair display',
			'ralewaylight'	 => 'raleway light',
			'ralewaymedium'  => 'raleway medium',
			'ralewaybold' 	 => 'raleway bold'
  ),
  'styles' => array( 'normal' => 'Normal', 'light' => 'Light', 'medium' => 'Medium', 'bold' => 'Bold' ),
  'color'  => true
);



//-----------------------
//-- PAGINATION
//-----------------------
function custom_pagination() {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	$pages = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_next' => false,
		'type'  => 'array',
		'prev_next'   => false,
		'prev_text'    => __( '«', '_rhd' ),
		'next_text'    => __( '»', '_rhd'),
	) );
	$output = '';

	if ( is_array( $pages ) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var( 'paged' );

		$output .=  '<div class="navigation pagination">';
		foreach ( $pages as $page ) {
				$output .= "<li>$page</li>";
		}
		$output .= '</div>';

		// Create an instance of DOMDocument
		$dom = new \DOMDocument();

		// Populate $dom with $output, making sure to handle UTF-8, otherwise
		// problems will occur with UTF-8 characters.
		$dom->loadHTML( mb_convert_encoding( $output, 'HTML-ENTITIES', 'UTF-8' ) );

		// Create an instance of DOMXpath and all elements with the class 'page-numbers'
		$xpath = new \DOMXpath( $dom );

		// http://stackoverflow.com/a/26126336/3059883
		$page_numbers = $xpath->query( "//*[contains(concat(' ', normalize-space(@class), ' '), ' page-numbers ')]" );

		// Iterate over the $page_numbers node...
		foreach ( $page_numbers as $page_numbers_item ) {

				// Add class="mynewclass" to the <li> when its child contains the current item.
				$page_numbers_item_classes = explode( ' ', $page_numbers_item->attributes->item(0)->value );
				if ( in_array( 'current', $page_numbers_item_classes ) ) {
						$list_item_attr_class = $dom->createAttribute( 'class' );
						$list_item_attr_class->value = 'page-active';
						$page_numbers_item->parentNode->appendChild( $list_item_attr_class );
				}

				// Replace the class 'current'
				$page_numbers_item->attributes->item(0)->value = str_replace(
												'current',
												'active',
												$page_numbers_item->attributes->item(0)->value );

				// Replace the class 'page-numbers'
				$page_numbers_item->attributes->item(0)->value = str_replace(
												'page-numbers',
												'btn btn-primary',
												$page_numbers_item->attributes->item(0)->value );

				// Replace the class 'btn btn-primary active'
				$page_numbers_item->attributes->item(0)->value = str_replace(
												'btn btn-primary active',
												'btn btn-default active',
												$page_numbers_item->attributes->item(0)->value );
		}

		// Save the updated HTML and output it.
		$output = $dom->saveHTML();
	}

	return $output;
}




//-------------------------------
//--POST TYPE GALLERY
//-------------------------------
$gallery_labels = array(
	'name' => _x('gallery', 'post type general name'),
	'singular_name' => _x('gallery', 'post type singular name'),
	'add_new' => _x('Add New', 'gallery'),
	'add_new_item' => __("Add New gallery"),
	'edit_item' => __("Edit gallery"),
	'new_item' => __("New gallery"),
	'view_item' => __("View gallery"),
	'search_items' => __("Search gallery"),
	'not_found' =>  __('No gallery found'),
	'not_found_in_trash' => __('No gallery found in Trash'),
	'parent_item_colon' => ''
);

$gallery_args = array(
	'labels' => $gallery_labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => true,
	'hierarchical' => false,
	'menu_position' => null,
	'capability_type' => 'post',
	'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments')
	// 'menu_icon' => get_bloginfo('template_directory') . '/images/photo-album.png' //16x16 png if you want an icon
);
register_post_type('gallery', $gallery_args);




//---------------------------
//--GALLERY CUSTOM TAXONOMY
//---------------------------
add_action( 'init', 'jss_create_gallery_taxonomies', 0);

function jss_create_gallery_taxonomies(){
	register_taxonomy(
		'phototype', 'gallery',
		array(
			'hierarchical'=> true,
			'label' => 'Categories',
			'singular_label' => 'Categories',
			'rewrite' => true
		)
	);
}




//--------------------------------
//--GALLERY ADMIN CUSTOM COLUMNS
//--------------------------------
//admin_init
add_action('manage_posts_custom_column', 'jss_custom_columns');
add_filter('manage_edit-gallery_columns', 'jss_add_new_gallery_columns');

function jss_add_new_gallery_columns( $columns ){
	$columns = array(
		'cb'				=>		'<input type="checkbox">',
		'jss_post_thumb'	=>		'Thumbnail',
		'title'				=>		'Photo Title',
		'phototype'			=>		'Categories',
		'author'			=>		'Author',
		'date'				=>		'Date'
	);
	return $columns;
}

function jss_custom_columns( $column ){
	global $post;

	switch ($column) {
		case 'jss_post_thumb' : echo the_post_thumbnail('admin-list-thumb'); break;
		case 'description' : the_excerpt(); break;
		case 'phototype' : echo get_the_term_list( $post->ID, 'phototype', '', ', ',''); break;
	}
}

//add thumbnail images to column
add_filter('manage_posts_columns', 'jss_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'jss_add_post_thumbnail_column', 5);
add_filter('manage_custom_post_columns', 'jss_add_post_thumbnail_column', 5);

// Add the column
function jss_add_post_thumbnail_column($cols){
	$cols['jss_post_thumb'] = __('Thumbnail');
	return $cols;
}

function jss_display_post_thumbnail_column($col, $id){
  switch($col){
    case 'jss_post_thumb':
      if( function_exists('the_post_thumbnail') )
        echo the_post_thumbnail( 'admin-list-thumb' );
      else
        echo 'Not supported in this theme';
      break;
  }
}




//*******************************************************************************//
//*******************************************************************************//




//-------------------------------
//--CUSTOM TAG CLOUD GENERATION
//-------------------------------
function jss_generate_tag_cloud( $tags, $args = '' ) {
	global $wp_rewrite;

	//don't touch these defaults or the sky will fall
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 0,
		'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
		'topic_count_text_callback' => 'default_topic_count_text',
		'topic_count_scale_callback' => 'default_topic_count_scale', 'filter' => 1
	);

    //determine if the variable is null
    if ( !isset( $args['topic_count_text_callback'] ) && isset( $args['single_text'] ) && isset( $args['multiple_text'] ) ) {
	    //var_export
	    $body = 'return sprintf (
	    	_n(' . var_export($args['single_text'], true) . ', ' . var_export($args['multiple_text'], true) . ', $count), number_format_i18n( $count ));';
	    //create_function
	    $args['topic_count_text_callback'] = create_function('$count', $body);
	}

	//parse arguments from above
	$args = wp_parse_args( $args, $defaults );

	//extract
	extract( $args );

	//check to see if they are empty and stop
	if ( empty( $tags ) )
		return;

    //apply the sort filter
	$tags_sorted = apply_filters( 'tag_cloud_sort', $tags, $args );

    //check to see if the tags have been pre-sorted
    if ( $tags_sorted != $tags  ) { // the tags have been sorted by a plugin
	    $tags = $tags_sorted;
	    unset($tags_sorted);
	} else {
        if ( 'RAND' == $order ) {
            shuffle($tags);
        } else {
            // SQL cannot save you
            if ( 'name' == $orderby )
                uasort( $tags, create_function('$a, $b', 'return strnatcasecmp($a->name, $b->name);') );
            else
                uasort( $tags, create_function('$a, $b', 'return ($a->count > $b->count);') );

            if ( 'DESC' == $order )
                $tags = array_reverse( $tags, true );
        }
    }
    //check number and slice array
    if ( $number > 0 )
        $tags = array_slice($tags, 0, $number);

    //set array
    $counts = array();

    //set array for alt tag
    $real_counts = array();

    foreach ( (array) $tags as $key => $tag ) {
        $real_counts[ $key ] = $tag->count;
        $counts[ $key ] = $topic_count_scale_callback($tag->count);
    }

    //determine min coutn
    $min_count = min( $counts );

    //default wordpress sizing
    $spread = max( $counts ) - $min_count;
    if ( $spread <= 0 )
        $spread = 1;
    $font_spread = $largest - $smallest;
    if ( $font_spread < 0 )
        $font_spread = 1;
    $font_step = $font_spread / $spread;

    $a = array();

    //iterate thought the array
    foreach ( $tags as $key => $tag ) {
        $count = $counts[ $key ];
        $real_count = $real_counts[ $key ];
        $tag_link = '#' != $tag->link ? esc_url( $tag->link ) : '#';
        $tag_id = isset($tags[ $key ]->id) ? $tags[ $key ]->id : $key;
        $tag_name = $tags[ $key ]->name;

        //If you want to do some custom stuff, do it here like we did
        //call_user_func
        $a[] = "<a href='#filter' class='tag-link-$tag_id'
		data-option-value='.$tag_name'
		title='" . esc_attr( call_user_func( $topic_count_text_callback, $real_count ) ) . "'>$tag_name</a>"; //background-color is added for validation purposes.
    }

    //set new format
    switch ( $format ) :
    case 'array' :
        $return =& $a;
        break;
    case 'list' :
    	//create our own setup of how it will display and add all
        $return = "<ul id='filters' class='option-set' data-option-key='filter'>\n\t
		<li><a href='filter' data-option-value='*' class='selected'>All</a></li>
		<li>";
        //join
        $return .= join( "</li>\n\t<li>", $a );
        $return .= "</li>\n</ul>\n";
        break;
    default :
    	//return
        $return = join( $separator, $a );
        break;
    endswitch;
        //create new filter hook so we can do this
        return apply_filters( 'jss_generate_tag_cloud', $return, $tags, $args );
}




//-----------------------------
//--CUSTOM TAG CLOUD FUNCTION
//-----------------------------
//the function below is very similar to 'wp_tag_cloud()' currently located in: 'wp-includes/category-template.php'
function jss_tag_cloud( $args = '' ) {
	//set some default
	$defaults = array(
	    'format' => 'list', //display as list
	    'taxonomy' => 'phototype', //our custom post type taxonomy
		'hide_empty' => 'true',
	    'echo' => true, //touch this and it all blows up
	    'link' => 'view'
	);

	//use wp_parse to merge the argus and default values
	$args = wp_parse_args( $args, $defaults );

	//go fetch the terms of our custom taxonomy. query by descending and order by most posts
	$tags = get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) );

	//if there are no tags then end function
	if ( empty( $tags ))
	    return;

	//set the minimum number of posts the tag must have to display (change to whatever)
	$min_num = 1;

	//logic to display tag or not based on post count
	foreach($tags as $key => $tag)
	    {
	    	//if the post container lest than the min_num variable set above
	        if($tag->count < $min_num)
	        {
	            //unset it and destroy part of the array
	            unset($tags[$key]);
	        }
	    }

	foreach ( $tags as $key => $tag ) {
	        if ( 'edit' == $args['link'] )

	            //display the link to edit the tag, if the user is logged in and has rights
	            $link = get_edit_tag_link( $tag -> term_id, $args['taxonomy'] );
	        else
	            //get the permalink for the taxonomy
	            $link = get_term_link( intval($tag -> term_id), $args['taxonomy'] );

	        //check if there is an error
	        if ( is_wp_error( $link ) )
	            return false;

	    $tags[ $key ] -> link = $link;
	    $tags[ $key ] -> id = $tag -> term_id;
	}
	//generate our tag cloud
	$return = jss_generate_tag_cloud( $tags, $args ); // here is where whe list what we are sorting

	//create a new filter hook
	$return = apply_filters( 'jss_tag_cloud', $return, $args );

	if ( 'array' == $args['format'] || empty($args['echo']) )
	    return $return;

	echo $return;
}
//Hooks a function to a specific filter action.
//hook function to filter
add_filter('wp_tag_cloud', 'jss_tag_cloud');




//---------------------------
//---GET CPT TAXONOMY NAME
//---------------------------
function jss_taxonomy_name(){
	 global $post;

	//get terms for CPT
	$terms = get_the_terms( $post->ID , 'phototype' );
				//iterate through array
				foreach ( $terms as $termphoto ) {
					//echo taxonomy name as class
					echo ' '.$termphoto->name;
				}
}




//-------------------------
//-- COMMENT FORM
//-------------------------
if ( ! function_exists( '_rhd_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own _rhd_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @return void
 */
function _rhd_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e( 'Pingback:', '_rhd' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', '_rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment clearfix well">

            <div class="avatar-wrapper">
            	<?php echo get_avatar( $comment, 60 ); ?>
							<h3 class="comment-author"><?php comment_author_link(); ?></h3>
            </div>


            <div class="comment-wrapper">
							<?php if ( '0' == $comment->comment_approved ) : ?>
									<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', '_rhd' ); ?></p>
							<?php endif; ?>

							<div class="comment-content entry-content">
									<?php comment_text(); ?>
									<?php  ?>
							</div><!-- .comment-content -->

                <footer class="comment-meta comment-author vcard">
                    <?php
                        printf( '<h4 class="comment-time" ><time datetime="%2$s">%3$s</time></h4>',
                            esc_url( get_comment_link( $comment->comment_ID ) ),
                            get_comment_time( 'c' ),
                            /* translators: 1: date, 2: time */
                            sprintf( __( '%1$s', '_rhd' ), get_comment_date() )
                        );
												comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                        edit_comment_link( __( 'Edit', '_rhd' ), '<span class="edit-link">', '</span>' );
                    ?>
                </footer><!-- .comment-meta -->



            </div><!--/comment-wrapper-->

        </article><!-- #comment-## -->
    <?php
        break;
    endswitch; // end comment_type check
}
endif;




//-------------------------
//-- CUSTON COMMENT FORM
//-------------------------
function comment_form_custom( $args = array(), $post_id = null ) {
	if ( null === $post_id )
		$post_id = get_the_ID();

	// Exit the function when comments for the post are closed.
	if ( ! comments_open( $post_id ) ) {
		/**
		 * Fires after the comment form if comments are closed.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_comments_closed' );

		return;
	}

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $args['format'];
	$fields   =  array(
		'author' => '<p class="comment-form-author"><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="Your name" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="Your email" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );

	/**
	 * Filters the default comment form fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $fields The default comment fields.
	 */
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" class="form-control" name="comment" placeholder="Your comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>',
		/** This filter is documented in wp-includes/link-template.php */
		'must_log_in'          => '<p class="must-log-in">' . sprintf(
		                              /* translators: %s: login URL */
		                              __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
		                              wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )
		                          ) . '</p>',
		/** This filter is documented in wp-includes/link-template.php */
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf(
		                              /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
		                              __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>' ),
		                              get_edit_user_link(),
		                              /* translators: %s: user name */
		                              esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.' ), $user_identity ) ),
		                              $user_identity,
		                              wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )
		                          ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Your email address will not be published.' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '',
		'action'               => site_url( '/wp-comments-post.php' ),
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'class_form'           => 'comment-form',
		'class_submit'         => 'submit',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Leave a Reply' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
		'format'               => 'xhtml',
	);

	/**
	 * Filters the comment form default arguments.
	 *
	 * Use {@see 'comment_form_default_fields'} to filter the comment fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $defaults The default comment form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	// Ensure that the filtered args contain all required default values.
	$args = array_merge( $defaults, $args );

	/**
	 * Fires before the comment form.
	 *
	 * @since 3.0.0
	 */
	do_action( 'comment_form_before' );
	?>
	<div id="respond" class="comment-respond">
		<?php
		echo $args['title_reply_before'];

		comment_form_title( $args['title_reply'], $args['title_reply_to'] );

		echo $args['cancel_reply_before'];

		cancel_comment_reply_link( $args['cancel_reply_link'] );

		echo $args['cancel_reply_after'];

		echo $args['title_reply_after'];

		if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) :
			echo $args['must_log_in'];
			/**
			 * Fires after the HTML-formatted 'must log in after' message in the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_must_log_in_after' );
		else : ?>
			<form action="<?php echo esc_url( $args['action'] ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="<?php echo esc_attr( $args['class_form'] ); ?>"<?php echo $html5 ? ' novalidate' : ''; ?>>
				<?php
				/**
				 * Fires at the top of the comment form, inside the form tag.
				 *
				 * @since 3.0.0
				 */
				do_action( 'comment_form_top' );

				if ( is_user_logged_in() ) :
					/**
					 * Filters the 'logged in' message for the comment form for display.
					 *
					 * @since 3.0.0
					 *
					 * @param string $args_logged_in The logged-in-as HTML-formatted message.
					 * @param array  $commenter      An array containing the comment author's
					 *                               username, email, and URL.
					 * @param string $user_identity  If the commenter is a registered user,
					 *                               the display name, blank otherwise.
					 */
					echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );

					/**
					 * Fires after the is_user_logged_in() check in the comment form.
					 *
					 * @since 3.0.0
					 *
					 * @param array  $commenter     An array containing the comment author's
					 *                              username, email, and URL.
					 * @param string $user_identity If the commenter is a registered user,
					 *                              the display name, blank otherwise.
					 */
					do_action( 'comment_form_logged_in_after', $commenter, $user_identity );

				else :

					echo $args['comment_notes_before'];

				endif;

				// Prepare an array of all fields, including the textarea
				$comment_fields = array( 'comment' => $args['comment_field'] ) + (array) $args['fields'];

				/**
				 * Filters the comment form fields, including the textarea.
				 *
				 * @since 4.4.0
				 *
				 * @param array $comment_fields The comment fields.
				 */
				$comment_fields = apply_filters( 'comment_form_fields', $comment_fields );

				// Get an array of field names, excluding the textarea
				$comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );

				// Get the first and the last field name, excluding the textarea
				$first_field = reset( $comment_field_keys );
				$last_field  = end( $comment_field_keys );

				foreach ( $comment_fields as $name => $field ) {

					if ( 'comment' === $name ) {

						/**
						 * Filters the content of the comment textarea field for display.
						 *
						 * @since 3.0.0
						 *
						 * @param string $args_comment_field The content of the comment textarea field.
						 */
						echo apply_filters( 'comment_form_field_comment', $field );

						echo $args['comment_notes_after'];

					} elseif ( ! is_user_logged_in() ) {

						if ( $first_field === $name ) {
							/**
							 * Fires before the comment fields in the comment form, excluding the textarea.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_before_fields' );
						}

						/**
						 * Filters a comment form field for display.
						 *
						 * The dynamic portion of the filter hook, `$name`, refers to the name
						 * of the comment form field. Such as 'author', 'email', or 'url'.
						 *
						 * @since 3.0.0
						 *
						 * @param string $field The HTML-formatted output of the comment form field.
						 */
						echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";

						if ( $last_field === $name ) {
							/**
							 * Fires after the comment fields in the comment form, excluding the textarea.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_after_fields' );
						}
					}
				}

				$submit_button = sprintf(
					$args['submit_button'],
					esc_attr( $args['name_submit'] ),
					esc_attr( $args['id_submit'] ),
					esc_attr( $args['class_submit'] ),
					esc_attr( $args['label_submit'] )
				);

				/**
				 * Filters the submit button for the comment form to display.
				 *
				 * @since 4.2.0
				 *
				 * @param string $submit_button HTML markup for the submit button.
				 * @param array  $args          Arguments passed to `comment_form()`.
				 */
				$submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args );

				$submit_field = sprintf(
					$args['submit_field'],
					$submit_button,
					get_comment_id_fields( $post_id )
				);

				/**
				 * Filters the submit field for the comment form to display.
				 *
				 * The submit field includes the submit button, hidden fields for the
				 * comment form, and any wrapper markup.
				 *
				 * @since 4.2.0
				 *
				 * @param string $submit_field HTML markup for the submit field.
				 * @param array  $args         Arguments passed to comment_form().
				 */
				echo apply_filters( 'comment_form_submit_field', $submit_field, $args );

				/**
				 * Fires at the bottom of the comment form, inside the closing </form> tag.
				 *
				 * @since 1.5.0
				 *
				 * @param int $post_id The post ID.
				 */
				do_action( 'comment_form', $post_id );
				?>
			</form>
		<?php endif; ?>
	</div><!-- #respond -->
	<?php

	/**
	 * Fires after the comment form.
	 *
	 * @since 3.0.0
	 */
	do_action( 'comment_form_after' );
}




//-----------------------
//-- FUNCTIONS INCLUDES
//-----------------------
//Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';

//Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

//Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

//Customizer additions.
// require get_template_directory() . '/inc/customizer.php';

//Metabox additions.
require get_template_directory() . '/inc/metaboxes.php';

//Load Jetpack compatibility file.
require get_template_directory() . '/inc/jetpack.php';

//Load custom nav walker
require get_template_directory() . '/inc/navwalker.php';












if ( ! function_exists( '_rhd_main_content_bootstrap_classes' ) ) :
/**
 * Add Bootstrap classes to the main-content-area wrapper.
 */
function _rhd_main_content_bootstrap_classes() {
	if ( is_page_template( 'page-fullwidth.php' ) ) {
		return 'col-sm-12 col-md-12';
	}
	return 'col-sm-8 col-md-8';
}
endif; // _rhd_main_content_bootstrap_classes



/**
 * This function removes inline styles set by WordPress gallery.
 */
function _rhd_remove_gallery_css( $css ) {
  return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}

add_filter( 'gallery_style', '_rhd_remove_gallery_css' );






// /**
//  * TGMPA
//  */
// require get_template_directory() . '/inc/tgmpa/tgm-plugin-activation.php';


/* Globals variables */
global $options_categories;
$options_categories = array();
$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
}




/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if ( ! function_exists( 'of_get_option' ) ) :
function of_get_option( $name, $default = false ) {

	$option_name = '';
	// Get option settings from database
	$options = get_option( '_rhd' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;




/**
* get_layout_class - Returns class name for layout i.e full-width, right-sidebar, left-sidebar etc )
*/
if ( ! function_exists( 'get_layout_class' ) ) :

function get_layout_class () {
    global $post;
    if( is_singular() && get_post_meta($post->ID, 'site_layout', true) && !is_singular( array( 'product' ) ) ){
        $layout_class = get_post_meta($post->ID, 'site_layout', true);
    }
    elseif( function_exists ( "is_woocommerce" ) && function_exists ( "is_it_woocommerce_page" ) && is_it_woocommerce_page() && !is_search() ){// Check for WooCommerce
        $page_id = ( is_product() ) ? $post->ID : get_woocommerce_page_id();

        if( $page_id && get_post_meta($page_id, 'site_layout', true) ){
            $layout_class = get_post_meta( $page_id, 'site_layout', true);
        }
        else{
            $layout_class = of_get_option( 'woo_site_layout', 'full-width' );
        }
    }
    else{
        $layout_class = of_get_option( 'site_layout', 'side-pull-left' );
    }
    return $layout_class;
}

endif;



?>
