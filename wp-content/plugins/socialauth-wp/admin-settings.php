<?php
// create custom plugin settings menu
add_action('admin_menu', 'SocialAuth_WP_admin_menu' );

function SocialAuth_WP_admin_menu(){
    //create options page
    add_options_page(
        'Social Auth PHP',
        'SocialAuth-WordPress',
        'manage_options',
        'socialauth-wp-settings',
        'SocialAuth_WP_render_settings_page'
    );

    //call register settings function
    add_action(
       'admin_init',
       'SocialAuth_WP_register_settings'
    );

    //register java scripts
    add_action(
        'admin_print_scripts-settings_page_socialauth-wp-settings',
        'SocialAuth_WP_scripts'
    );
}

function SocialAuth_WP_register_settings() {
    //register our settings
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_user_role');
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_authDialog_location');
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_user_home_page');
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_providers');
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_profile_picture_source');
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_providerIcons_host_pages');
    register_setting( 'SocialAuth-WP-settings', 'SocialAuth_WP_validate_newUser_email');
}

function SocialAuth_WP_scripts()
{
    echo '<link type="text/css" rel="stylesheet" href="' . plugin_dir_url(__FILE__) . 'assets/css/display_order.css" />' . "\n";

    //We can include as many Javascript files as we want here.
    wp_enqueue_script(
        "SocialAuth_WP_settings_script",
         plugin_dir_url(__FILE__) . "assets/js/settings.js",
         array('jquery')
    );
    
    wp_enqueue_script(
        "SocialAuth_WP_settings_script_for_display_order",
         plugin_dir_url(__FILE__) . "assets/js/display_order.js",
         array('jquery','jquery-ui-sortable')
    );
}

