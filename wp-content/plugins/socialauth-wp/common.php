<?php
//locating HybridAuth
if(!file_exists( dirname(__FILE__) . '/hybridauth/Hybrid/Auth.php')) {
    die( sprintf( __( "Sorry, but you can not install Plugin 'SocialAuth-WP'. It seems you missed to add 'hybrid auth' library with this plugin.") ));
}
define('SOCIALAUTH_WP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define(SOCIALAUTH_WP_HYBRIDAUTH_DIR_PATH, SOCIALAUTH_WP_PLUGIN_PATH . '/hybridauth/');

$HA_PROVIDER_CONFIG = array();
$HA_CONFIG = get_ha_config();

if(isset($HA_CONFIG) && is_array($HA_CONFIG)) {
    $HA_PROVIDER_CONFIG = $HA_CONFIG;
} else {
    $HA_PROVIDER_CONFIG = array();
}

function get_ha_config(){
    return include_once SOCIALAUTH_WP_HYBRIDAUTH_DIR_PATH . '/config.php';
}

function compare_displayOrder($a, $b)
{
    if(!isset($a['display_order']) || !isset($b['display_order']))
        return 0;
    if ($a['display_order'] == $b['display_order']) {
        return 0;
    }
    return ($a['display_order'] < $b['display_order']) ? -1 : 1;
}

function sendEmailVerificationEmail($to, $user_id, $emailVerificationHash, $subject= 'Email verification for new account', $message = null)
{
	$headers = "";
	$attachments = "";
	
	include_once dirname(__FILE__) . "/email_verification_template.php";
	
	wp_mail( $to, $subject, $message, $headers, $attachments );
}

function endAuthProcessAndRedirectToHomePage($user_home_page)
{
	$authDialogPosition = get_option('SocialAuth_WP_authDialog_location');
	if(!empty($authDialogPosition) && $authDialogPosition == 'page')
	{
		header('Location: ' . $user_home_page); die;
	}else {
		echo "<script type='text/javascript'>
                opener.location.href = '" . $user_home_page ."';
                close();
                </script>";
	}
}