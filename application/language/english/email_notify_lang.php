<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['display_name'] = 'Bitcoin Lottery 2018';

$lang['join_invoice_created'] = array(
	'subject' => 'Notification for payment of the lottery fee',
	'message' => 'Thank you for your participation in the lottery.

Details of your invoice
Bitcoin address: {btc_address}
Email: {email}
Total amount: {payment_amount} BTC

Link for payment: {base_url}join/to_payment/{invoice_id}/{invoice_code}'
);

$lang['join_payment_processed'] = array(
	'subject' => 'Payment processed',
	'message' => 'Received payment of the lottery fee:

Amount: {paid_amount} BTC
Transaction hash: {transaction_hash}

You can check your payment by link:
{blockchain_root}tx/{transaction_hash}'
);

$lang['join_payment_completed'] = array(
	'subject' => 'Payment completed and you participate in the lottery',
	'message' => 'You have successfully paid {payment_amount} BTC. Now you are a participant of the lottery.
	
In addition, you can manage your profile, available by the link:
{base_url}/profile

To login use your participant details
Bitcoin address: {btc_address}
Email: {email}

Good luck!'
);

$lang['join_payment_cancelled'] = array(
	'subject' => 'Payment has been cancelled',
	'message' => 'At your request, we canceled payment and removed your participant data from our database.
	
If you decide to return then you have to re-register by the link:
{base_url}/join'
);