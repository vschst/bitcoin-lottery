<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_btc_stock_price'))
{
    function get_btc_stock_price()
    {
        $btc_stock_price = null;
		$response = file_get_contents("https://blockchain.info/ticker");
		$ticker = json_decode($response, true);
		
		if (array_key_exists('USD', $ticker)) {
			$usd = $ticker['USD'];
			
			if (array_key_exists('last', $usd)) {
				$btc_stock_price = $usd['last'];
			}
		}

		return $btc_stock_price;
    }   
}