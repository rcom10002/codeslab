<?php

$lang['error_field_email_missing']                        = "Email is missing";

$lang['error_field_username_missing']                     = "username is missing";
$lang['error_field_username_occupied']                    = "username is already occupied, please change another";
$lang['error_field_password_missing']                     = "password is missing";
$lang['error_field_password_not_match']                   = "password and password confirmation are not match";

$lang['mail_template_user_activation']                    = <<<EOD
<p>Hi {{USERNAME}}</p>
<p>Please access URL <a href="{{URL}}" target="_blank">{{URL}}</a> to activate your account!</p>
EOD;
?>
