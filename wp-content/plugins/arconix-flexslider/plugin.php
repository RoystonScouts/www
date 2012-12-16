<?php
/*
  Plugin Name: Arconix FlexSlider
  Plugin URI: http://www.arconixpc.com/plugins/arconix-flexslider
  Description: A featured slider using WooThemes FlexSlider script.

  Author: John Gardner
  Author URI: http://www.arconixpc.com

  Version: 0.5.3

  License: GNU General Public License v2.0
  License URI: http://www.opensource.org/licenses/gpl-license.php
 */

class Arconix_FlexSlider {

    /**
     * Boolean for loading the javascript
     *
     * @var boolean true|false
     * @since 0.5
     */
    public static $load_flex_js;

    /**
     * Constructor
     *
     * @since 0.5
     */
    function __construct() {
        $this->constants();
        $this->hooks();
    }

    /**
     * Define the constants
     *
     * @since 0.5
     */
    function constants() {
        define( 'ACFS_VERSION', '0.5.3');
        define( 'ACFS_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
        define( 'ACFS_INCLUDES_URL', trailingslashit( ACFS_URL . 'includes' ) );
        define( 'ACFS_IMAGES_URL', trailingslashit( ACFS_URL . 'images' ) );
        define( 'ACFS_JS_URL', trailingslashit( ACFS_INCLUDES_URL . 'js' ) );
        define( 'ACFS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'ACFS_INCLUDES_DIR', trailingslashit( ACFS_DIR . 'includes' ) );
    }

    /**
     * Run the necessary functions and pull in the necessary supporting files
     *
     * @since 0.5
     */
    function hooks() {
        /* Set up a prefix to minimize conflicts */
        $prefix = 'acfs_';

        add_action( 'wp_enqueue_scripts', $prefix . 'load_scripts' );
        add_action( 'init', $prefix . 'register_shortcodes' );
        add_action( 'widgets_init', $prefix . 'create_widget' );
        add_action( 'wp_dashboard_setup', $prefix . 'register_dashboard_widget' );
        add_action( 'wp_footer', $prefix . 'print_scripts' );

        require_once( ACFS_INCLUDES_DIR . 'functions.php' );
        require_once( ACFS_INCLUDES_DIR . 'widget.php' );
        if( is_admin() )
            require_once( ACFS_INCLUDES_DIR . 'admin.php' );
    }

}

new Arconix_FlexSlider;
?>