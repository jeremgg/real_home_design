<?php
/**
 * _rhd Theme Customizer
 *
 * @package _rhd
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _rhd_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', '_rhd_customize_register' );


//-----------------------------
//-- OPTIONS THEME CUSTOMIZER
//----------------------------
function _rhd_customizer( $wp_customize ) {

    //------------ OPTIONS SETTINGS PANEL ------------
    $wp_customize->add_panel('_rhd_main_options', array(
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('Options', '_rhd'),
        'description' => __('Panel to update theme options', '_rhd'), // Include html tags such as <p>.
        'priority' => 10 // Mixed with top-level-section hierarchy.
    ));


  	//--------------------
  	//-- SLIDER OPTIONS
  	//--------------------
		$wp_customize->add_section('_rhd_slider_options', array(
			'title' => __('Slider options', '_rhd'),
			'priority' => 31,
			'panel' => '_rhd_main_options'
		));

		//------------- SLIDER OPTIONS ----------------
		$wp_customize->add_setting( '_rhd[_rhd_slider_checkbox]', array(
			'default' => 0,
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_checkbox',
		));

		$wp_customize->add_control( '_rhd[_rhd_slider_checkbox]', array(
			'label'	=> esc_html__( 'Check if you want to enable slider', '_rhd' ),
			'section'	=> '_rhd_slider_options',
			'priority'	=> 5,
			'type'      => 'checkbox',
		));

		//------------- Pull all the categories into an array ----------------
		global $options_categories;

		$wp_customize->add_setting('_rhd[_rhd_slide_categories]', array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => '_rhd_sanitize_slidecat'
		));

		$wp_customize->add_control('_rhd[_rhd_slide_categories]', array(
			'label' => __('Slider Category', '_rhd'),
			'section' => '_rhd_slider_options',
			'type'    => 'select',
			'description' => __('Select a category for the featured post slider', '_rhd'),
			'choices'    => $options_categories
		));

		$wp_customize->add_setting('_rhd[_rhd_slide_number]', array(
			'default' => 3,
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_number'
		));

		$wp_customize->add_control('_rhd[_rhd_slide_number]', array(
			'label' => __('Number of slide items', '_rhd'),
			'section' => '_rhd_slider_options',
			'description' => __('Enter the number of slide items', '_rhd'),
			'type' => 'text'
		));

		$wp_customize->add_section('_rhd_layout_options', array(
			'title' => __('Layout options', '_rhd'),
			'priority' => 31,
			'panel' => '_rhd_main_options'
		));




  	//--------------------
  	//-- LAYOUTS OPTIONS
  	//--------------------
		global $site_layout;

		//------------- LAYOUTS OPTIONS ----------------
		$wp_customize->add_setting('_rhd[site_layout]', array(
			 'default' => 'side-pull-left',
			 'type' => 'option',
			 'sanitize_callback' => '_rhd_sanitize_layout'
		));

		$wp_customize->add_control('_rhd[site_layout]', array(
			 'label' => __('Website Layout Options', '_rhd'),
			 'section' => '_rhd_layout_options',
			 'type'    => 'select',
			 'description' => __('Choose between different layout options to be used as default', '_rhd'),
			 'choices'    => $site_layout
		));

		$wp_customize->add_setting('_rhd[element_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[element_color]', array(
			'label' => __('Element Color', '_rhd'),
			'description'   => __('Default used if no color is selected','_rhd'),
			'section' => '_rhd_layout_options',
			'settings' => '_rhd[element_color]',
		)));

		$wp_customize->add_setting('_rhd[element_color_hover]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[element_color_hover]', array(
			'label' => __('Element color on hover', '_rhd'),
			'description'   => __('Default used if no color is selected','_rhd'),
			'section' => '_rhd_layout_options',
			'settings' => '_rhd[element_color_hover]',
		)));




		//-----------------------
		//-- TYPOGRAPHY OPTIONS
		//-----------------------
		$wp_customize->add_section('_rhd_typography_options', array(
			'title' => __('Typography', '_rhd'),
			'priority' => 31,
			'panel' => '_rhd_main_options'
		));


		//------------- TYPOGRAPHY DEFAULTS ----------------
		$typography_defaults = array(
				'size'  => '14px',
				'face'  => 'Open Sans',
				'style' => 'normal',
				'color' => '#6B6B6B'
		);


		//------------- TYPOGRAPHY OPTIONS ----------------
		global $typography_options;

		$wp_customize->add_setting('_rhd[main_body_typography][size]', array(
			'default' => $typography_defaults['size'],
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_typo_size'
		));

		$wp_customize->add_control('_rhd[main_body_typography][size]', array(
			'label' => __('Main Body Text', '_rhd'),
			'description' => __('Used in p tags', '_rhd'),
			'section' => '_rhd_typography_options',
			'type'    => 'select',
			'choices'    => $typography_options['sizes']
		));

		$wp_customize->add_setting('_rhd[main_body_typography][face]', array(
			'default' => $typography_defaults['face'],
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_typo_face'
		));

		$wp_customize->add_control('_rhd[main_body_typography][face]', array(
			'section' => '_rhd_typography_options',
			'type'    => 'select',
			'choices'    => $typography_options['faces']
		));

		$wp_customize->add_setting('_rhd[main_body_typography][style]', array(
			'default' => $typography_defaults['style'],
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_typo_style'
		));

		$wp_customize->add_control('_rhd[main_body_typography][style]', array(
			'section' => '_rhd_typography_options',
			'type'    => 'select',
			'choices'    => $typography_options['styles']
		));

		$wp_customize->add_setting('_rhd[main_body_typography][color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[main_body_typography][color]', array(
			'section' => '_rhd_typography_options',
		)));

		$wp_customize->add_setting('_rhd[heading_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[heading_color]', array(
			'label' => __('Heading Color', '_rhd'),
			'description'   => __('Color for all headings (h1-h6)','_rhd'),
			'section' => '_rhd_typography_options',
		)));

		$wp_customize->add_setting('_rhd[link_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[link_color]', array(
			'label' => __('Link Color', '_rhd'),
			'description'   => __('Default used if no color is selected','_rhd'),
			'section' => '_rhd_typography_options',
		)));

		$wp_customize->add_setting('_rhd[link_hover_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[link_hover_color]', array(
			'label' => __('Link:hover Color', '_rhd'),
			'description'   => __('Default used if no color is selected','_rhd'),
			'section' => '_rhd_typography_options',
		)));




		//-------------------
		//-- HEADER OPTIONS
		//-------------------
		$wp_customize->add_section('_rhd_header_options', array(
			'title' => __('Header', '_rhd'),
			'priority' => 31,
			'panel' => '_rhd_main_options'
		));

		//------------- TYPOGRAPHY OPTIONS ----------------
		$wp_customize->add_setting('_rhd[sticky_header]', array(
			'default' => 0,
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_checkbox'
		));

		$wp_customize->add_control('_rhd[sticky_header]', array(
			'label' => __('Sticky Header', '_rhd'),
			'description' => sprintf(__('Check to show fixed header', '_rhd')),
			'section' => '_rhd_header_options',
			'type' => 'checkbox',
		));

		$wp_customize->add_setting('_rhd[nav_bg_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_bg_color]', array(
			'label' => __('Top nav background color', '_rhd'),
			'description'   => __('Default used if no color is selected','_rhd'),
			'section' => '_rhd_header_options',
		)));

		$wp_customize->add_setting('_rhd[nav_link_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_link_color]', array(
			'label' => __('Top nav item color', '_rhd'),
			'description'   => __('Link color','_rhd'),
			'section' => '_rhd_header_options',
		)));

		$wp_customize->add_setting('_rhd[nav_item_hover_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_item_hover_color]', array(
			'label' => __('Top nav item hover color', '_rhd'),
			'description'   => __('Link:hover color','_rhd'),
			'section' => '_rhd_header_options',
		)));

		$wp_customize->add_setting('_rhd[nav_dropdown_bg]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_dropdown_bg]', array(
			'label' => __('Top nav dropdown background color', '_rhd'),
			'description'   => __('Background of dropdown item hover color','_rhd'),
			'section' => '_rhd_header_options',
		)));

		$wp_customize->add_setting('_rhd[nav_dropdown_item]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_dropdown_item]', array(
			'label' => __('Top nav dropdown item color', '_rhd'),
			'description'   => __('Dropdown item color','_rhd'),
			'section' => '_rhd_header_options',
		)));

		$wp_customize->add_setting('_rhd[nav_dropdown_item_hover]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_dropdown_item_hover]', array(
			'label' => __('Top nav dropdown item hover color', '_rhd'),
			'description'   => __('Dropdown item hover color','_rhd'),
			'section' => '_rhd_header_options',
		)));

		$wp_customize->add_setting('_rhd[nav_dropdown_bg_hover]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[nav_dropdown_bg_hover]', array(
			'label' => __('Top nav dropdown item background hover color', '_rhd'),
			'description'   => __('Background of dropdown item hover color','_rhd'),
			'section' => '_rhd_header_options',
		)));




		//-------------------
		//-- FOOTER OPTIONS
		//-------------------
		$wp_customize->add_section('_rhd_footer_options', array(
			'title' => __('Footer', '_rhd'),
			'priority' => 31,
			'panel' => '_rhd_main_options'
		));

		//------------- FOOTER OPTIONS ----------------
		$wp_customize->add_setting('_rhd[footer_widget_bg_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[footer_widget_bg_color]', array(
			'label' => __('Footer widget area background color', '_rhd'),
			'section' => '_rhd_footer_options',
		)));

		$wp_customize->add_setting('_rhd[footer_bg_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[footer_bg_color]', array(
			'label' => __('Footer background color', '_rhd'),
			'section' => '_rhd_footer_options',
		)));

		$wp_customize->add_setting('_rhd[footer_text_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[footer_text_color]', array(
			'label' => __('Footer text color', '_rhd'),
			'section' => '_rhd_footer_options',
		)));

		$wp_customize->add_setting('_rhd[footer_link_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[footer_link_color]', array(
			'label' => __('Footer link color', '_rhd'),
			'section' => '_rhd_footer_options',
		)));

		$wp_customize->add_setting('_rhd[custom_footer_text]', array(
			'default' => '',
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_strip_slashes'
		));

		$wp_customize->add_control('_rhd[custom_footer_text]', array(
			'label' => __('Footer information', '_rhd'),
			'description' => sprintf(__('Copyright text in footer', '_rhd')),
			'section' => '_rhd_footer_options',
			'type' => 'textarea'
		));




		//-------------------
		//-- SOCIAL OPTIONS
		//-------------------
		$wp_customize->add_section('_rhd_social_options', array(
			'title' => __('Social', '_rhd'),
			'priority' => 31,
			'panel' => '_rhd_main_options'
		));

		//------------- SOCIAL OPTIONS ----------------
		$wp_customize->add_setting('_rhd[social_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[social_color]', array(
			'label' => __('Social icon color', '_rhd'),
			'description' => sprintf(__('Default used if no color is selected', '_rhd')),
			'section' => '_rhd_social_options',
		)));

		$wp_customize->add_setting('_rhd[social_footer_color]', array(
			'default' => '',
			'type'  => 'option',
			'sanitize_callback' => '_rhd_sanitize_hexcolor'
		));

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_rhd[social_footer_color]', array(
			'label' => __('Footer social icon color', '_rhd'),
			'description' => sprintf(__('Default used if no color is selected', '_rhd')),
			'section' => '_rhd_social_options',
		)));

		$wp_customize->add_setting('_rhd[footer_social]', array(
			'default' => 0,
			'type' => 'option',
			'sanitize_callback' => '_rhd_sanitize_checkbox'
		));

		$wp_customize->add_control('_rhd[footer_social]', array(
			'label' => __('Footer Social Icons', '_rhd'),
			'description' => sprintf(__('Check to show social icons in footer', '_rhd')),
			'section' => '_rhd_social_options',
			'type' => 'checkbox',
		));
}
add_action( 'customize_register', '_rhd_customizer' );



/**
 * Sanitzie checkbox for WordPress customizer
 */
