<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		
		$this->config->load('blockchain_api');
		$this->load->model('profile_model');
		
		$this->load->library('session');
		$this->load->library('page_library', array('controller_name' => 'profile'));
		
		$this->load->helper('url');
		$this->load->helper('csrf');
	}
	
	public function index()
	{
		$login_data = $this->session->userdata('login_data');
		
		if (empty($login_data)) {
			redirect('/profile/login', 'refresh');
		}
		
		//	Check login data
		if (!$this->profile_model->check_login_data($login_data)) {
			$this->session->unset_userdata('login_data');
			
			redirect('/profile/login', 'refresh');
		}
		
		$this->lang->load(array('common', 'profile_index_lang'), $this->config->item('language'));
		
		$this->page_library->function_name = 'index';
		$this->page_library->load_page_header($this->lang->line('profile_index_page_title') . " - " . $this->lang->line('page_title'));
		
		//	View participant data
		$view_data = array(
			'btc_address' => '', 
			'registration_date' => '', 
			'blockchain_root' => $this->config->item('blockchain_root')
		);
		
		$participant_data = $this->profile_model->get_participant_data($login_data['login_token']);
		
		if(!empty($participant_data)) {
			$view_data['btc_address'] = $participant_data->btc_address;
			$view_data['registration_date'] = $participant_data->rdate;
		}
		
		// View invoice payments data
		$view_data['invoice_payments'] = $this->profile_model->get_invoice_payments($login_data['invoice_id']);
		
		// View participant winnings
		$view_data['participant_winnings'] = $this->profile_model->get_participant_winnings($login_data['login_token']);
		
		$this->load->view('profile_index', $view_data);
		
		$this->page_library->load_page_footer();
	}
	
	public function logout()
	{
		if (!empty($this->session->userdata('login_data'))) {
			$this->session->unset_userdata('login_data');
		}
		
		redirect('/profile/login', 'refresh');
	}
	
	public function login()
	{
		if ($this->session->userdata('login_data')) {
			redirect('/profile', 'refresh');
		}

		$this->lang->load(array('common', 'profile_login_lang'), $this->config->item('language'));
		
		$this->page_library->function_name = 'login';
		$this->page_library->load_page_header($this->lang->line('profile_login_page_title') . " - " . $this->lang->line('page_title'));
		
		$view_data = array('csrf' => get_csrf_data());
		$this->load->view('profile_login', $view_data);
		
		$this->page_library->load_page_footer();
	}
	
	public function ajax_check_auth_data()
	{
		$auth_data_to_check = array(
			'btc_address' => $this->input->post('btc_address'),
			'email' => $this->input->post('email')
		);
		
		$check_status = $this->profile_model->check_auth_data($auth_data_to_check);
		
		if ($check_status['error_code'] == 0) {
			$login_token = $this->profile_model->update_login_token($auth_data_to_check, md5($auth_data_to_check['btc_address'] . $auth_data_to_check['email']));
			
			if ($login_token) {
				$this->session->set_userdata('login_data', array('invoice_id' => $check_status['invoice_id'], 'login_token' => $login_token));
			}
		}
		
		echo json_encode(array('csrf' => get_csrf_data(), 'check_status' => $check_status['error_code']));
	}
}