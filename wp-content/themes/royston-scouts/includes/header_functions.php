<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php
	$args = array(
		'flex-width'    => true,
		'width'         => 300,
		'flex-height'    => true,
		'height'        => 100,
		'default-image' => get_stylesheet_directory_uri() . '/images/default-logo.png',
	);
	add_theme_support( 'custom-header', $args );
	
    function royston_scouts_widgets_init() {

        register_sidebar(array(
            'name' => __('Beavers', 'responsive'),
            'description' => __('Area 1 - sidebar.php', 'responsive'),
            'id' => 'beavers',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Cubs', 'responsive'),
            'description' => __('Area 1 - sidebar.php', 'responsive'),
            'id' => 'cubs',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Scouts', 'responsive'),
            'description' => __('Area 1 - sidebar.php', 'responsive'),
            'id' => 'scouts',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Group', 'responsive'),
            'description' => __('Area 1 - sidebar.php', 'responsive'),
            'id' => 'group',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Multiple Categories', 'responsive'),
            'description' => __('Area 1 - sidebar.php', 'responsive'),
            'id' => 'multiple-categories',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));


    }

    add_action('widgets_init', 'royston_scouts_widgets_init');
?>
