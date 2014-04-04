<?php

// http://us3.php.net/manual/en/function.base64-encode.php
// http://jeromejaglale.com/doc/php/codeigniter_compress_html

function base64encrypt()
{
	$CI =& get_instance();
	$buffer = $CI->output->get_output();
	$CI->load->helper('url');
	if (preg_match('/^.+json.?$/u', current_url())) {
		$buffer = base64_encode($buffer);
	}
	$CI->output->set_output($buffer);
	$CI->output->_display();
}

/* End of file base64encrypt.php */
/* Location: ./application/hooks/base64encrypt.php */