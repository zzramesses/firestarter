<?php 

// add content width
if ( ! isset( $content_width ) ) $content_width = 1200;

register_activation_hook( __FILE__, 'thesrpr_login_activate' );
function thesrpr_login_activate() {
    flush_rewrite_rules();
}
 
register_deactivation_hook( __FILE__, 'thesrpr_login_deactivate' );
function thesrpr_login_deactivate() {
    flush_rewrite_rules();
}
 

/****** 
Register & Enqueue Styles & Scripts
*******/
 
function thesrpr_register_styles_scripts()
{
  if ( !is_admin() )
  {
    global $is_IE;
    
    wp_enqueue_style('stylesheet', get_stylesheet_uri(),'','','all');

	wp_enqueue_script('jquery');
	wp_enqueue_script('modernizr',  get_template_directory_uri().'/js/modernizr.custom.js');

	if ($is_IE) 
		{	wp_enqueue_script('html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js"); 
			wp_enqueue_script('selectivizr',  get_template_directory_uri().'/js/selectivizr-min.js', array('jquery'));
		}
	wp_enqueue_script('foundation', get_template_directory_uri().'/js/foundation.min.js', array('jquery'),'',true);
	wp_enqueue_script('picturefill', get_template_directory_uri().'/js/picturefill.min.js', array('jquery'),'',true);
	wp_enqueue_script('easing',  get_template_directory_uri().'/js/jquery.easing.min.js', array('jquery'), '', true);
	wp_enqueue_script('jquery-timing',  get_template_directory_uri().'/js/jquery-timing.min.js', array('jquery'), '', true);
	wp_enqueue_script('jkit',  get_template_directory_uri().'/js/jquery.jkit.min.js', array('jquery'), '', true);
	wp_enqueue_script('custom',  get_template_directory_uri().'/js/custom.js', array('jquery','foundation'),'', true);
	
	wp_enqueue_script('live-reload',  get_template_directory_uri().'/js/livereload.js', array('jquery'),'', true);
  }
}

add_action('init', 'thesrpr_register_styles_scripts');

/****** 
Bring in front and backend function files
*******/
 
function thesrpr_includes() {
	require('frontend/frontend.php');
	require('backend/backend.php');
 }

add_action('init', 'thesrpr_includes');

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/backend/options' );
	require_once dirname( __FILE__ ) . '/backend/options/options-framework.php';
}


/* Register Menu */
register_nav_menu( 'primary', 'Primary Menu' );

/* add home link to nav menu */
function home_page_menu_args( $args ) {
$args['show_home'] = true;
return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );


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


/* register sidebars */
register_sidebar(
	array(
		'name' => 'blog',
		'description'   =>  'These widgets appear on individual blog posts and the blog page template',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>'
	)
);	
	
register_sidebar(
	array(
		'name' => 'pages',
		'description'   =>  'These widgets appear when the sidebar left or sidebar right template is chosen',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>'
	)
);		
	
?>