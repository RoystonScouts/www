<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php
	function add_loginout_link( $items, $args ) {
		if (is_user_logged_in() && $args->theme_location == 'top-menu') {
			$items .= '<li class="menu-item"><a href="'. wp_logout_url(get_permalink()) .'">Logout</a></li>';
		}
		elseif (!is_user_logged_in() && $args->theme_location == 'top-menu') {
			$items .= '<li class="menu-item"><a href="'. wp_login_url(get_permalink()) .'">Login</a></li><li class="menu-item"><a href="'. site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()) .'">Register</a></li>';
		}
		return $items;
	}

	add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );

	function add_home_link( $items, $args ) {
		if ( $args->theme_location == 'header-menu' ) {
			$items = '<li class="menu-item menu-home"><a href="' . home_url() . '" title="Home">Home</a></li>' . $items;
		}
		return $items;
	}
	add_filter( 'wp_nav_menu_items', 'add_home_link', 10, 2 );
?>
