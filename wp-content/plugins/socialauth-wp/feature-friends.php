<?php
function SocialAuth_WP_contacts(){
    ini_set( "display_errors", 0);
    $noContactMsg = "Either you do not have any contact(s) or your login provider is not supporting this feature at the moment.";
    echo '<div class="wrap">';
    echo '<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>';
    echo "<h2>My Contacts</h2> <br/>";
    
    // load hybridauth
    require_once( dirname(__FILE__) . "/hybridauth/Hybrid/Auth.php" );
    // load wp-load.php
    $wp_load = dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php'; 
    require_once($wp_load);
    include_once 'common.php';
    
    $user_id = get_current_user_id();
    $provider = null;
    if ($user_id != 0)
    {
        $provider = get_user_meta( $user_id, 'ha_login_provider', true );
    }
    // selected provider name
    if($provider == null)
    {
        echo $noContactMsg;
        return;
    }
    //global $HA_PROVIDER_CONFIG;
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
    else {
        echo "It seems SocialAuth-WP plugin is not configured properly. Please contact site administrator.";
        return;
    }
    
    // create an instance for Hybridauth
    $hybridauth = new Hybrid_Auth( $config );
    $adapter = null;
    // try to check is provider still authenticated
    if($hybridauth->isConnectedWith($provider))
    {
        $adapter = $hybridauth->getAdapter( $provider);
    }
    else {
        echo "It seems your session with Login provider has expired. Please logout and login again to system to continue.";
        return;
    }
    $contacts = array();
    try {
        $contacts = $adapter->getUserContacts();
    }
    catch (exception $e)
    {
        echo $noContactMsg;
        return;
    }
    
    if(count($contacts))
    {
      require SOCIALAUTH_WP_PLUGIN_PATH . '/pagination.class.php';
      
      $pagination = new pagination($contacts,  (isset($_GET['pageNum']) ? $_GET['pageNum'] : 1), 15);
      $ContactPages = $pagination->getResults();
      
      $tbHeaders = array('Name', 'Profile URL', 'Email');
    ?>
        <?php
    if (count($ContactPages) != 0) {
        echo $pageNumbers = '<div class="numbers" style="text-align:right;" >'.$pagination->getLinks(array('page' => 'SocialAuth-WP-contacts')).'</div>';
    ?>
    
    <table class="wp-list-table widefat fixed users">
    <thead>
    <tr>
        <?php 
            foreach($tbHeaders as $header)
            {
                echo '<th style="" class="manage-column column-username" id="" scope="col">' . $header . '</th>'; 
            }
        ?>
        
        </tr>
    </thead>
    
    <tfoot>
    <tr>
        <?php 
            foreach($tbHeaders as $header)
            {
                echo '<th style="" class="manage-column column-username" id="" scope="col">' . $header . '</th>'; 
            }
        ?>
        
        </tr>
    </tfoot>
    
    <tbody class="list:user" id="the-list">
    <?php foreach($ContactPages as $index => $contact) {
        $alternate = (($index %2) == 0)? "alternate": "";
    ?>
    
    <tr class="<?php echo $alternate; ?>" id="user-12">
        <td class="column-username">
            <?php if(strlen($contact->photoURL)) {?>
            <img height="32" width="32" src="<?php echo $contact->photoURL; ?>" >
            <?php } else  {?>
            <img height="32" width="32" class="avatar avatar-32 photo" src="http://0.gravatar.com/avatar/8af77eb212190822af34f1725a01922d?s=32&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D32&amp;r=G" alt="">
            
            <?php } ?>
            <?php echo   $contact->displayName; ?>
        </td>
                
        <td class="posts">
            <a href="<?php echo $contact->profileURL;?>">
                <?php echo $contact->profileURL;?>
            </a>
        </td>
        
        <td class="posts">
            <?php echo (empty($contact->email))? "&nbsp;" : $contact->email; ?>
        </td>
    </tr>
    
    <?php } ?>
    </tbody>
    </table>
    <?php
    echo $pageNumbers = '<div class="numbers" style="text-align:right;" >'.$pagination->getLinks(array('page' => 'SocialAuth-WP-contacts')).'</div>';
    }
    ?>
    <?php }
    else {
        echo $noContactMsg;
        return;
    }
    echo '</div>';
}

function my_plugin_menu() {
    $images_url =  plugin_dir_url(__FILE__) . 'assets/images/';
    add_menu_page('My Contacts', 'My Contacts', 'read', 'SocialAuth-WP-contacts', 'SocialAuth_WP_contacts', $images_url . 'friends.jpg');
}

add_action('admin_menu', 'my_plugin_menu');