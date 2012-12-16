<?php
/**
 * Returns registered image sizes.
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes
 * @return array Two-dimensional, with width, height and crop sub-keys
 * @since 0.1
 */
function get_image_sizes() {

    global $_wp_additional_image_sizes;
    $additional_sizes = array();

    $builtin_sizes = array(
	'thumbnail' => array(
	    'width' => get_option( 'thumbnail_size_w' ),
	    'height' => get_option( 'thumbnail_size_h' ),
	    'crop' => get_option( 'thumbnail_crop' ),
	),
        'medium' => array(
	    'width' => get_option( 'medium_size_w' ),
	    'height' => get_option( 'medium_size_h' ),
	),
        'large' => array(
	    'width' => get_option( 'large_size_w' ),
	    'height' => get_option( 'large_size_h' ),
	)
    );

    if( $_wp_additional_image_sizes )
	$additional_sizes = $_wp_additional_image_sizes;

    return array_merge( $builtin_sizes, $additional_sizes );
}

/**
 * Return a modified list of Post Types
 *
 * @return type array Post Types
 * @since 0.1
 * @version 0.5
 */
function get_modified_post_type_list() {
    $post_types = get_post_types( '', 'names' );

    /* Post types we want excluded from the drop down */
    $excl_post_types = apply_filters( 'acfs_exclude_post_types',
        array(
            'revision',
            'nav_menu_item',
            'wpcf7_contact_form'
        )
    );

    /** Loop through and exclude the items in the list */
    foreach( $excl_post_types as $excl_post_type ) {
        if( isset( $post_types[$excl_post_type] ) ) unset( $post_types[$excl_post_type] );
    }

    return $post_types;
}

/**
 * Register the dashboard widget
 *
 * @since 0.1
 */
function acfs_register_dashboard_widget() {
    wp_add_dashboard_widget( 'ac-flexslider', 'Arconix FlexSlider', 'acfs_dashboard_widget_output' );
}

/**
 * Output for the dashboard widget
 *
 * @since 0.1
 * @version 0.5
 */
function acfs_dashboard_widget_output() {
    echo '<div class="rss-widget">';

    wp_widget_rss_output( array(
        'url' => 'http://arconixpc.com/tag/arconix-flexslider/feed', // feed url
        'title' => 'Arconix FlexSlider Posts', // feed title
        'items' => 3, // how many posts to show
        'show_summary' => 1, // display excerpt
        'show_author' => 0, // display author
        'show_date' => 1 // display post date
    ) );

    echo '<div class="acfs-widget-bottom"><ul>';
    ?>
        <li><a href="http://arcnx.co/afswiki"><img src="<?php echo ACFS_IMAGES_URL . 'page-16x16.png'; ?>">Documentation</a></li>
        <li><a href="http://arcnx.co/afshelp"><img src="<?php echo ACFS_IMAGES_URL . 'help-16x16.png'; ?>">Support Forum</a></li>
        <li><a href="http://arcnx.co/afstrello"><img src="<?php echo ACFS_IMAGES_URL . 'trello-16x16.png'; ?>">Dev Board</a></li>
        <li><a href="http://arcnx.co/afssource"><img src="<?php echo ACFS_IMAGES_URL . 'github-16x16.png'; ?>">Source Code</a></li>
    <?php
    echo '</ul></div></div>';

    // handle the styling
    echo '<style type="text/css">
            #ac-flexslider .rsssummary { display: block; }
            #ac-flexslider .acfs-widget-bottom { border-top: 1px solid #ddd; padding-top: 10px; text-align: center; }
            #ac-flexslider .acfs-widget-bottom ul { list-style: none; }
            #ac-flexslider .acfs-widget-bottom ul li { display: inline; padding-right: 20px; }
            #ac-flexslider .acfs-widget-bottom img { padding-right: 3px; vertical-align: middle; }
        </style>';
}

?>