<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php
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

	// [vr_roles_available]
	function vr_roles_available_func( $atts ) {
		$vr_query = new WP_Query('post_type=scout_role');

		$vr_r_str = "";

		if ($vr_query->have_posts()) {
			$vr_r_str .= "<p>We are currently looking for:</p><ul>";
		};

		// The Loop
		while ( $vr_query->have_posts() ) :
			$vr_query->the_post();
			$vr_r_str .= '<li><a href="'. get_permalink() . '">' . get_the_title() . '</a></li>';
		endwhile;

		// Restore original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();

		if (!empty($vr_r_str))
			$vr_r_str .= "</ul>";

		return $vr_r_str;
	}

	add_shortcode( 'vr_roles_available', 'vr_roles_available_func' );
	
	function volunteer_roles_setup() {
		add_action( 'init', 'create_post_type' );
	}
	
	add_action( 'after_setup_theme', 'volunteer_roles_setup' );
?>