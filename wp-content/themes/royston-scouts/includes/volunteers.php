<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php
	function create_volunteer_post_type() {
		$labels = array(
			'name' => _x('Volunteers', 'post type general name'),
			'singular_name' => _x('Volunteer', 'post type singular name'),
			'add_new' => _x('Add New', 'Volunteer'),
			'add_new_item' => __('Add New Volunteer'),
			'edit_item' => __('Edit volunteer'),
			'new_item' => __('New volunteer'),
			'view_item' => __('View volunteer'),
			'search_items' => __('Search volunteers'),
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
			'hierarchical' => true,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail'),
			'taxonomies' => array('category')
		  ); 
 
		register_post_type( 'volunteer' , $args );
	}

	// [show_volunteers]
	function show_volunteers_func( $atts ) {
		$volunteer_query = new WP_Query('post_type=volunteer');

		$r_str = "";

		if ($volunteer_query->have_posts()) {
			$r_str .= "<div class='rs_volunteers'>";
		};

		// The Loop
		while ( $volunteer_query->have_posts() ) :
			$volunteer_query->the_post();
			$r_str .= "<div class='rs_volunteer'>";
			$r_str .= '  <div class="rs_volunteer_name">' . get_the_title() . '</div>';
			$r_str .= '  <div class="rs_volunteer_description">' . get_the_content() . '</div>';
			$r_str .= "</div>";
		endwhile;

		// Restore original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();

		if (!empty($r_str))
			$r_str .= "</div>";

		return $r_str;
	}

	add_shortcode( 'show_volunteers', 'show_volunteers_func' );
	
	function volunteers_post_type_setup() {
		add_action( 'init', 'create_volunteer_post_type' );
	}
	
	add_action( 'after_setup_theme', 'volunteers_post_type_setup' );
?>