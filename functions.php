<?php 

// add content width
if ( ! isset( $content_width ) ) $content_width = 1200;
 

/****** 
Register & Enqueue Styles & Scripts
*******/
 function thesrpr_enqueue_styles() {
 	wp_enqueue_style('stylesheet', get_stylesheet_uri(),'','','all');
 }
 
function thesrpr_enqueue_scripts() {
    global $is_IE;
    wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
	wp_enqueue_script('modernizr',  get_template_directory_uri().'/js/modernizr.custom.js');

	if ($is_IE) 
		{	wp_enqueue_script('html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js"); 
			wp_enqueue_script('selectivizr',  get_template_directory_uri().'/js/selectivizr-min.js', array('jquery'));
		}
	wp_enqueue_script('foundation', get_template_directory_uri().'/js/foundation.min.js', array('jquery'),'',true);
	wp_enqueue_script('picturefill', get_template_directory_uri().'/js/picturefill.min.js', array('jquery'),'',true);
	wp_enqueue_script('swipebox',  get_template_directory_uri().'/js/jquery.swipebox.min.js', array('jquery'), '', true);

	wp_enqueue_script('easing',  get_template_directory_uri().'/js/jquery.easing.min.js', array('jquery'), '', true);
	wp_enqueue_script('jquery-timing',  get_template_directory_uri().'/js/jquery-timing.min.js', array('jquery'), '', true);
	wp_enqueue_script('custom',  get_template_directory_uri().'/js/custom.js', array('jquery','foundation'),'', true);
}
add_action( 'wp_enqueue_scripts', 'thesrpr_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'thesrpr_enqueue_scripts' );

/* Global Includes */
require_once('includes/admin.php');
require_once('includes/foundation.php');
require_once('includes/images.php');
require_once('includes/navigation.php');
require_once('includes/shortcodes.php');

/* Theme Options */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/options/' );
	require_once dirname( __FILE__ ) . '/includes/options/options-framework.php';
}

/* Custom Metaboxes */
function thesrpr_metaboxes( $meta_boxes ) {
	$prefix = '_srpr_'; // Prefix for all fields
	$meta_boxes[] = array(
    'id'         => 'contact_options',
    'title'      => 'Contact Form Options',
    'pages'      => array( 'page' ),
    'show_on' => array( 'key' => 'page-template', 'value' => 'templates/contact.php' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'show_names' => true, 
    'fields'     => array(  
      array(
        'name' => 'Management Email',
        'desc' => 'Enter address for management contact',
        'id'   => $prefix . 'mgmt_contact',
        'type' => 'text_medium',
      ),
      array(
        'name' => 'Booking Email',
        'desc' => 'Enter address for booking contact',
        'id'   => $prefix . 'booking_contact',
        'type' => 'text_medium',
      ),
      array(
        'name' => 'Press Email',
        'desc' => 'Enter address for press contact',
        'id'   => $prefix . 'press_contact',
        'type' => 'text_medium',
      ),
      array(
        'name' => 'Web/Technical Email',
        'desc' => 'Enter address for technical contact',
        'id'   => $prefix . 'web_contact',
        'type' => 'text_medium',
      ),            
    ),
  );  
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'thesrpr_metaboxes' );
add_action( 'init', 'thesrpr_initialize_cmb_meta_boxes', 9999 );
function thesrpr_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'includes/metaboxes/init.php' );
	}
}

/* add theme support */
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'status', 'gallery', 'audio', 'video', 'link', 'image', 'quote', 'chat' ) );

$args = array(
  'flex-width'    => true,
  'flex-height'    => true,
  'uploads'       => true,
);
add_theme_support( 'custom-header', $args );

$args = array(
  'default-color' => 'FFFFFF',
  'default-image' => get_template_directory_uri() . '/images/',
);
add_theme_support( 'custom-background', $args );

/* translation ready info */
load_theme_textdomain( 'thesrpr', TEMPLATEPATH.'/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
	
/* Flush Rewrites */
add_action( 'after_switch_theme', 'thesrpr_flush_rewrite_rules' );
function thesrpr_flush_rewrite_rules() {
	// place custom post type functions here as well to flush permalinks
	flush_rewrite_rules();
}

/*******
Theme Specific Functions
*******/

/* login image link */
add_filter( 'login_headerurl', 'custom_login_header_url' );
function custom_login_header_url($url) {
  return 'http://yourwebsite.com';
}	
	
?>