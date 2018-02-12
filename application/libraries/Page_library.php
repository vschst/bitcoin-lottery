<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_library {
	protected $CI;
	public $controller_name;
	public $function_name = null;
	
	public function __construct($params)
    {
		$this->CI =& get_instance();
		
		$this->controller_name = $params['controller_name'];
		
		$this->CI->lang->load(array('header_lang', 'footer_lang'), $this->CI->config->item('language'));
		$this->CI->load->helper('language');
		$this->CI->load->helper('btc_stock');
    }
	
	public function load_page_header($page_title)
	{
		$page_header_data = array(
			'controller_name' => $this->controller_name,
			'function_name' => $this->function_name,
			'base_url' => $this->CI->config->item('base_url'),
			
			'page_title' => $page_title,
			'description' => $this->CI->lang->line('description'),
			'keywords' => $this->CI->lang->line('keywords'),
			'author' => $this->CI->lang->line('author'),

			'lang_uri' => $this->CI->config->item('language_abbr'),
			'page_uri' => $this->CI->uri->uri_string()
		);
		
		$this->CI->load->view('header', $page_header_data);
	}
	
	public function load_page_footer()
	{
		$page_footer_data = array(
			'controller_name' => $this->controller_name,
			'function_name' => $this->function_name,
			'base_url' => $this->CI->config->item('base_url'),

			'btc_stock_price_title' => str_replace('{btc_stock_price}', get_btc_stock_price(), $this->CI->lang->line('btc_stock_price_title'))
		);
		
		$this->CI->load->view('footer', $page_footer_data);
	}
}