function SocialAuth_WP_render_settings_page(){
    global $HA_PROVIDER_CONFIG;

    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
    $roles = $wp_roles->get_names();
    $SocialAuth_WP_providers = get_option('SocialAuth_WP_providers');

?>
    <div class="wrap">
        <div class="icon32" id="icon-options-general"><br></div>
        <h2><?php _e('SocialAuth-WordPress Settings', 'SocialAuth-WP'); ?></h2>
    
        <form method="post" action="options.php">
        <?php settings_fields( 'SocialAuth-WP-settings' ); ?>
        <?php //do_settings( 'SocialAuth-WP-settings' ); ?>

            <h3><?php _e('Accessibility', 'SocialAuth-WP'); ?></h3>
            <table class="form-table">
                <?php if(isset($roles) && count($roles)){ ?>
                <tr valign="top">
                    <th scope="row"><label for ="SocialAuth_WP_user_role" ><?php _e('User Role', 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <select name="SocialAuth_WP_user_role">
                        <?php 
                            $selected_role = get_option('SocialAuth_WP_user_role');
                            if(empty($selected_role))
                            {
                                $selected_role = 'contributor';
                            }
                              foreach($roles as $key => $role)
                              {
                                  if($selected_role == $key) 
                                      echo "<option value='" .$key . "' selected='selected'>" .$role . "</option>";
                                  else 
                                      echo "<option value='" .$key . "'>" .$role . "</option>";
                              }
                          ?>
                        
                        </select>
                        <span class="description">Users signing in Social Auth Login provider will get access rights from this role.</span>
                    </td>
                </tr>
                <?php } ?>
                 <tr valign="top">
                    <th scope="row"><label for ="SocialAuth_WP_authDialog_location" ><?php _e('Authentication Happens on', 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <select name="SocialAuth_WP_authDialog_location">
                        <?php 
                            $authDialogPositions = array('popup' => 'In a Pop-up Window', 'page' => 'On Same Page');
                            $authDialogPosition = get_option('SocialAuth_WP_authDialog_location');
                            if(empty($authDialogPosition))
                            {
                                $authDialogPosition = 'popup';
                            }
                              foreach($authDialogPositions as $key => $position)
                              {
                                  if($authDialogPosition == $key) 
                                      echo "<option value='" .$key . "' selected='selected'>" .$position . "</option>";
                                  else 
                                      echo "<option value='" .$key . "'>" .$position . "</option>";
                              }
                          ?>
                        
                        </select>
                        <span class="description">Control how and where authentication dialog will appear.</span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for ="SocialAuth_WP_profile_picture_source" ><?php _e('Profile Picture/Avatar Comes From', 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <select name="SocialAuth_WP_profile_picture_source">
                        <?php 
                            $profilePicSources = array('authenticatingProvider' => 'Authenticating Provider', 'gravatar' => 'Gravatar');
                            $profilePicSource = get_option('SocialAuth_WP_profile_picture_source');
                            if(empty($profilePicSource))
                            {
                                $profilePicSource = 'providerImage';
                            }
                              foreach($profilePicSources as $key => $position)
                              {
                                  if($profilePicSource == $key) 
                                      echo "<option value='" .$key . "' selected='selected'>" .$position . "</option>";
                                  else 
                                      echo "<option value='" .$key . "'>" .$position . "</option>";
                              }
                          ?>
                        
                        </select>
                        <span class="description">Control from where profile pic/avatar comes from.</span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for ="SocialAuth_WP_user_home_page" ><?php _e('Home Page', 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <input class="regular-text" type="text" name="SocialAuth_WP_user_home_page" value="<?php echo get_option('SocialAuth_WP_user_home_page'); ?>"/>
                        <span class="description">This is the very first page user will go to after successful login.</span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for ="SocialAuth_WP_provider_display_order" ><?php _e('Provider Display Order', 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <?php $images_url = plugin_dir_url(__FILE__) .'assets/images/'; ?>
                        <ul id="providerlist" class="ui-sortable">
                        <?php 
                        // sort by display_order
                        $providersDataForDisplayOrder = empty($SocialAuth_WP_providers)? $HA_PROVIDER_CONFIG['providers']: $SocialAuth_WP_providers;
                        uasort($providersDataForDisplayOrder, 'compare_displayOrder');
                        foreach($providersDataForDisplayOrder as $name => $details) { 
                            //$details = $HA_PROVIDER_CONFIG['providers'][$name];
                        ?>
                            <li class="<?php echo $name; ?>">
                                <img alt="<?php echo $name; ?>" src="<?php echo $images_url . strtolower($name) . '_32.png'; ?>" />
                            </li>
                        <?php
                        }
                        ?>
                        </ul>
                        <span class="description">Drag and drop icons to arrange them, and they will appear on login page in same order.</span>
                    </td>
                </tr>
                <tr valign="top">
                	<?php 
                		$pages = array('register', 'comment');
                		$enabledPages = get_option('SocialAuth_WP_providerIcons_host_pages');
                	?>
                    <th scope="row"><label for ="SocialAuth_WP_providerIcons_host_pages" ><?php _e('Provider Icons Visible on', 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <ul id="providerlist">
                        	<?php foreach($pages as $page) {?>
                        	    <?php $isChecked = (isset($enabledPages[$page]) && ($enabledPages[$page] == $page))? "checked='checked'": ""; ?>
                        		<li><input type="checkbox" name="SocialAuth_WP_providerIcons_host_pages[<?php echo $page;?>]" value="<?php echo $page;?>" <?php echo $isChecked;?> /> <?php echo ucfirst($page);?> Form</li>
                        	<?php }?>
                        </ul>
                        <span class="description">Enable/Disable visibility of Provider Icons on various pages.</span>
                    </td>
                </tr>
                
                <tr valign="top">
                	<?php 
                		$validateEmail = get_option('SocialAuth_WP_validate_newUser_email');
                	?>
                    <th scope="row"><label for ="SocialAuth_WP_validate_newUser_email" ><?php _e("Validate New User's E-mail", 'SocialAuth_WP'); ?></label></th>
                    <td>
                        <?php $isChecked = (!empty($validateEmail) && ($validateEmail == 'validate'))? "checked='checked'": ""; ?>
                        <input type="checkbox" name="SocialAuth_WP_validate_newUser_email" value="validate" <?php echo $isChecked;?> /> Yes, force user for email validation
                        <span class="description">This will add an another step of email validation for new users before they can get in. You will need to enable some settings in you wordpress installation so that emails can be send. If login provider doesn not share email, this option has no affect at all.</span>
                    </td>
                </tr>
            </table>

            <h3><?php _e('Login Providers', 'SocialAuth-WP'); ?></h3>
            <table class="form-table">
                <?php
            foreach($HA_PROVIDER_CONFIG['providers'] as $provider => $settings) { 
            ?>
                <tr valign="top">
                    <th><label><?php _e($provider, 'SocialAuth-WP'); ?></label></th>
                    <td>
                        <?php
                        if(isset($settings['enabled'])) { ?>
                            <fieldset>
                                <input type="hidden" class="<?php echo $provider; ?>" name="SocialAuth_WP_providers[<?php echo $provider; ?>][display_order]" value="<?php echo isset($SocialAuth_WP_providers[$provider]['display_order'])? $SocialAuth_WP_providers[$provider]['display_order'] : ""; ?>" />
                                <p><label><input type="radio" <?php echo (!isset($SocialAuth_WP_providers[$provider]['enabled']) || ($SocialAuth_WP_providers[$provider]['enabled'] == 0))? 'checked=\'checked\'' : ''; ?> class="SocialAuth_WP_adaptor_status" value="0" name="SocialAuth_WP_providers[<?php echo $provider ?>][enabled]">Disabled</label></p>
                                <p><label><input type="radio" <?php echo (isset($SocialAuth_WP_providers[$provider]['enabled']) && ($SocialAuth_WP_providers[$provider]['enabled'] == 1))? 'checked=\'checked\'' : ''; ?> class="SocialAuth_WP_adaptor_status" value="1" name="SocialAuth_WP_providers[<?php echo $provider ?>][enabled]">Enabled</label></p>
                                <ul>
                                    
                                    <?php if(isset($settings['keys']) && is_array($settings['keys']) && isset($settings['keys']['id'])) {?>
                                        <li>
                                            <label for="">
                                                <?php _e('Redirect URI:', 'new_auth'); ?>
                                                <span><?php echo plugin_dir_url(__FILE__) . 'hybridauth/?hauth.done=' . $provider; ?></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for ="SocialAuth_WP_providers[<?php echo $provider; ?>][keys][id]" >
                                                 <?php _e('App ID:', 'new_auth'); ?>
                                                 <input class="regular-text" type="text" name="SocialAuth_WP_providers[<?php echo $provider; ?>][keys][id]" value="<?php echo isset($SocialAuth_WP_providers[$provider]['keys']['id'])? $SocialAuth_WP_providers[$provider]['keys']['id'] : ""; ?>" />
                                            </label>
                                        </li>
                                    <?php } ?>
                                    <?php if(isset($settings['keys']) && is_array($settings['keys']) && isset($settings['keys']['key'])) {?>
                                        <li>
                                            <label for="">
                                                <?php _e('Redirect URI:', 'new_auth'); ?>
                                                <span><?php echo plugin_dir_url(__FILE__) . 'hybridauth/?hauth.done=' . $provider; ?></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for ="SocialAuth_WP_providers[<?php echo $provider; ?>][keys][key]" >
                                                <?php _e('API Key:', 'new_auth'); ?>
                                                <input class="regular-text" type="text" name="SocialAuth_WP_providers[<?php echo $provider; ?>][keys][key]" value="<?php echo isset($SocialAuth_WP_providers[$provider]['keys']['key'])? $SocialAuth_WP_providers[$provider]['keys']['key'] : ""; ?>" />
                                             </label>
                                        </li>
                                    <?php } ?>
                                    <?php if(isset($settings['keys']) && is_array($settings['keys']) && isset($settings['keys']['secret'])) {?>
                                        <li>
                                            <label for ="SocialAuth_WP_providers[<?php echo $provider; ?>][keys][secret]" >
                                                 <?php _e('App Secret:', 'SocialAuth_WP'); ?>
                                                 <input class="regular-text" type="text" name="SocialAuth_WP_providers[<?php echo $provider; ?>][keys][secret]" value="<?php echo isset($SocialAuth_WP_providers[$provider]['keys']['secret'])? $SocialAuth_WP_providers[$provider]['keys']['secret'] : ""; ?>" />
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </fieldset>
                        <?php }?>
                    </td>
                </tr>
            <?php 
            }
            ?>
            </table>
            <span class="description">By enabling/disbaling you can control which login provider should appear on login screen. If you choose to enable a login provider you will need to create API Key and APP ID and APP secret from respective login provider's site. Enter those values above and you are done !!!</span>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php } ?>
