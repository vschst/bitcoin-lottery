<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		
		$this->load->model('lottery_model');
		$this->load->model('statistics_model');
		$this->load->model('index_model');

		$this->load->library('page_library', array('controller_name' => 'index'));
		
		$this->load->helper('url');
		$this->load->helper('csrf');
    }
	
	public function index()
	{
		if ($this->lottery_model->get_lottery_state()) {
			$lottery_date = $this->lottery_model->get_lottery_date();
			$current_date = new Datetime();
			$interval_to_lottery = $current_date->diff($lottery_date);
			
			if ($interval_to_lottery->invert == 1) {
				redirect('/winners', 'refresh');
			}

			$this->lang->load(array('common' , 'index_lang'), $this->config->item('language'));
			
			$this->page_library->load_page_header($this->lang->line('page_title'));

			$view_data = array(
				'lottery_date' => $lottery_date->format('F d, Y'),
				'lottery_prize_fund' => $this->statistics_model->entrance_fees_amount() * (1 - $this->lottery_model->get_org_rate()),
				
				'interval_days' => $interval_to_lottery->days,
				'interval_hours' => $interval_to_lottery->h,
				'interval_minutes' => $interval_to_lottery->i,
				'interval_seconds' => $interval_to_lottery->s,
				
				'participants_count' => $this->index_model->get_participants_count(),
				'last_participants' => $this->index_model->get_last_participants(),
				
				'csrf' => get_csrf_data(),
				'interval_to_lottery_timestamp' => $lottery_date->getTimestamp() - $current_date->getTimestamp()
			);
			
			$this->load->view('index', $view_data);
		
			$this->page_library->load_page_footer();
		}
	}
	
	public function ajax_get_last_participants()
	{
		if ($this->lottery_model->get_lottery_state()) {
			echo json_encode(
				array(
					'participants_count' => $this->index_model->get_participants_count(),
					'last_participants' => $this->index_model->get_last_participants()
				)
			);
		}
	}
	
	public function ajax_check_btc_address()
	{
		if ($this->lottery_model->get_lottery_state()) {
			$btc_address = $this->input->post('btc_address');
		
			if (isset($btc_address)) { 
				echo json_encode(array('csrf' => get_csrf_data(), 'check_status' => $this->index_model->check_btc_address($btc_address)));
			}
		}
	}
}
