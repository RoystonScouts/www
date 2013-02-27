<?php
if(!class_exists('Royston_Scouts_Default_Categories'))
{
	class Royston_Scouts_Default_Categories
	{
		public function __construct()
		{
		}

		public static function init() {
			self::update_or_create_category( array('cat_name' => 'Beavers', 'category_description' => 'Information related to the Beavers section') );
			self::update_or_create_category( array('cat_name' => 'Cubs', 'category_description' => 'Information related to the Cubs section') );
			self::update_or_create_category( array('cat_name' => 'Scouts', 'category_description' => 'Information related to the Scouts section') );
			self::update_or_create_category( array('cat_name' => 'Explorers', 'category_description' => 'Information related to the Explorers section') );
			self::update_or_create_category( array('cat_name' => 'Group', 'category_description' => 'Information related to the Group') );
			self::update_or_create_category( array('cat_name' => 'District', 'category_description' => 'Information related to the District') );
		}
		
		public static function update_or_create_category($catarr) {
			$catid = category_exists($catarr['cat_name']);
			$catarr['cat_ID'] = $catid;
			wp_insert_category($catarr, true);
	    	}
	}
}
