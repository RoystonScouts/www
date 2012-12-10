<?php

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    if( isset( $_GET["provider"] ) ){
        try{
            // load hybridauth
            require_once( dirname(__FILE__) . "/hybridauth/Hybrid/Auth.php" );
            // load wp-load.php
            $wp_load = dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php'; 
            require_once($wp_load);

            include_once 'common.php';

            // selected provider name
            $provider = @ trim( strip_tags( $_GET["provider"] ) );

            // build required configuratoin for this provider
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
                    return;
                }
            }
            else
            {
                echo "SocialAuth-WP plugin is not configured properly. Contact Site administrator.";
                return;
            }
            // create an instance for Hybridauth
            $hybridauth = new Hybrid_Auth( $config );
            //set return url here
            //OpenId is a special case
            $adapter = null;
            $emailVerificationHash = uniqid();
            $validateEmail = get_option('SocialAuth_WP_validate_newUser_email');
            $user_data = array();
            if($provider == 'OpenID') 
            {
                $adapter = $hybridauth->authenticate( $provider, array("openid_identifier" => 'https://openid.stackexchange.com'));
            }
            else
            {
                $adapter = $hybridauth->authenticate( $provider);
            }
            $ha_user_profile = $adapter->getUserProfile();
            if( ! isset( $user_profile ) ){
                $user_id = get_user_by_meta( $provider, $ha_user_profile->identifier);
            }
            
            if ( $user_id ) {
                $user_data  = get_userdata( $user_id );
                $user_login = $user_data->user_login;
                $currentEmailVerificationHash = get_user_meta( $user_id, 'email_verification_hash', true );
                if(!empty($currentEmailVerificationHash))
                {
                	$emailVerificationHash = $currentEmailVerificationHash;
                }	
                 
            // User not found by provider identity, check by email
            } elseif ( $user_id = email_exists( $ha_user_profile->email ) ) {
                //update_user_meta( $user_id, $provider, $ha_user_profile->identifier );
                $user_data  = get_userdata( $user_id );
                $user_login = $user_data->user_login;
            	$currentEmailVerificationHash = get_user_meta( $user_id, 'email_verification_hash', true );
                if(!empty($currentEmailVerificationHash))
                {
                	$emailVerificationHash = $currentEmailVerificationHash;
                }
            } else { // Create new user and associate provider identity
                $displayNameArray = explode(" ", $ha_user_profile->displayName);

                $firstname =  $ha_user_profile->identifier;
                $lastname = "";
                if(isset($displayNameArray[0]) && count($displayNameArray[0])) {
                    $firstname = $displayNameArray[0];
                }
                
                if(isset($displayNameArray[1]) && count($displayNameArray[1])) {
                    $lastname = $displayNameArray[1];
                }
                
                $user_login = strtolower("ha_". $firstname);
                if ( username_exists( $user_login ) )
                {
                     $user_login = $user_login . rand();
                }
                
                $user_data = array(
                    'user_login' => ($ha_user_profile->email)? $ha_user_profile->email : $user_login,
                    'user_email' => ($ha_user_profile->email)? $ha_user_profile->email : $user_login . "@test.com",
                    'first_name' => ($ha_user_profile->firstName)? $ha_user_profile->firstName : $firstname,
                    'last_name' => ($ha_user_profile->lastName)? $ha_user_profile->lastName : $lastname,
                    'user_url' =>  ($ha_user_profile->profileURL)? $ha_user_profile->profileURL : "",
                    'user_pass' => wp_generate_password() );

                $SocialAuth_WP_user_role = get_option('SocialAuth_WP_user_role');
                if(!empty($SocialAuth_WP_user_role))
                {
                    $user_data['role'] = $SocialAuth_WP_user_role;
                }

                //$emailVerificationHash = (!empty($validateEmail) && $validateEmail == 'validate')? 'validated': $emailVerificationHash;
               
                // Create a new user
                $user_id = wp_insert_user( $user_data );
            }
            if ( $user_id && is_integer( $user_id ) ) {
                update_user_meta( $user_id, 'ha_login_provider', $provider );
                update_user_meta( $user_id, 'profile_image_url', $ha_user_profile->photoURL);
                update_user_meta( $user_id, 'email_verification_hash', $emailVerificationHash);
            }
            
            if(!empty($validateEmail) && $validateEmail == 'validate' && $emailVerificationHash != 'validated')
            {
            	$userEmail = is_array($user_data)? $user_data['user_email']: $user_data->user_email;
            	sendEmailVerificationEmail($userEmail, $user_id, $emailVerificationHash);
            	endAuthProcessAndRedirectToHomePage(plugin_dir_url(__FILE__) . 'verifyEmail.php');
            	die;
            }
            
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user_id );

            $SocialAuth_WP_user_home = get_option('SocialAuth_WP_user_home_page');
            $user_home_page = !empty($SocialAuth_WP_user_home)? $SocialAuth_WP_user_home : get_site_url();
            endAuthProcessAndRedirectToHomePage($user_home_page);
        }
        catch( Exception $e ){
            $message = "Some strange error occured, Please try again Later...";

            switch( $e->getCode() ){
                case 0 : $message = "Some strange error occured."; break;
                case 1 : $message = "It seems Hybriauth is not configuration properly."; break;
                case 2 : $message = "It seems some details are missing in provider configuration."; break;
                case 3 : $message = "It seems login provider is Unknown or Disabled."; break;
                case 4 : $message = "It seems you forgot yo mention provider application credentials."; break;
                case 5 : $message = "Authentification has failed. Either the user has canceled the authentication or the provider refused the connection."; break;
            }
            
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__); ?>assets/css/style.css" />
<div class="SocialAuth_WP SocialAuth_WP_error">
    <p class='highlighted'>There was some unexpected error, when trying to login with <?php echo $provider; ?></p>
    <p class='highlighted'>Followin are the details of error : </p> 
    <p><?php echo $message; ?></p>
    <p><?php echo 'Error reason: ' .$e->getMessage(); ?></p>
    <?php if(!empty($authDialogPosition) && $authDialogPosition == 'page') { ?>
        <p class="">&laquo; <a href="<?php echo wp_get_referer(); ?>" >Back to Login Page</a></p>
    <?php } ?>
</div>
<?php
        die();
    }
    }
    else
    {
        ?>
        <p>There was some unexpected error, when trying to login with <?php echo $provider; ?></p>
        <?php 
    }