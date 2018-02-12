<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends CI_Controller {
	public function __construct()
    {
		parent::__construct();

		$this->load->library('page_library', array('controller_name' => 'terms'));
	}
	
	public function index()
	{
		$this->lang->load('terms_lang', $this->config->item('language'));
		
		$this->page_library->load_page_header($this->lang->line('terms_page_title') . " - " . $this->lang->line('page_title'));
		
		$this->load->view('terms');
		
		$this->page_library->load_page_footer();
	}
}