function _rhd_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
/**
 * Adds sanitization callback function: colors
 * @package _rhd
 */
function _rhd_sanitize_hexcolor($color) {
    if ($unhashed = sanitize_hex_color_no_hash($color))
        return '#' . $unhashed;
    return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package _rhd
 */
function _rhd_sanitize_nohtml($input) {
    return wp_filter_nohtml_kses($input);
}

/**
 * Adds sanitization callback function: Number
 * @package _rhd
 */
function _rhd_sanitize_number($input) {
    if ( isset( $input ) && is_numeric( $input ) ) {
        return $input;
    }
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package _rhd
 */
function _rhd_sanitize_strip_slashes($input) {
    return wp_kses_stripslashes($input);
}

/**
 * Adds sanitization callback function: Sanitize Text area
 * @package _rhd
 */
function _rhd_sanitize_textarea($input) {
    return sanitize_text_field($input);
}

/**
 * Adds sanitization callback function: Slider Category
 * @package _rhd
 */
function _rhd_sanitize_slidecat( $input ) {
    global $options_categories;
    if ( array_key_exists( $input, $options_categories ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package _rhd
 */
function _rhd_sanitize_layout( $input ) {
    global $site_layout;
    if ( array_key_exists( $input, $site_layout ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Typography Size
 * @package _rhd
 */
function _rhd_sanitize_typo_size( $input ) {
    global $typography_options, $typography_defaults;
    if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
        return $input;
    } else {
        return $typography_defaults['size'];
    }
}
/**
 * Adds sanitization callback function: Typography Face
 * @package _rhd
 */
function _rhd_sanitize_typo_face( $input ) {
    global $typography_options, $typography_defaults;
    if ( array_key_exists( $input, $typography_options['faces'] ) ) {
        return $input;
    } else {
        return $typography_defaults['face'];
    }
}
/**
 * Adds sanitization callback function: Typography Style
 * @package _rhd
 */
function _rhd_sanitize_typo_style( $input ) {
    global $typography_options, $typography_defaults;
    if ( array_key_exists( $input, $typography_options['styles'] ) ) {
        return $input;
    } else {
        return $typography_defaults['style'];
    }
}




//-------------------------------------------------------------------------------------
//-- Binds JS handlers to make Theme Customizer preview reload changes asynchronously
//-------------------------------------------------------------------------------------
function _rhd_customize_preview_js() {
	wp_enqueue_script(
		'_rhd_customizer',
		get_template_directory_uri() . '/inc/js/customizer.js',
		array( 'customize-preview' ),
		'20140317', true );
}
add_action( 'customize_preview_init', '_rhd_customize_preview_js' );




//--------------------------------
//-- ADD CSS FOR CUSTOM CONTROLS
//--------------------------------
function _rhd_customizer_custom_control_css() {
	?>
    <style>
        #customize-control-_rhd-main_body_typography-size select, #customize-control-_rhd-main_body_typography-face select,#customize-control-_rhd-main_body_typography-style select { width: 60%; }
    </style><?php
}
add_action( 'customize_controls_print_styles', '_rhd_customizer_custom_control_css' );




//-----------------------
//-- CUSTOMIZER SCRIPT
//-----------------------
add_action( 'customize_controls_print_footer_scripts', 'customizer_custom_scripts' );

function customizer_custom_scripts() { ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        /* This one shows/hides the an option when a checkbox is clicked. */
        jQuery('#customize-control-_rhd-_rhd_slide_categories, #customize-control-_rhd-_rhd_slide_number').hide();
        jQuery('#customize-control-_rhd-_rhd_slider_checkbox input').click(function() {
            jQuery('#customize-control-_rhd-_rhd_slide_categories, #customize-control-_rhd-_rhd_slide_number').fadeToggle(400);
        });

        if (jQuery('#customize-control-_rhd-_rhd_slider_checkbox input:checked').val() !== undefined) {
            jQuery('#customize-control-_rhd-_rhd_slide_categories, #customize-control-_rhd-_rhd_slide_number').show();
        }
    });
</script>
<style>
    li#accordion-section-_rhd_important_links h3.accordion-section-title, li#accordion-section-_rhd_important_links h3.accordion-section-title:focus { background-color: #00cc00 !important; color: #fff !important; }
    li#accordion-section-_rhd_important_links h3.accordion-section-title:hover { background-color: #00b200 !important; color: #fff !important; }
    li#accordion-section-_rhd_important_links h3.accordion-section-title:after { color: #fff !important; }
</style>
<?php
}
