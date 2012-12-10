<?php
$a = urldecode($_GET['redirect_to']);

$wp_load = dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php'; 
require_once($wp_load);

include_once 'common.php';

$user_id = get_current_user_id();
if ($user_id != 0)
{
    $provider = get_user_meta( $user_id, 'ha_login_provider', true );
}    
if(!isset($_GET['continue']) && !empty($provider))
{
    $url = plugin_dir_url(__FILE__) ."logout.php?redirect_to=" . urlencode($a) . "&continue=1";
?>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>WordPress Logout In progress</title>
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__); ?>assets/css/style.css" />
</head>
<body>
<div class="SocialAuth_WP">
    <p>You are about to log out from <a title="<?php echo get_site_url(); ?>" alt="<?php echo get_site_url(); ?>" href="<?php echo get_site_url(); ?>"><?php echo get_site_url(); ?></a> Don't forget to logout from `<?php echo $provider; ?>` account to completely end your session.</p>
    <a class="button" href="<?php echo $url; ?>" ><span>Continue</span></a> 
</div>
</body>
<?php     
} else {
    if(!empty($provider))
    {
        $SocialAuth_WP_providers = get_option('SocialAuth_WP_providers');
        if(is_array($SocialAuth_WP_providers) && count($SocialAuth_WP_providers))
        {
            $config = array();
            if(isset($SocialAuth_WP_providers[$provider])) {
                $config["base_url"]  = plugin_dir_url(__FILE__) . 'hybridauth/';
                $config["providers"] = array();
                //this si same as orig config, no need to amke config again
                $config["providers"][$provider] = $SocialAuth_WP_providers[$provider];
            } else {
                echo "Current Provider is unknowun to system.";
                exit;
            }
        
            $config["providers"][$provider] = $HA_PROVIDER_CONFIG['providers'][$provider];
            require_once( dirname(__FILE__) . "/hybridauth/Hybrid/Auth.php" );
            $hybridauth = new Hybrid_Auth( $config);
            Hybrid_Auth::storage()->delete( "hauth_session.$provider.is_logged_in" );
        }
    }
    $a = preg_replace("/amp\;/", "", $a);
    header('Location: ' . $a);
}    
