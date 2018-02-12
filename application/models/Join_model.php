<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join_model extends CI_Model {
	private $btc_address_regexp = '/^(bc1|[13])[a-zA-HJ-NP-Z0-9]{25,39}$/';
	private $email_regexp = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
	
	private $invoice_secret = "3&*SDhasAGD)7";
	
	//	Join
	public function check_participant_data($participant_data, $only_correctness = false)
	{
		if (!array_key_exists('btc_address', $participant_data) OR empty($participant_data['btc_address']) OR !preg_match($this->btc_address_regexp, $participant_data['btc_address'])) {
			return (-1);
		}
		
		//if (!array_key_exists('email', $participant_data) OR empty($participant_data['email']) OR !filter_var($participant_data['email'], FILTER_VALIDATE_EMAIL)) {
		if (!array_key_exists('email', $participant_data) OR empty($participant_data['email']) OR !preg_match($this->email_regexp, $participant_data['email'])) {
			return (-2);
		}
		
		if (!$only_correctness) {
			$this->db->select('*')
					 ->from('participants')
				     ->where('btc_address', $participant_data['btc_address']);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return (-3);
			}
		}
		
		return 0;
	}
	
	//	Invoice
	private function get_gap_limit()
	{
		$this->db->select('*')
				 ->from('invoices i')
				 ->where('i.address IS NOT NULL AND NOT EXISTS (SELECT * FROM pending_invoice_payments pip WHERE pip.invoice_id = i.invoice_id)');
		
		$this->db->get();
		$gap_limit = $query->num_rows();
		
		if ($gap_limit < 20) {
			$gap_limit = 20;
		}
		
		return $gap_limit;
	}
	
	public function create_invoice($payment_amount, $participant_data)
	{
		$invoice_code = md5($participant_data['btc_address'] . $participant_data['email'] . $this->invoice_secret);

		$this->db->replace('invoices', array('invoice_code' => $invoice_code, 'payment_amount' => $payment_amount));
		$invoice_id = $this->db->insert_id();
		
		if ($invoice_id != 0) {
			$date = new DateTime();
			
			$this->db->replace('participants', array('btc_address' => $participant_data['btc_address'], 'email' => $participant_data['email'], 'invoice_id' => $invoice_id, 'rdate' => $date->format('Y-m-d H:i:s')));
			
			$blockchain_keys = array('api' => $this->config->item('api_key'), 'xpub' => $this->config->item('xpub_key'));
			
			if (($blockchain_keys['api'] != '') AND ($blockchain_keys['xpub'] != '')) {
				$receipt_secret = md5($invoice_code . rand(57, 79) . $invoice_id . rand(11, 17) . $this->invoice_secret);

				$callback_url = $this->config->item('base_url') . "join/payment_callback/" . $invoice_id . "/" . $receipt_secret;
				
				$blockchain_api_root_url = $this->config->item('blockchain_api_root') . 'v2/receive';
				$gap_limit = $this->get_gap_limit();
				$parameters = 'xpub=' . $blockchain_keys['xpub'] . '&callback=' . urlencode($callback_url) . '&key=' .$blockchain_keys['api'] . '&gap_limit=' . $gap_limit;

				$resp = file_get_contents($blockchain_api_root_url . '?' . $parameters);
				
				$response = json_decode($resp, true);

				if ($response AND array_key_exists('address', $response)) {
					$this->db->update('invoices', array('address' => $response['address'], 'receipt_secret' => $receipt_secret), array('invoice_id' => $invoice_id, 'invoice_code' => $invoice_code));
				
					return array('invoice_id' => $invoice_id, 'invoice_code' => $invoice_code);
				}
			}
			else {
				die("Blockchain keys doesn't found!");
			}
		}
		
		return false;
	}
	
	public function check_invoice($invoice_id, $invoice_code)
	{
		$this->db->select('*')
				 ->from('invoices')
				 ->where(array('invoice_id' => $invoice_id, 'invoice_code' => $invoice_code));

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function remove_invoice_data($invoice_id) {
		return 
			$this->db->delete("invoices", array('invoice_id' => $invoice_id))
			AND $this->db->delete("invoice_payments", array('invoice_id' => $invoice_id))
			AND $this->db->delete("pending_invoice_payments", array('invoice_id' => $invoice_id))
			AND $this->db->delete("participants", array('invoice_id' => $invoice_id));
	}
	
	//	Invoice payment and callback
	public function get_invoice_payment_data($invoice_data)
	{
		$this->db->select('p.btc_address, p.email, i.payment_amount, i.address')
				 ->from('invoices i')
				 ->join('participants p', 'p.invoice_id = i.invoice_id')
				 ->where(array('i.invoice_id' => $invoice_data['invoice_id'], 'i.invoice_code' => $invoice_data['invoice_code']));

		$query = $this->db->get();
		$row = $query->row();
		
		if(!empty($row)) {
			return $row;
		}
		
		return false;
	}

	public function get_amount_paid($invoice_id)
	{
		$this->db->select('SUM(value) AS amount_paid')
				 ->from('invoice_payments')
				 ->where('invoice_id', $invoice_id);

		$query = $this->db->get();
		$row = $query->row();
		
		if(!empty($row)) {
			return $row->amount_paid;
		}
		
		return false;
	}
	
	public function get_amount_pending($invoice_id)
	{
		$this->db->select('SUM(value) AS amount_pending')
				 ->from('pending_invoice_payments')
				 ->where('invoice_id', $invoice_id);

		$query = $this->db->get();
		$row = $query->row();
		
		if(!empty($row)) {
			return $row->amount_pending;
		}
		
		return false;	
	}
	
	public function get_paid_invoice_data($invoice_id, $receipt_secret)
	{
		$this->db->select('p.btc_address, p.email, i.payment_amount, i.address')
				 ->from('invoices i')
				 ->join('participants p', 'p.invoice_id = i.invoice_id')
				 ->where(array('i.invoice_id' => $invoice_id, 'i.receipt_secret' => $receipt_secret));

		$query = $this->db->get();
		$row = $query->row();
		
		if(!empty($row)) {
			return $row;
		}
		
		return false;
	}
	
	public function update_invoice_payment($invoice_id, $payment_data, $callback_data)
	{
		if ($payment_data['address'] != $callback_data['address']) {
			return (-1);
		}
		
		$date = new DateTime();
		
		if ($callback_data['confirmations'] >= 4) {
			$this->db->replace('invoice_payments', array('invoice_id' => $invoice_id, 'transaction_hash' => $callback_data['transaction_hash'], 'value' => $callback_data['value_in_btc'], 'tdate' => $date->format('Y-m-d H:i:s')));
			
			$this->db->delete('pending_invoice_payments', array('invoice_id' => $invoice_id))
					 ->limit(1);
			
			
			$amount_paid = $this->get_amount_paid($invoice_id);
			
			if ($amount_paid AND (floatval($amount_paid) >= floatval($payment_data['payment_amount']))) {
				$this->db->update('participants', array('admitted' => 1), array('invoice_id' => $invoice_id));
				
				return 1;
			}
		}
		else {
			$this->db->replace('pending_invoice_payments', array('invoice_id' => $invoice_id, 'transaction_hash' => $callback_data['transaction_hash'], 'value' => $callback_data['value_in_btc'], 'tdate' => $date->format('Y-m-d H:i:s')));

			return (-2);
		}
		
		return 0;
	}
	
	public function get_payment_status($invoice_data)
	{
		$this->db->select('payment_amount')
				 ->from('invoices')
				 ->where(array('invoice_id' => $invoice_data['invoice_id'], 'invoice_code' => $invoice_data['invoice_code']));

		$query = $this->db->get();
		$row = $query->row();
		
		if (!empty($row)) {
			$payment_status = array(
				'stage' => 0, 
				'amount_pending' => floatval($this->get_amount_pending($invoice_data['invoice_id'])),
				'amount_paid' => floatval($this->get_amount_paid($invoice_data['invoice_id']))
			);
			
			if (($payment_status['amount_pending'] == 0) AND ($payment_status['amount_paid'] == 0)) {
				$payment_status['stage'] = 0;
			}
			else if ($payment_status['amount_paid'] < floatval($row->payment_amount)) {
				$payment_status['stage'] = 1;
			}
			else {
				$payment_status['stage'] = 2;
			}
			
			return $payment_status;
		}
		
		return false;
	}
	
	public function create_login_token($invoice_data)
	{
		$login_token = md5($invoice_data['invoice_id'] . rand(23, 97) . $invoice_data['invoice_code']);

		if ($this->db->update('participants', array('login_token' => $login_token), array('invoice_id' => $invoice_data['invoice_id'])))  {
			return $login_token;
		}
		
		return false;
	}
}