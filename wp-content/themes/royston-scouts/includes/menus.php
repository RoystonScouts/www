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
	
	/**
	 * Menu fallback. Link to the menu editor if that is useful.
	 *
	 * @param  array $args
	 * @return string
	 */
	function link_to_menu_editor( $args )
	{
	    extract( $args );

	    if ( !current_user_can( 'manage_options' ) )
	    {
		if ( !is_user_logged_in() ) { 
		    $link = $link_before
			. '<a href="' . wp_login_url(get_permalink()) . '">' . $before . 'Login' . $after . '</a>'
			. $link_after;
		} else {
		    $link = $link_before
			. '<a href="' . wp_logout_url(get_permalink()) . '">' . $before . 'Logout' . $after . '</a>'
			. $link_after;
		}
	    } else {
	    	    $link = $link_before
			. '<a href="' .admin_url( 'nav-menus.php' ) . '">' . $before . 'Add a menu' . $after . '</a>'
			. $link_after;
	    	    $link .= $link_before
			. '<a href="' . wp_logout_url(get_permalink()) . '">' . $before . 'Logout' . $after . '</a>'
			. $link_after;
	    }

	    // We have a list
	    if ( FALSE !== stripos( $items_wrap, '<ul' )
		or FALSE !== stripos( $items_wrap, '<ol' )
	    )
	    {
		$link = "<li>$link</li>";
	    }

	    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
	    if ( ! empty ( $container ) )
	    {
		$output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
	    }

	    if ( $echo )
	    {
		echo $output;
	    }

	    return $output;
	}
?>
