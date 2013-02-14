<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php
	add_image_size( 'slide-thumb', 620, 320, true); //(cropped)
	
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
	
	function add_loginout_link( $items, $args ) {
		if (is_user_logged_in() && $args->theme_location == 'top-menu') {
			$items .= '<li><a href="'. wp_logout_url(get_permalink()) .'">Logout</a></li>';
		}
		elseif (!is_user_logged_in() && $args->theme_location == 'top-menu') {
			$items .= '<li><a href="'. wp_login_url(get_permalink()) .'">Login</a></li><li><a href="'. site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()) .'">Register</a></li>';
		}
		return $items;
	}
	add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
?>
