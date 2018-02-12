<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_model extends CI_Model {
	public function participants_count()
	{
		$this->db->select('*')
				 ->from('participants')
				 ->where('admitted = 1');
				 
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function entrance_fees_amount()
	{
		$this->db->select('SUM(value) fee_sum')
				 ->from('invoice_payments');
				 
		$query = $this->db->get();
		$row = $query->row();
		
		if (!empty($row)) {
			return floatval($row->fee_sum);
		}
		
		return 0;
	}
	
	public function lottery_winners($lottery_id)
	{
		$this->db->select('w.btc_address, w.transaction_hash, w.value, l.finish_date')
				 ->from('winners w')
				 ->join('lottery l', 'l.lottery_id = w.lottery_id', 'left')
				 ->where('l.lottery_id', $lottery_id)
				 ->order_by('w.value', 'DESC');
				 
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
}