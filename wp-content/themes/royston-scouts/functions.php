<?php
	add_image_size( 'slide-thumb', 470, 200, true); //(cropped)
	
	function custom_wmu_image_sizes($sizes) {
        $myimgsizes = array(
                "slide-thumb" => __( "Slideshow" ),
                );
        $newimgsizes = array_merge($sizes, $myimgsizes);
        return $newimgsizes;
	}
	
	add_filter('image_size_names_choose', 'custom_wmu_image_sizes');
	
	$args = array(
		'flex-width'    => true,
		'width'         => 300,
		'flex-height'    => true,
		'height'        => 100,
		'default-image' => get_stylesheet_directory_uri() . '/images/default-logo.png',
	);
	add_theme_support( 'custom-header', $args );
	
	function royston_scouts_theme_setup() {
		remove_filter( 'wp_page_menu_args', 'responsive_page_menu_args' );
	}

	add_action( 'after_setup_theme', 'royston_scouts_theme_setup' );
?>