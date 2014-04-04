<?php

//    index.php            access entry
// -> Common.php           load common function definitions
// -> CodeIgniter.php      load kinds of components and construct the application flow including initialize/destroy
// -> specific controller  initialize the target controller with all loaded class instances and call its action
function access_control_check()
{
	// here is all resources that is under protected
	$resource_policy = array(
		'business/all',
		'business/item',
		'category/all',
		'category/item',
		'user/all',
		'user/item'
	);

	$CI =& get_instance();

	$class = $CI->router->fetch_class();
	$method = $CI->router->fetch_method();

	if (in_array("$class/$method", $resource_policy)) {
		$CI->load->library('session');
		$profile = $CI->session->userdata('PROFILE');
		if (!$profile || !$profile['IS_SIGNON']) {
$warnText = <<<EOD
  ______ _                                  ___ _                 
 / _____|_)                                / __|_)            _   
( (____  _  ____ ____      ___  ____     _| |__ _  ____ ___ _| |_ 
 \____ \| |/ _  |  _ \    / _ \|  _ \   (_   __) |/ ___)___|_   _)
 _____) ) ( (_| | | | |  | |_| | | | |    | |  | | |  |___ | | |_ 
(______/|_|\___ |_| |_|   \___/|_| |_|    |_|  |_|_|  (___/   \__)
          (_____|                                                 
EOD;
			show_error("YOU ARE NOT AUTHORIZED TO ACCESS! PLEASE SIGN ON FIRST THEN TRY AGAIN!<br><pre style='padding-left:80px;'>$warnText</pre>", 403);
		}
	}
}

/* End of file access_control_check.php */
/* Location: ./application/hooks/access_control_check.php */