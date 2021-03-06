<?php
if(!class_exists('Royston_Scouts_Custom_Admin_Interface'))
{
	class Royston_Scouts_Custom_Admin_Interface
	{
		public function __construct()
		{
			// Customise the admin interface
			add_action( 'admin_menu', array($this, 'edit_admin_menu') );
			add_action( 'admin_init', array($this, 'change_post_object_label') );
			add_action( 'admin_init', array($this, 'change_category_taxonomy_label'), 0 );
			add_filter( 'custom_menu_order', array($this, 'custom_menu_order') );
			add_filter( 'menu_order', array($this, 'custom_menu_order') );
			add_action( 'wp_dashboard_setup', array($this, 'wpc_dashboard_widgets') );
			add_filter( 'admin_footer_text', array($this, 'remove_footer_admin') );

			add_action( 'login_enqueue_scripts', array($this, 'custom_login_css') );
			add_filter( 'login_headertitle', array($this, 'custom_login_logo_url_title') );
			add_filter( 'login_headerurl', array($this, 'custom_login_logo_url') );
		}
		
		public function edit_admin_menu() {
			global $menu;
			global $submenu;

			$menu[5][0] = 'News'; // Change Posts to News
			$submenu['edit.php'][5][0] = 'All news';
			$submenu['edit.php'][10][0] = 'Add news';
		}

		function change_post_object_label() {
			global $wp_post_types;
			$labels = &$wp_post_types['post']->labels;
			$labels->name = 'News';
			$labels->singular_name = 'News';
			$labels->add_new = 'Add news';
			$labels->add_new_item = 'Add news';
			$labels->edit_item = 'Edit news';
			$labels->new_item = 'News';
			$labels->view_item = 'View news';
			$labels->search_items = 'Search news';
			$labels->not_found = 'No news articles found';
			$labels->not_found_in_trash = 'No news articles found in Trash';
	    	}

		function change_category_taxonomy_label() {
			$labels = get_taxonomy('category')->labels;
			$labels->name = 'Sections';
			$labels->singular_name = 'Section';
			$labels->search_items = 'Search sections';
			$labels->all_items = 'All sections';
			$labels->parent_items = 'Parent Section';
			$labels->parent_item_colon = 'Parent Section:';
			$labels->edit_item = 'Edit Section';
			$labels->view_item = 'View Section';
			$labels->update_item = 'Update Section';
			$labels->add_new_item = 'Add New Section';
			$labels->new_item_name = 'New Section Name';
			$labels->menu_name = 'Sections';
		}

		function custom_menu_order($menu_ord) {
			if (!$menu_ord) return true;

			return array(
				'index.php', // this represents the dashboard link
				'edit.php', //the posts tab
				'edit.php?post_type=page', //the pages tab
				'edit.php?post_type=royston-scout-job', //the jobs tab
				'edit.php?post_type=qa_faqs', //the pages tab
				'upload.php', // the media manager
			);
		}

		// Custom WordPress Login Logo
		function custom_login_css() {
			wp_enqueue_style( 'login_css', get_stylesheet_directory_uri() . '/login.css' );
		}

		function custom_login_logo_url() {
		    	return get_bloginfo( 'url' );
		}

		function custom_login_logo_url_title() {
		    	return get_bloginfo( 'description' );
		}

		function wpc_dashboard_widgets() {
			global $wp_meta_boxes;

			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		}

		function remove_footer_admin () {
			echo '&copy; 2013 - Royston Scouts - A WordPress customised site';
		}
       
	}
}
