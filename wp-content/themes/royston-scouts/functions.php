<?php

	// Exit if accessed directly
	if ( !defined('ABSPATH')) exit;

	require ( get_stylesheet_directory() . '/includes/image_sizes.php' );
	require ( get_stylesheet_directory() . '/includes/menus.php' );
	require ( get_stylesheet_directory() . '/includes/header_functions.php' );

	
	function royston_scouts_theme_setup() {
		add_theme_support( 'post-thumbnails' );
		add_filter('widget_text', 'do_shortcode');
	}

	add_action( 'after_setup_theme', 'royston_scouts_theme_setup' );
?>
