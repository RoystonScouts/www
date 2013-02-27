<?php
if(!class_exists('Royston_Scouts_Custom_Taxonomies'))
{
	class Royston_Scouts_Custom_Taxonomies
	{
		public function __construct()
		{
			add_action( 'init', array($this, 'create_section_taxonomy') );
		}
		
		function create_section_taxonomy() {
			register_taxonomy('section', 'post', array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => false,

				// This array of options controls the labels displayed in the WordPress Admin UI
				'labels' => array(
					'name' => _x( 'Sections', 'taxonomy general name' ),
					'singular_name' => _x( 'Section', 'taxonomy singular name' ),
					'search_items' =>  __( 'Search section' ),
					'all_items' => __( 'All sections' ),
					'parent_item' => __( 'Parent Section' ),
					'parent_item_colon' => __( 'Parent Section:' ),
					'edit_item' => __( 'Edit Section' ),
					'update_item' => __( 'Update Section' ),
					'add_new_item' => __( 'Add New Section' ),
					'new_item_name' => __( 'New Section Name' ),
					'menu_name' => __( 'Sections' ),
				),
				// Control the slugs used for this taxonomy
				'rewrite' => array(
					'slug' => 'sections', // This controls the base slug that will display before each term
					'with_front' => false, // Don't display the category base before "/locations/"
					'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
				),
			));
	    	}
	}
}
