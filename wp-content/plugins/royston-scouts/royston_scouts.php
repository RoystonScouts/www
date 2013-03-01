<?php
/*
Plugin Name: Royston Scouts
Plugin URI: https://github.com/RoystonScouts/www/tree/master/wp-content/plugins/royston-scouts
Description: A collection of functionality for the Royston Scout network
Version: 0.2
Author: Jens Kolind
Author URI: http://roystonscouts.org.uk
License: GPL2
*/
/*
Copyright 2013  Jens Kolind  (email : skip@1stroystonscoutgroup.org.uk)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('RS_PATH' , WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)) );
define('RS_URL'  , WP_PLUGIN_URL . "/" . plugin_basename(dirname(__FILE__)) );

define('RS_VERSION', '0.2');

require_once( RS_PATH . "/includes/default_categories.php" );
require_once( RS_PATH . "/includes/settings.php" );
require_once( RS_PATH . "/includes/custom_admin_interface.php" );
require_once( RS_PATH . "/includes/jobs.php" );
require_once( RS_PATH . "/includes/recent_comments.php" );

if(!class_exists('Royston_Scouts'))
{
	class Royston_Scouts
	{
		public function __construct()
		{
	        	// Initialize Settings
	            	$settings = new Royston_Scouts_Settings();

	        	// Customise the admin interface
	            	$custom_admin_interface = new Royston_Scouts_Custom_Admin_Interface();

	        	// Register custom post types
	            	$jobs = new Royston_Scouts_Jobs();
	            	
	            	$recent_comments = new Royston_Scouts_Recent_Comments();
		}
	    

		public static function activate()
		{
	            	$jobs = new Royston_Scouts_Jobs();
			$jobs->init();

			Royston_Scouts_Default_Categories::init();

			$role = get_role( 'editor' );
			$role->remove_cap( 'manage_categories' );

			flush_rewrite_rules();
		}
	
		public static function deactivate()
		{
			$role = get_role( 'editor' );
			$role->add_cap( 'manage_categories' );
		}

	}
}

if(class_exists('Royston_Scouts'))
{
	$royston_scouts = new Royston_Scouts();

	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Royston_Scouts', 'activate'));
	register_deactivation_hook(__FILE__, array('Royston_Scouts', 'deactivate'));

	// Add a link to the settings page onto the plugin page
 	if(isset($royston_scouts))
	{
		function plugin_settings_link($links)
		{ 
		    $settings_link = '<a href="options-general.php?page=royston_scouts">Settings</a>'; 
		    array_unshift($links, $settings_link); 
		    return $links; 
		}

		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
	}
}
