<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_notify {
	protected $CI;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		
		$this->CI->lang->load('email_notify_lang', $this->CI->config->item('language'));
		
		$this->CI->load->library('email');
		$this->CI->email->from($this->CI->config->item('smtp_user'), $this->CI->lang->line('display_name'));
    }
	
	public function join_invoice_created($email, $mail_data)
	{	
		$this->CI->email->to($email);
		
		$mail_template = $this->CI->lang->line('join_invoice_created');
		$this->CI->email->subject($mail_template['subject']);
		
		$this->CI->email->message(str_replace(
			array('{btc_address}', '{email}', '{payment_amount}', '{base_url}', '{invoice_id}', '{invoice_code}'),
			array($mail_data['btc_address'], $email, $mail_data['payment_amount'], $this->CI->config->item('base_url'), $mail_data['invoice_id'], $mail_data['invoice_code']), 
			$mail_template['message']
		));

		$this->CI->email->send();
	}
	
	public function join_payment_processed($email, $mail_data)
	{
		$this->CI->email->to($email);
		
		$mail_template = $this->CI->lang->line('join_payment_processed');
		$this->CI->email->subject($mail_template['subject']);

		$this->CI->email->message(str_replace(
			array('{paid_amount}', '{transaction_hash}', '{blockchain_root}'),
			array($mail_data['paid_amount'], $mail_data['transaction_hash'], $this->CI->config->item('blockchain_root')),
			$mail_template['message']
		));
		
		$this->CI->email->send();
	}
	
	public function join_payment_completed($email, $mail_data)
	{
		$this->CI->email->to($email);
		
		$mail_template = $this->CI->lang->line('join_payment_completed');
		$this->CI->email->subject($mail_template['subject']);

		$this->CI->email->message(str_replace(
			array('{payment_value}', '{base_url}', '{btc_address}', '{email}'),
			array($mail_data['payment_value'], $this->CI->config->item('base_url'), $mail_data['btc_address'], $email), 
			$mail_template['message']
		));

		$this->CI->email->send();
	}
	
	public function join_payment_cancelled($email)
	{
		$this->CI->email->to($email);
		
		$mail_template = $this->CI->lang->line('join_payment_cancelled');
		$this->CI->email->subject($mail_template['subject']);

		$this->CI->email->message(str_replace('{base_url}', $this->CI->config->item('base_url'), $mail_template['message']));
		
		$this->CI->email->send();
	}
}