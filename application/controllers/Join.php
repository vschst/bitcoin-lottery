<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends CI_Controller {
	private $join_available = true;
	
	public function __construct()
    {
		parent::__construct();
		
		$this->config->load('blockchain_api');
		$this->load->model('lottery_model');
		$this->load->model('join_model');
		
		$this->load->library('session');
		$this->load->library('page_library', array('controller_name' => 'join'));
		$this->load->library('email_notify');
		
		$this->load->helper('url');
	}

	public function index()
	{
		if ($this->session->userdata('participant_data_for_confirm')) {
			redirect('/join/confirm', 'refresh');
		}
		else if ($this->session->userdata('invoice_data')) {
			redirect('/join/payment', 'refresh');
		}
		else if ($this->session->userdata('login_data')) {
			redirect('/profile', 'refresh');
		}
		
		$this->lang->load(array('common', 'join_common_lang', 'join_index_lang'), $this->config->item('language'));
		
		$this->page_library->function_name = 'index';
		$this->page_library->load_page_header($this->lang->line('join_page_title') . " - " . $this->lang->line('page_title'));
		
		$view_data['join_available'] = $this->join_available;

		if ($this->join_available) {
			$view_data['fee_amount'] = $this->lottery_model->get_fee_amount();
			$view_data['error_alert'] = null;
			$view_data['btc_address'] = '';
			$view_data['email'] = '';

			$error_alert = $this->session->userdata('join_index_error_alert');
			
			if (isset($error_alert)) {
				switch ($error_alert) {
					case (-1):
						$view_data['error_alert'] = $this->lang->line('payment_cancelled');
						break;
				}
				
				$this->session->unset_userdata('join_index_error_alert');
			}
			
			$participant_data = $this->session->userdata('participant_data') or null;
			
			if (isset($participant_data)) {	
				if (array_key_exists('btc_address', $participant_data)) {
					$view_data['btc_address'] = $participant_data['btc_address'];
				}

				if (array_key_exists('email', $participant_data)) {
					$view_data['email'] = $participant_data['email'];
				}
				
				$this->session->unset_userdata('participant_data');
			}
		}
		
		$this->load->view('join_index', $view_data);
		
		$this->page_library->load_page_footer();
	}
	
	public function confirm($action = null)
	{
		$participant_data_for_confirm = $this->session->userdata('participant_data_for_confirm');

		if (empty($participant_data_for_confirm)) {
			redirect('/join', 'refresh');
		}
		
		if ($action == "back") {
			$this->session->unset_userdata('participant_data_for_confirm');
			$this->session->set_userdata('participant_data', $participant_data_for_confirm);
			
			redirect('/join', 'refresh');
		}

		$this->lang->load(array('common', 'join_common_lang', 'join_confirm_lang'), $this->config->item('language'));

		$this->page_library->function_name = 'confirm';
		$this->page_library->load_page_header($this->lang->line('join_page_title') . " - " . $this->lang->line('page_title'));
		
		$view_data = array();

		$error_alert = $this->session->userdata('join_confirm_error_alert');
			
		if (isset($error_alert)) {
			switch ($error_alert) {
				case (-1):
					$view_data['error_alert'] = $this->lang->line('error_alerts')['invalid_participant_data'];
					break;
				case (-2):
					$view_data['error_alert'] = $this->lang->line('error_alerts')['create_invoice_failed'];
					break;
			}
				
			$this->session->unset_userdata('join_confirm_error_alert');
		}

		$view_data['btc_address'] = $participant_data_for_confirm['btc_address'];
		$view_data['email'] = $participant_data_for_confirm['email'];
		$view_data['fee_amount'] = $this->lottery_model->get_fee_amount();
		
		$this->load->view('join_confirm', $view_data);
		
		$this->page_library->load_page_footer();
	}
	
	//	todo: captcha verification
	public function invoice()
	{
		$participant_data_for_confirm = $this->session->userdata('participant_data_for_confirm');
		
		if ($this->join_available AND $participant_data_for_confirm) {		
			$check_status = $this->join_model->check_participant_data($participant_data_for_confirm, true);
			
			if ($check_status == 0) {
				$invoice_payment_amount = $this->lottery_model->get_fee_amount();
				
				$invoice_data = $this->join_model->create_invoice($invoice_payment_amount, $participant_data_for_confirm);
				
				if ($invoice_data) {
					$this->email_notify->join_invoice_created(
						$participant_data_for_confirm['email'],
						array(
							'btc_address' => $participant_data_for_confirm['btc_address'],
							'payment_amount' => $invoice_payment_amount,
							'invoice_id' => $invoice_data['invoice_id'],
							'invoice_code' => $invoice_data['invoice_code']
						)
					);
					
					$this->session->unset_userdata('participant_data_for_confirm');
					$this->session->set_userdata('invoice_data', $invoice_data);

					redirect('/join/payment', 'refresh');
				}
				else {
					$this->session->set_userdata('join_confirm_error_alert', (-2));
				}
			}
			else {
				$this->session->set_userdata('join_confirm_error_alert', (-1));
			}
		}
		
		redirect('/join', 'refresh');
	}
	
	public function payment($action = null)
	{
		//	Check invoice data
		$invoice_data = $this->session->userdata('invoice_data');
		
		if (empty($invoice_data)) {
			redirect('/join', 'refresh');
		}
		
		//	Check payment status
		$payment_status = $this->join_model->get_payment_status($invoice_data);
		
		if (!$payment_status OR ($payment_status['stage'] == 2)) {
			$this->session->unset_userdata('invoice_data');
			
			redirect('/profile', 'refresh');
		}
		
		//	Getting payment data
		$invoice_payment_data = $this->join_model->get_invoice_payment_data($invoice_data);
		
		if (!$invoice_payment_data) {
			$this->session->unset_userdata('invoice_data');
			
			redirect('/join', 'refresh');
		}
		
		//	Payment cancel
		if (($action == "cancel") AND ($payment_status['stage'] == 0) AND ($this->join_model->remove_invoice_data($invoice_data['invoice_id']))) {
			$this->session->unset_userdata('invoice_data');
			
			$this->email_notify->join_payment_cancelled($invoice_payment_data->email);	
			
			$this->session->set_userdata('join_index_error_alert', (-1));
			
			redirect('/join', 'refresh');
		}
		
		$this->lang->load(array('common', 'join_common_lang', 'join_payment_lang'), $this->config->item('language'));
			
		$this->page_library->function_name = 'payment';
		$this->page_library->load_page_header($this->lang->line('join_page_title') . " - " . $this->lang->line('page_title'));
			
		$view_data = array(
			'invoice_btc_address' => $invoice_payment_data->btc_address,
			'invoice_email' => $invoice_payment_data->email,
			'payment_amount' => $invoice_payment_data->payment_amount,
			'destination_btc_address' => $invoice_payment_data->address,
			'blockchain_root' => $this->config->item('blockchain_root'),
			'payment_stage' => $payment_status['stage'],
			'stage_pending_text' => str_replace(
				array('{amount_paid}', '{amount_pending}'), 
				array(
					sprintf('%f', $payment_status['amount_paid']), 
					sprintf('%f', $payment_status['amount_pending'])
				), 
				$this->lang->line('waiting_for_payment_confirmation')
			)
		);
			
		$this->load->view('join_payment', $view_data);
		
		$this->page_library->load_page_footer();
	}
	
	public function to_payment($invoice_id, $invoice_code)
	{
		if($this->join_model->check_invoice($invoice_id, $invoice_code)) {
			$this->session->set_userdata('invoice_data', array('invoice_id' => $invoice_id, 'invoice_code' => $invoice_code));
			
			redirect('/join/payment', 'refresh');
		}
		
		redirect('/join', 'refresh');
	}
	
	public function payment_callback($invoice_id, $receipt_secret)
	{
		$paid_invoice_data = $this->join_model->get_paid_invoice_data($invoice_id, $receipt_secret);
		
		if ($paid_invoice_data) {
			$callback_data = array(
				'tranaction_hash' => $this->input->get('tranaction_hash'),
				'address' => $this->input->get('address'),
				'confirmations' => $this->input->get('confirmations'),
				'value_in_btc' => $this->input->get('value') / 100000000
			);


			$update_status = $this->join_model->update_invoice_payment(
				$invoice_id,
				array(
					'payment_amount' => $paid_invoice_data->payment_amount, 
					'address' => $paid_invoice_data->address), 
				$callback_data
			);
			
			switch ($update_status) {
				case (-1):
					echo('Incorrect receiving address');
					break;
				case (-2):
					echo('Waiting for confirmations');
					break;
				default:
					$this->email_notify->join_payment_processed(
						$paid_invoice_data->email,
						array(
							'paid_amount' => $callback_data['value_in_btc'],
							'transaction_hash' => $callback_data['tranaction_hash']
						)
					);
				
					if ($update_status == 1) {
						$this->email_notify->join_payment_completed(
							$paid_invoice_data->email,
							array(
								'payment_amount' => $paid_invoice_data->payment_amount,
								'btc_address' => $paid_invoice_data->btc_address
							)
						);
					}
					
					echo('Payment processed!');
					break;
			}
		}
		else {
			echo('Invalid invoice secret!');
		}
	}
	
	public function ajax_check_participant_data()
	{
		$participant_data_to_check = array(
			'btc_address' => $this->input->post('btc_address'),
			'email' => $this->input->post('email')
		);

		$check_status = $this->join_model->check_participant_data($participant_data_to_check);
	
		if ($check_status == 0) {
			$this->session->set_userdata('participant_data_for_confirm', $participant_data_to_check);
		}
			
		echo json_encode(array('check_status' => $check_status));
	}
	
	public function ajax_get_payment_status()
	{
		$invoice_data = $this->session->userdata('invoice_data');
		
		if (!empty($invoice_data)) {
			$payment_status = $this->join_model->get_payment_status($invoice_data);
			
			if ($payment_status) {
				if (($payment_status['stage'] == 2) AND empty($this->session->userdata('login_data'))) {
					$login_token = $this->join_model->create_login_token($invoice_data);
					
					if ($login_token) {
						$this->session->set_userdata('login_data', array('invoice_id' => $invoice_data['invoice_id'], 'login_token' => $login_token));
					}
				}
				
				$payment_status['amount_pending'] = sprintf('%f', $payment_status['amount_pending']);
				$payment_status['amount_paid'] = sprintf('%f', $payment_status['amount_paid']);
				
				echo json_encode($payment_status);
			}
		}
	}
}