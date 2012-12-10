<?php

$message = "";

$message.= "Hi User,\n";

$message.= "Welcome to ". get_site_url()."\n";

$message.= "\n";

$message.= "Please click following link to verify your e-mail, this is one time process";

$message.= "\n";

$message.= plugin_dir_url(__FILE__) . "/verifyEmail.php?validationHash=" . $emailVerificationHash . "&random_code=" . $user_id;
