<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_model extends CI_Model {
	private $row_limit = 5;
	private $hide_chars_count = 7;
	
	public function get_participants_count()
	{
		$this->db->select('*')
				 ->from('participants')
				 ->where('admitted', 1);
		
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_last_participants()
	{
		$this->db->select('btc_address, rdate')
				 ->from('participants')
				 ->where('admitted', 1)
				 ->order_by('rdate', 'DESC')
				 ->limit($this->row_limit);

		$query = $this->db->get();
		$last_participants = $query->result_array();
		
		foreach($last_participants as &$value) {
			$value['btc_address'] = substr($value['btc_address'], 0, (-1)*$this->hide_chars_count) . str_repeat('#', $this->hide_chars_count);	
		}
		
		return $last_participants;
	}
	
	public function check_btc_address($btc_address)
	{
		$this->db->select('*')
				 ->from('participants')
				 ->where(array('btc_address' => $btc_address, 'admitted' => 1));

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return true;
		}
		
		return false;
	}
}