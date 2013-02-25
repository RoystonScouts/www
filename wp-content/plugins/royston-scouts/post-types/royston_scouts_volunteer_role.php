<?php
if(!class_exists('Royston_Scouts_Jobs'))
{
	class Royston_Scouts_Jobs
	{
		const POST_TYPE	= "jobs";

		private $_meta	= array(
			'meta_a',
			'meta_b',
			'meta_c',
		);
		
	    	public function __construct()
	    	{
	    		// register actions
	    		add_action('init', array(&$this, 'init'));
	    		add_action('admin_init', array(&$this, 'admin_init'));
	    	}

	    	public function init()
	    	{
	    		// Initialize Post Type
	    		$this->create_post_type();
	    		add_action('save_post', array(&$this, 'save_post'));
	    	}

	    	public function create_post_type()
	    	{
	    		register_post_type(self::POST_TYPE,
	    			array(
	    				'labels' => array(
	    					'name' => __('Jobs'),
	    					'singular_name' => __('Job'),
						'add_new' => __('New job'),
						'add_new_item' => __('Add new job description'),
						'edit_item' => __('Edit job'),
						'new_item' => __('New Job'),
						'view_item' => __('View Job'),
						'search_items' => __('Search Jobs'),
						'not_found' =>  __('Nothing found'),
						'not_found_in_trash' => __('Nothing found in Trash')
	    				),
	    				'public' => true,
	    				'has_archive' => true,
	    				'description' => __("Volunteer positions available that can be displayed on the site"),
	    				'supports' => array(
	    					'title', 'editor', 'excerpt', 
	    				),
	    			)
	    		);
	    	}
	
	    	public function save_post($post_id)
	    	{
			// verify if this is an auto save routine. 
			// If it is our form has not been submitted, so we dont want to do anything
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			{
				return;
			}
 
	    		if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
	    		{
	    			foreach($this->_meta as $field_name)
	    			{
	    				// Update the post's meta field
	    				update_post_meta($post_id, $field_name, $_POST[$field_name]);
	    			}
	    		} else {
	    			return;
	    		}
	    	}

		public function admin_init()
	    	{			
	    		// Add metaboxes
	    		add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
	    	}
			
	    	public function add_meta_boxes()
	    	{
	    		// Add this metabox to every selected post
	    		add_meta_box( 
	    			sprintf('royston_scouts_%s_section', self::POST_TYPE),
	    			sprintf('Additional Job Information'),
	    			array(&$this, 'add_inner_meta_boxes'),
	    			self::POST_TYPE
	    		);					
	    	}

		public function add_inner_meta_boxes($post)
		{		
			// Render the job order metabox
			include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));			
		}

	}
}
