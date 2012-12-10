<?php
$wp_load = dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php'; 
require_once($wp_load);
include_once 'common.php';
$SocialAuth_WP_user_home = get_option('SocialAuth_WP_user_home_page');
$url = !empty($SocialAuth_WP_user_home)? $SocialAuth_WP_user_home : get_site_url();


if(isset($_REQUEST['validationHash'])&& isset($_REQUEST['random_code']))
{
	$emailValidationHash = $_REQUEST['validationHash'];
	$user_id = $_REQUEST['random_code'];
	$isUserEmailValidated = get_user_meta( $user_id, 'email_verification_hash', true );
	if($isUserEmailValidated == $emailValidationHash)
	{
		update_user_meta( $user_id, 'email_verification_hash', 'validated');
?>
	    <head>
	    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	    <title>WordPress Logout In progress</title>
	    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__); ?>assets/css/style.css" />
		</head>
		<body>
		<div class="SocialAuth_WP">
		    <p>Congratulations !!! Email verification is now complete.</p> 
		    <a class="button" href="<?php echo $url; ?>" ><span>Continue</span></a> 
		</div>
		</body> 
		
<?php
	}
	else
	{
?>
	<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>WordPress Logout In progress</title>
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__); ?>assets/css/style.css" />
	</head>
	<body>
	<div class="SocialAuth_WP">
	    <p>Oops !!! Email verification failed. Please try again later.</p> 
	    <a class="button" href="<?php echo $url; ?>" ><span>Continue</span></a> 
	</div>
	</body> 
<?php
	}
}
else
{
?>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>WordPress Logout In progress</title>
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__); ?>assets/css/style.css" />
</head>
<body>
<div class="SocialAuth_WP">
    <p>Oops !!! It seems you will need to verify your email with us before you can get in. This is one time process and site administrator has enbaled this to avoid spamming of accounts.</p>
    <p>An e-mail has already been sent your email address (from your profile with the provider which you just used to conenct). Please validate your email and come back here to login.</p>
    <a class="button" href="<?php echo $url; ?>" ><span>Continue</span></a> 
</div>
</body>
<?php 
}
?>    
