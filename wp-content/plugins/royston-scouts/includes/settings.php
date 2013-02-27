<?php
if(!class_exists('Royston_Scouts_Settings'))
{
	class Royston_Scouts_Settings
	{
		public function __construct()
		{
			// register actions
           		add_action('admin_init', array(&$this, 'admin_init'));
	        	add_action('admin_menu', array(&$this, 'add_menu'));
		}
		
		public function admin_init()
	        {
			// add a settings section
			add_settings_section(
			    'royston_scouts-section', 
			    'Test Settings', 
			    array(&$this, 'settings_section_royston_scouts'), 
			    'royston_scouts'
			);
			
			// add a setting's fields
		    	add_settings_field(
		        	'royston_scouts-setting_a', 
		        	'Setting A', 
			        array(&$this, 'settings_field_input_text'), 
			        'royston_scouts', 
			        'royston_scouts-section',
			        array(
			            'field' => 'setting_a'
			        )
		        );

			// register the plugin's settings
			register_setting('royston_scouts-test-group', 'setting_a');

		}
        
		public function settings_section_royston_scouts()
		{
			echo 'These settings do things for the Royston Scouts plugin.';
		}
        
		public function settings_field_input_text($args)
		{
			// Get the field name from the $args array
			$field = $args['field'];
			// Get the value of this setting
			$value = get_option($field);
			// echo a proper input type="text"
			echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
		}
		
		public function add_menu()
		{
			// Add a page to manage this plugin's settings
			add_options_page(
			    'Royston Scouts Settings', 
			    'Royston Scouts',
			    'manage_options', 
			    'royston_scouts', 
			    array(&$this, 'plugin_settings_page')
			);
		}
	    
		public function plugin_settings_page()
		{
			if(!current_user_can('manage_options'))
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
	
			// Render the settings template
			include(RS_PATH . "/templates/settings.php" );
		}
	}
}
