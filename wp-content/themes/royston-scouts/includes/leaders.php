<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php
	function create_leader_post_type() {
		$labels = array(
			'name' => _x('Leaders', 'post type general name'),
			'singular_name' => _x('Leader', 'post type singular name'),
			'add_new' => _x('Add New', 'leader'),
			'add_new_item' => __('Add New Leader'),
			'edit_item' => __('Edit Leader'),
			'new_item' => __('New Leader'),
			'view_item' => __('View Leader'),
			'search_items' => __('Search Leaderas'),
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
 
		register_post_type( 'leader' , $args );
	}

	// [show_leaders]
	function show_leaders_func( $atts ) {
		$leader_query = new WP_Query('post_type=leader');

		$r_str = "";

		if ($leader_query->have_posts()) {
			$r_str .= "<div class='rs_leaders'>";
		};

		// The Loop
		while ( $leader_query->have_posts() ) :
			$leader_query->the_post();
			$r_str .= "<div class='rs_leader'>";
			$r_str .= '  <div class="rs_leader_name">' . get_the_title() . '</div>';
			$r_str .= '  <div class="rs_leader_description">' . get_the_content() . '</div>';
			$r_str .= "</div>";
		endwhile;

		// Restore original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();

		if (!empty($r_str))
			$r_str .= "</div>";

		return $r_str;
	}

	add_shortcode( 'show_leaders', 'show_leaders_func' );
	
	function leaders_post_type_setup() {
		add_action( 'init', 'create_leader_post_type' );
	}
	
	add_action( 'after_setup_theme', 'leaders_post_type_setup' );
?>