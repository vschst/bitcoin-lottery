<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Winners extends CI_Controller {
	private $winners_available = false;
	
	public function __construct()
    {
		parent::__construct();
		
		$this->config->load('blockchain_api');
		
		$this->load->model('lottery_model');
		$this->load->model('statistics_model');
		
		$this->load->library('page_library', array('controller_name' => 'winners'));
	}
	
	public function index()
	{
		if ($this->lottery_model->get_lottery_state() AND $this->winners_available) {
			$this->lang->load(array('common' , 'winners_lang'), $this->config->item('language'));
			
			$this->page_library->load_page_header($this->lang->line('winners_page_title') . " - " . $this->lang->line('page_title'));
			
			//	Get statistics
			$participant_count = $this->statistics_model->participants_count();
			
			$entrance_fees_amount = $this->statistics_model->entrance_fees_amount();
			
			$lottery_org_rate = $this->lottery_model->get_org_rate();
			
			//	View statistics and winners data
			$view_data = array(
				'participants_count' => $participant_count,
				'entrance_fees_amount' => round($entrance_fees_amount, 2, PHP_ROUND_HALF_DOWN),
				'organizational_fee_amount' => round($entrance_fees_amount * $lottery_org_rate, 2, PHP_ROUND_HALF_DOWN),
				'prize_fund_amount' => round($entrance_fees_amount * (1 - $lottery_org_rate), 2, PHP_ROUND_HALF_DOWN),
				'blockchain_root' => $this->config->item('blockchain_root'),
				'lottery_winners' => $this->statistics_model->lottery_winners($this->lottery_model->get_lottery_id())
			);

			$this->load->view('winners', $view_data);
			
			$this->page_library->load_page_footer();
		}
		else {
			$this->output->set_header('HTTP/1.0 403 Forbidden');
		}
	}
}