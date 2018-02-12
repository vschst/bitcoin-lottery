<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['main_caption'] = 'Registering a new participant';
$lang['join_is_not_available'] = 'Currently, registration of new participants of the lottery is not available.';
$lang['payment_of_fee_text'] = 'To participate in the lottery you need to pay the entrance fee in the amount of <b><code class="highlighter-rouge">{fee_amount}</code> BTC</b>';
$lang['form_filling_text'] = 'Before you do this please fill in the following information';
$lang['btc_address_help'] = 'This address will participate in the lottery, it must pay.';
$lang['email_help'] = 'To send you notifications.';
$lang['confirmation_of_terms'] = 'I agree with <a href="/terms" target="_blank">terms of service</a> and I am 18 years old.';
$lang['next_btn'] = 'Next';
$lang['error_alerts'] = array(
	'empty_btc_address' => 'Please enter the address of your bitcoin wallet',
	'incorrect_btc_address' => 'Please enter a correct bitcoin address',
	'empty_email' => 'Please enter your email address',
	'incorrect_email' => 'Please enter a correct email',
	'confirmation_is_required' => 'Confirmation is required with terms of the lottery',
	'already_lottery_participant' => 'This bitcoin address is already a lottery participant!'
);
$lang['payment_cancelled'] = 'Payment has been cancelled';