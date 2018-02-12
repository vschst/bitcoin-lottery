<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {
	private $login_token_secret = "sgGOr0";
	
	public function __construct()
    {
        parent::__construct();
		
		$this->load->database();
    }
	
	//	Login
	public function check_auth_data($auth_data)
	{
		$check_status = array('error_code' => 0);
		
		if (!array_key_exists('btc_address', $auth_data) OR empty($auth_data['btc_address'])) {
			$check_status['error_code'] = (-1);
		}
		else {
			if (!array_key_exists('email', $auth_data) OR empty($auth_data['email'])) {
				$check_status['error_code'] = (-2);
			}
			else {
				$this->db->select("invoice_id")
						 ->from('participants')
						 ->where(array('btc_address' => $auth_data['btc_address'], 'email' =>  $auth_data['email'], 'admitted' => 1));
		
				$query = $this->db->get();
				$row = $query->row();
		
				if(!empty($row)) {
					$check_status['invoice_id'] = $row->invoice_id; 
				}
				else {
					$check_status['error_code'] = (-3);
				}
			}
		}
		
		return $check_status;
	}
	
	public function update_login_token($auth_data, $token)
	{
		$login_token = md5($token . $this->login_token_secret . rand(13, 19));
		
		if($this->db->update('participants', array('login_token' => $login_token), array('btc_address' => $auth_data['btc_address'], 'email' => $auth_data['email'], 'admitted' => 1))) {
			return $login_token;
		}
		
		return false;
	}
	
	public function check_login_data($login_data)
	{
		$this->db->select('*')
				 ->from('participants p, invoices i')
				 ->where('i.invoice_id = p.invoice_id')
				 ->where(array('i.invoice_id' => $login_data['invoice_id'], 'p.login_token' => $login_data['login_token'], 'p.admitted' => 1));
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return true;
		}
		
		return false;
	}
	
	//	Profile
	public function get_participant_data($login_token)
	{
		$this->db->select('btc_address, rdate')
				 ->from('participants')
				 ->where('login_token', $login_token);

		$query = $this->db->get();
		$row = $query->row();
		
		return $row;
	}
	
	public function get_invoice_payments($invoice_id)
	{
		$this->db->select('transaction_hash, value, tdate')
				 ->from('invoice_payments')
				 ->where('invoice_id', $invoice_id)
				 ->order_by('tdate', 'DESC');

		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	public function get_participant_winnings($login_token)
	{
		$this->db->select('w.transaction_hash, w.value, l.finish_date')
				 ->from('winners w')
				 ->join('participants p', 'p.btc_address = w.btc_address')
				 ->join('lottery l', 'l.lottery_id = w.lottery_id', 'left')
				 ->where('p.login_token', $login_token)
				 ->order_by('l.finish_date', 'DESC');
		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
}