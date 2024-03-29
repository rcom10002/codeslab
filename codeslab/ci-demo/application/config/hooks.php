<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller'][] = array(
	'class' => '',
	'function' => 'access_control_check',
	'filename' => 'access_control_check.php',
	'filepath' => 'hooks'
	);

// encrypt output with base64
$hook['display_override'][] = array(
	'class' => '',
	'function' => 'base64encrypt',
	'filename' => 'base64encrypt.php',
	'filepath' => 'hooks'
	);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */