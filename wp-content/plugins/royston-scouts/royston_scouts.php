<?php
/*
Plugin Name: Royston Scouts
Plugin URI: https://github.com/RoystonScouts/www/plugins/royston-scouts
Description: A collection of functionality for the Royston Scout network
Version: 0.1
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

if(!class_exists('Royston_Scouts'))
{
	class Royston_Scouts
	{
		public function __construct()
		{
	        	// Initialize Settings
	            	require_once(sprintf("%s/settings.php", dirname(__FILE__)));
	            	$Royston_Scouts_Settings = new Royston_Scouts_Settings();
        	
	        	// Register custom post types
	            	require_once(sprintf("%s/post-types/royston_scouts_jobs.php", dirname(__FILE__)));
	            	$royston_scouts_jobs = new Royston_Scouts_Jobs();
		}
	    
		public static function activate()
		{
			// Do nothing
	            	$royston_scouts_jobs = new Royston_Scouts_Jobs();
			$royston_scouts_jobs->init();
			flush_rewrite_rules();
		}
	
		public static function deactivate()
		{
			// Do nothing
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
