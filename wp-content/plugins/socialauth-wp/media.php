<?php
add_action( 'login_head', 'SocialAuth_WP_add_javascripts' ); // enable this to add plugin javascript on login page only
add_action( 'wp_enqueue_scripts', 'SocialAuth_WP_add_javascripts' );//comment this to remove plugin javascript inclusion from all pages.
function SocialAuth_WP_add_javascripts(){
    wp_print_scripts( "jquery" );
    if( !wp_script_is( 'SocialAuth_WP', 'registered' ) ) {
        wp_register_script(
            "SocialAuth_WP",
            plugin_dir_url(__FILE__) . "assets/js/connect.js"
        );
    }
    wp_print_scripts( "SocialAuth_WP" );
}
