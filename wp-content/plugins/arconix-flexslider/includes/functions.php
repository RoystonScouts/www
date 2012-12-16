<?php

/**
 * Load the necessary javascript and css
 * These files can be overwritten by including files in your theme's directory
 *
 * @since 0.1
 * @version 0.5.1
 */
function acfs_load_scripts() {
    /* Provide script registration args so they can be filtered if necessary */
    $script_args = apply_filters( 'arconix_flexslider_reg', array(
        'url' => ACFS_JS_URL . 'jquery.flexslider-min.js',
        'ver' => '1.8',
        'dep' => 'jquery'
    ) );

    /* Register the flexslider script using those args */
    wp_register_script( 'flexslider', $script_args['url'], array( $script_args['dep'] ), $script_args['ver'], true );

    /* Allow user to override javascript by including his own */
    if( file_exists( get_stylesheet_directory() . '/arconix-flexslider.js' ) ) {
	wp_register_script( 'arconix-flexslider-js', get_stylesheet_directory_uri() . '/arconix-flexslider.js', array( 'flexslider' ), ACFS_VERSION, true );
    }
    elseif( file_exists( get_template_directory() . '/arconix-flexslider.js' ) ) {
	wp_register_script( 'arconix-flexslider-js', get_template_directory_uri() . '/arconix-flexslider.js', array( 'flexslider' ), ACFS_VERSION, true );
    }
    else {
	wp_register_script( 'arconix-flexslider-js', ACFS_JS_URL . 'flexslider.js', array( 'flexslider' ), ACFS_VERSION, true );
    }

    /* Allow user to override css by including his own */
    if( file_exists( get_stylesheet_directory() . '/arconix-flexslider.css' ) ) {
	wp_enqueue_style( 'arconix-flexslider', get_stylesheet_directory_uri() . '/arconix-flexslider.css', array(), ACFS_VERSION );
    }
    elseif( file_exists( get_template_directory() . '/arconix-flexslider.css' ) ) {
	wp_enqueue_style( 'arconix-flexslider', get_template_directory_uri() . '/arconix-flexslider.css', array(), ACFS_VERSION );
    }
    else {
	wp_enqueue_style( 'arconix-flexslider', ACFS_INCLUDES_URL . 'flexslider.css', array(), ACFS_VERSION );
    }
}

/**
 * Check the state of the variable. If true, load the registered javascript
 *
 * @since 0.5
 */
function acfs_print_scripts() {
    if( !Arconix_FlexSlider::$load_flex_js )
        return;

    wp_print_scripts( 'arconix-flexslider-js' );
}

/**
 * Flexslider Shortcode
 *
 * @param type $atts
 * @param type $content self-enclosing shortcode
 * @since 0.5
 */
function flexslider_shortcode( $atts, $content = null ) {
    $query_defaults = array(
        'post_type' => 'post',
        'category_name' => '',
        'tag' => '',
        'posts_per_page' => '5',
        'orderby' => 'date',
        'order' => 'DESC',
        'image_size' => 'medium',
        'image_link' => 1,
        'show_caption' => 'none',
        'show_content' => 'none'
    );

    $args = shortcode_atts( $query_defaults, $atts );

    return get_flexslider_query( $args );
}

/**
 * Register the plugin shortcode
 *
 * @since 0.5
 */
function acfs_register_shortcodes() {
    add_shortcode( 'ac-flexslider', 'flexslider_shortcode' );
}

/**
 * Returns flexslider query results
 *
 * @param array $args
 * @since 0.5
 */
function get_flexslider_query( $args = '' ) {
    /* Load the javascript */
    Arconix_FlexSlider::$load_flex_js = true;

     /* Parse incomming $args into an array and merge it with $defaults */
    $query_defaults = array(
        'post_type' => 'post',
        'category_name' => '',
        'tag' => '',
        'posts_per_page' => '5',
        'orderby' => 'date',
        'order' => 'DESC',
        'image_size' => 'medium',
        'image_link' => 1,
        'show_caption' => 'none',
        'show_content' => 'none'
    );
    $args = wp_parse_args( $args, $query_defaults );

    /* Declare each item in $args as its own variable */
    extract( $args, EXTR_SKIP );

    $query_args = array(
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
        'category_name' => $category_name,
        'tag' => $tag,
        'orderby' => $orderby,
        'order' => $order,
        'meta_key' => '_thumbnail_id' // Should pull only content with featured images
    );

    /* Allow the query args to be filtered */
    $query_args = apply_filters( 'arconix_flexslider_query_args', $query_args );

    $fquery = new WP_Query( $query_args );

    $return = '';

    if ( $fquery->have_posts() ) {
        $return .= '<div class="flex-container">
            <div class="flexslider">
            <ul class="slides">';

        while ( $fquery->have_posts() ) : $fquery->the_post();

            $return .= '<li>';

            if( 'none' != $show_content )
                $return .= '<div class="flex-image-wrap">';

            if( $image_link )
                $return .= '<a href="' . get_permalink() . '" rel="bookmark">';

            $return .= get_the_post_thumbnail( get_the_ID(), $image_size );

            switch( $show_caption ) {
                case 'post title':
                case 'post-title':
                case 'posttitle':
                    $return .= '<p class="flex-caption">' . get_the_title() . '</p>';
                    break;

                case 'image title':
                case 'image-title':
                case 'imagetitle':
                    global $post;
                    $return .= '<p class="flex-caption">' . get_post( get_post_thumbnail_id( $post->ID ) )->post_title . '</p>';
                    break;

                case 'image caption':
                case 'image-caption':
                case 'imagecaption':
                    global $post;
                    $return .= '<p class="flex-caption">' . get_post( get_post_thumbnail_id( $post->ID ) )->post_excerpt . '</p>';
                    break;

                default:
                    break;
            }

            if( $image_link )
                $return .= '</a>';

            if( 'none' != $show_content )
                $return .= '</div>';

            if( 'none' != $show_content ) {
                $return .= '<div class="flex-content-wrap">';
                $return .= '<div class="flex-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></div>';
                $return .= '<div class="flex-content">';

                switch( $show_content ) {
                    case 'content':
                        $return .= get_the_content();
                        break;

                    case 'excerpt':
                        $return .= get_the_excerpt();
                        break;

                    default: // just in case
                        break;
                }

                $return .= '</div>';
            }

            $return .= '</li>';

        endwhile;

        $return .= '</ul></div></div>';
    }
    wp_reset_postdata();

    return $return;
}

/**
 * Display flexslider query results
 *
 * @param type $args
 * @since 0.5
 */
function flexslider_query( $args = '' ) {
    echo get_flexslider_query( $args );
}

?>