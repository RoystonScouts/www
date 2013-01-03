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
	
	function create_post_type() {
		$labels = array(
			'name' => _x('Volunteer Roles', 'post type general name'),
			'singular_name' => _x('Voluneteer Role', 'post type singular name'),
			'add_new' => _x('Add New', 'role'),
			'add_new_item' => __('Add New Role'),
			'edit_item' => __('Edit Role'),
			'new_item' => __('New Role'),
			'view_item' => __('View Role'),
			'search_items' => __('Search Roles'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
	 
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail')
		  ); 
 
		register_post_type( 'scout_role' , $args );
	}
	
	function royston_scouts_theme_setup() {
		add_action( 'init', 'create_post_type' );
		remove_filter( 'wp_page_menu_args', 'responsive_page_menu_args' );
		add_filter('widget_text', 'do_shortcode');
	}

	add_action( 'after_setup_theme', 'royston_scouts_theme_setup' );
	add_action( 'after_switch_theme', 'flush_rewrite_rules' );
?>