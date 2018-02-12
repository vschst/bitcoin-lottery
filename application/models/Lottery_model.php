<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lottery_model extends CI_Model {
	private $active = false;

	private $lottery_id;
	private $fee_amount;
	private $org_rate;
	private $finish_date;
	
	public function __construct()
    {
        parent::__construct();
		
		$this->load->database();
		
		$this->load_lottery();
    }
	
	private function load_lottery()
	{
		$this->db->select('*')
				 ->from('lottery')
				 ->where('DATEDIFF(finish_date, start_date) > 0');
		
		$query = $this->db->get();
		$row = $query->last_row();
		
		if(!empty($row)) {
			date_default_timezone_set($row->timezone);

			$this->lottery_id = intval($row->lottery_id);
			$this->fee_amount = floatval($row->fee_amount);
			$this->org_rate = floatval($row->org_rate);
			$this->finish_date = new Datetime($row->finish_date);
			
			$this->active = true;
		}
	}
	
	public function __call($name, $arg)
	{
		switch($name) {
			case 'get_lottery_state':
				return $this->active;
			case 'get_lottery_id':
				return $this->lottery_id;
			case 'get_fee_amount':
				return $this->fee_amount;
			case 'get_org_rate':
				return $this->org_rate;
			case 'get_lottery_date':
				return $this->finish_date;
		}
	}
}