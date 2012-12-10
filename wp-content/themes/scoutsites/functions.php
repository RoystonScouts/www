<?php
if ( function_exists('register_sidebar') ) {     
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'scoutsites' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
   register_sidebar( array(
		'name' => __( 'Beavers', 'scoutsites' ),
		'id' => 'sidebar-beavers',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Cubs', 'scoutsites' ),
		'id' => 'sidebar-cubs',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Scouts', 'scoutsites' ),
		'id' => 'sidebar-scouts',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Explorers', 'scoutsites' ),
		'id' => 'sidebar-explorers',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
} 
add_action( 'after_setup_theme','remove_twentyeleven_all_widgets', 100 );
function remove_twentyeleven_all_widgets() {
	remove_filter( 'widgets_init', 'twentyeleven_widgets_init' );
}

add_action( 'after_setup_theme', 'childtheme_override' );

function childtheme_override() {
    add_filter('body_class', 'twentyeleven_child_body_classes');
}

function twentyeleven_child_body_classes ($classes) {
    if (is_page_template('beavers-page.php') or is_page_template('cubs-page.php') or is_page_template('scouts-page.php') or is_page_template('explorers-page.php') ) {
        foreach ($classes as $key => $value) {
	        if ($value == 'singular') {
                 unset($classes[$key]);
                 $classes = array_values($classes);
            }
	    }
    }
    return $classes;
}
function twentyeleven_setup() {

	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );


	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	$theme_options = twentyeleven_get_theme_options();
	if ( 'dark' == $theme_options['color_scheme'] )
		$default_background_color = '1d1d1d';
	else
		$default_background_color = 'f1f1f1';

	// Add support for custom backgrounds.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		// This is dependent on our current color scheme.
		'default-color' => $default_background_color,
	) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// Add support for custom headers.
	$custom_header_support = array(
		// The default header text color.
		'default-text-color' => '000',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyeleven_header_image_width', 1000 ),
		'height' => apply_filters( 'twentyeleven_header_image_height', 288 ),
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
		'random-default' => true,
		// Callback for styling the header.
		'wp-head-callback' => 'twentyeleven_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyeleven_admin_header_style',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => 'twentyeleven_admin_header_image',
	);
	
	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// Add Twenty Eleven's custom image sizes.
	// Used for large feature (header) images.
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	# unregister_default_headers();
	register_default_headers( array(
		'helmet' => array(
			'url' => '%s/../scoutsites/images/brand/page-scoutsclimbinghelmet.jpg',
			'thumbnail_url' => '%s/../scoutsites/images/brand/page-scoutsclimbinghelmet-thumb.jpg',
			/* translators: header image description */
			'description' => 'Climbing'
		),
		'cubs' => array(
			'url' => '%s/../scoutsites/images/brand/page-cubsfriends.jpg',
			'thumbnail_url' => '%s/../scoutsites/images/brand/page-cubsfriends-thumb.jpg',
			/* translators: header image description */
			'description' => 'Cubs'
		),
		'beaver' => array(
			'url' => '%s/../scoutsites/images/brand/page-beaver.jpg',
			'thumbnail_url' => '%s/../scoutsites/images/brand/page-beaver-thumb.jpg',
			/* translators: header image description */
			'description' => 'Beaver'
		),
		'cub' => array(
			'url' => '%s/../scoutsites/images/brand/page-cub.jpg',
			'thumbnail_url' => '%s/../scoutsites/images/brand/page-cub-thumb.jpg',
			/* translators: header image description */
			'description' => 'Cub'
		),
		'yp' => array(
			'url' => '%s/../scoutsites/images/brand/page-threeyp.png',
			'thumbnail_url' => '%s/../scoutsites/images/brand/page-threeyp-thumb.png',
			/* translators: header image description */
			'description' => 'Three YP'
		),
		
	) );
	
}
?>