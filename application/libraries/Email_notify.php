<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "myphpmailer.php";

class Email_notify {
	protected $CI;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		
		$this->CI->lang->load('email_notify_lang', $this->CI->config->item('language'));
    }
	
	public function join_invoice_created($email, $mail_data)
	{	
		$mail = new MyPHPMailer();
		$mail->addAddress($email);
		
		$mail_template = $this->CI->lang->line('join_invoice_created');
		$mail->Subject = $mail_template['subject'];
		
		$mail->IsHTML(FALSE); 
		$mail->Body = str_replace(
			array('{btc_address}', '{email}', '{payment_amount}', '{base_url}', '{invoice_id}', '{invoice_code}'),
			array($mail_data['btc_address'], $email, $mail_data['payment_amount'], $this->CI->config->item('base_url'), $mail_data['invoice_id'], $mail_data['invoice_code']), 
			$mail_template['message']
		);

		$mail->send();
	}
	
	public function join_payment_processed($email, $mail_data)
	{
		$mail = new MyPHPMailer();
		$mail->addAddress($email);
		
		$mail_template = $this->CI->lang->line('join_payment_processed');
		$mail->Subject = $mail_template['subject'];
		
		$mail->IsHTML(FALSE); 
		$mail->Body = str_replace(
			array('{paid_amount}', '{transaction_hash}', '{blockchain_root}'),
			array($mail_data['paid_amount'], $mail_data['transaction_hash'], $this->CI->config->item('blockchain_root')),
			$mail_template['message']
		);
		
		$mail->send();
	}
	
	public function join_payment_completed($email, $mail_data)
	{
		$mail = new MyPHPMailer();
		$mail->addAddress($email);
		
		$mail_template = $this->CI->lang->line('join_payment_completed');
		$mail->Subject = $mail_template['subject'];
		
		$mail->IsHTML(FALSE); 
		$mail->Body = str_replace(
			array('{payment_value}', '{base_url}', '{btc_address}', '{email}'),
			array($mail_data['payment_value'], $this->CI->config->item('base_url'), $mail_data['btc_address'], $email), 
			$mail_template['message']
		);

		$mail->send();
	}
	
	public function join_payment_cancelled($email)
	{
		$mail = new MyPHPMailer();
		$mail->addAddress($email);
		
		$mail_template = $this->CI->lang->line('join_payment_cancelled');
		$mail->Subject = $mail_template['subject'];
		
		$mail->IsHTML(FALSE);
		$mail->Body = str_replace('{base_url}', $this->CI->config->item('base_url'), $mail_template['message']);
		
		$mail->send();
	}
}