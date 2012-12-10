<?php
/*
Plugin Name: SocialAuth-WordPress
Plugin URI: http://wordpress.org/extend/plugins/socialauth-wp/
Description: SocialAuth-WordPress is a Wordpress 3.0+ plugin derived from popular PHP based HybridAuth library. Inspired from other Wordpress social login plugins, this plugin seamlessly integrates into any Wordpress 3.0+ application and enables social login integration through different service providers. All you have to do is to configure the plugin from settings page before you can start using it. SocialAuth-WP hides all the intricacies of generating signatures and token, doing security handshakes and provides an out of the box a simple solution to interact with providers.
Version: 1.5.5
Author: labs@3pillarglobal.com
Author URI: http://socialauth.in/wordpress
License: MIT License
*/

include_once 'common.php';
require_once( SOCIALAUTH_WP_HYBRIDAUTH_DIR_PATH ."/Hybrid/Auth.php" );

/* This calls SocialAuth_WP() function when wordpress initializes.*/
add_action('init','SocialAuth_WP');

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'SocialAuth_WP_install');

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'SocialAuth_WP_remove' );

add_action( 'logout_url', 'new_logout_url');
add_filter('get_avatar', 'social_auth_wordpress_get_avatar', 10, 5);

/* Show Settings page in Admin */
require_once SOCIALAUTH_WP_PLUGIN_PATH .'/admin-settings.php';

/* Show Provides on login screen */
require_once( dirname( __FILE__ ) . '/ui.php' );

/* Add required CSS/Js to HTML HEAD */
require_once SOCIALAUTH_WP_PLUGIN_PATH .'/media.php';

/* Show friends Page */
require_once SOCIALAUTH_WP_PLUGIN_PATH .'/feature-friends.php';

/*Check technical requirements are fulfilled before activating.*/
function SocialAuth_WP_install() {
    if(!function_exists( 'register_post_status' ) || !function_exists( 'curl_version' ) || !function_exists( 'hash' ) || version_compare( PHP_VERSION, '5.1.2', '<' ) ) {
        deactivate_plugins( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );
        if(!function_exists( 'register_post_status'))
            wp_die( sprintf( __( "Sorry, but you can not install Plugin 'SocialAuth-WordPress'. It requires WordPress 3.0 or newer. Consider <a href='http://codex.wordpress.org/Updating_WordPress'>upgrading</a> your WordPress installation, it's worth the effort.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'SocialAuth_WP'), admin_url( 'plugins.php' ) ), 'SocialAuth_WP' );
        elseif ( !function_exists( 'curl_version' ) )
            wp_die( sprintf( __( "Sorry, but you can not install Plugin 'SocialAuth-WordPress'. It requires the <a href='http://www.php.net/manual/en/intro.curl.php'>PHP libcurl extension</a> to be installed. Please contact your web host and request libcurl be <a href='http://www.php.net/manual/en/intro.curl.php'>installed</a>.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'SocialAuth_WP'), admin_url( 'plugins.php' ) ), 'SocialAuth_WP' );
        elseif ( !function_exists( 'hash' ) )
            wp_die( sprintf( __( "Sorry, but you can not install Plugin 'SocialAuth-WordPress'. It requires the <a href='http://www.php.net/manual/en/intro.hash.php'>PHP Hash Engine</a>. Please contact your web host and request Hash engine be <a href='http://www.php.net/manual/en/hash.setup.php'>installed</a>.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'SocialAuth_WP'), admin_url( 'plugins.php' ) ), 'SocialAuth_WP' );
        else
            wp_die( sprintf( __( "Sorry, but you can not install Plugin 'SocialAuth-WordPress'. It requires PHP 5.1.2 or newer. Please contact your web host and request they <a href='http://www.php.net/manual/en/migration5.php'>migrate</a> your PHP installation to run WP-Social-Auth.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'SocialAuth_WP'), admin_url( 'plugins.php' ) ), 'SocialAuth_WP' );
    }
    do_action( 'SocialAuth_WP_installation' );
}

/* Action Called eveytime worpress is loaded. 
 * You can add any specific aciotn message here related to plugin 
 * */
function SocialAuth_WP() {

}

function social_auth_wordpress_get_avatar($avatar, $id_or_email, $size, $default, $alt){
	
	//$avatar format includes the tag <img>
	$user_id = get_current_user_id();
	$provider = get_user_meta( $user_id, 'ha_login_provider', true );
	$profilePicSource = get_option('SocialAuth_WP_profile_picture_source');

	if ($user_id != 0 && !empty($provider) && !empty($profilePicSource) && $profilePicSource == "authenticatingProvider")
	{
		$profileImageUrl = get_user_meta( $user_id, 'profile_image_url', true );
		if(!empty($profileImageUrl))
		{
			$avatar = "<img src='".$profileImageUrl."' alt='".$alt."' height='".$size."' width='".$size."' />";
		}
	}
	return $avatar;
}

/* Action Called eveytime plugin is un-installed.
* You can add any specif aciotn message here related to plugin un-installation
* */
function SocialAuth_WP_remove() {}

/* Overide actual wordpress URL to show custom logout page */
function new_logout_url($a) {
    return plugin_dir_url(__FILE__) . 'logout.php?redirect_to=' . urlencode($a);
}

//Helps in login, to fetch user details to compare new user with existing one(s)
function get_user_by_meta( $meta_key, $meta_value ) {
    global $wpdb;
    $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
    return $wpdb->get_var( $wpdb->prepare( $sql, $meta_key, $meta_value ) );
}