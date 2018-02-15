<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_csrf_data'))
{
    function get_csrf_data()
    {
		$CI =& get_instance();
		
        return array('name' => $CI->security->get_csrf_token_name(), 'hash' => $CI->security->get_csrf_hash());
    }   
}