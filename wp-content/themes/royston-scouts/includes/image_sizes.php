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
?>
