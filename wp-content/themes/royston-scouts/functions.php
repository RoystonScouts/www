<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

	require ( get_stylesheet_directory() . '/includes/volunteer_roles.php' );
	require ( get_stylesheet_directory() . '/includes/volunteers.php' );
	require ( get_stylesheet_directory() . '/includes/header_functions.php' );

	
	function royston_scouts_theme_setup() {
		add_theme_support( 'post-thumbnails' );
		add_filter('widget_text', 'do_shortcode');
//		remove_filter( 'wp_page_menu_args', 'responsive_page_menu_args' );
	}

	add_action( 'after_setup_theme', 'royston_scouts_theme_setup' );
	add_action( 'after_switch_theme', 'flush_rewrite_rules' );
?>
