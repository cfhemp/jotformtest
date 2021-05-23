<?php require_once 'config.php';

if(isset($_POST['btnDeposit']))
{
	$buyer_email = $_POST['buyer_email'];
	$currency1 = 'USD';
	$amount = $_POST['amount'];
	$sid = $_POST['sid'];
	//$custom = $_POST['custom'];
	$currency2 = $_POST['currency2']; // BTC, LTC, ETH

	if(empty($buyer_email))
	{
		die('Error: "buyer_email" field is empty.');
	}
	elseif(!filter_var($buyer_email,FILTER_VALIDATE_EMAIL))
	{
		die('Error: "buyer_email" filed has invalid value.');
	}
	elseif(empty($currency1))
	{
		die('Error: "currency1" field is empty.');
	}
	elseif(empty($amount))
	{
		die('Error: "amount" field is empty.');
	}
	elseif($amount<=0)
	{
		die('Error: "amount" field value is invalid.');
	}
	elseif(empty($currency2))
	{
		die('Error: "currency2" field is empty.');
	}
	else
	{
	    
	    
	    
		require('coinpayments.inc.php');
		
		$cps = new CoinPaymentsAPI();
		$cps->Setup($config['private_key'], $config['public_key']);

		$req = array(
			'amount' => $amount,
			'currency1' => $currency1,
			'currency2' => $currency2,
			'buyer_email' => $buyer_email,
		//	'custom' => $custom, 
			'address' => '', // leave blank send to follow your settings on the Coin Settings page
			'item_name' => 'Add fund from wallet',
			'ipn_url' => 'http://crypto.idshubs.com/ipn.php',		
		);
		
		$result = $cps->CreateTransaction($req);
		

		if($result['error']=='ok')
		{
			$txn_id = $result['result']['txn_id'];

			 $query = "INSERT INTO `orders`(`user_email`, `amount_usd`, `order_status`, `status_text`, `order_time`, `deposit_amount`, 
			`deposit_currency`, `txn_id`, `deposit_address`, `confirms_needed`, `timeout_seconds`, `status_url`, `qrcode_url`) VALUES 
			('".$buyer_email."','".$amount."','0','Waiting for buyer funds','".date('Y-m-d H:i:s')."','".$result['result']['amount']."','".$currency2."',
			'".$result['result']['txn_id']."','".$result['result']['address']."','".$result['result']['confirms_needed']."','".$result['result']['timeout']."'
			,'".$result['result']['status_url']."','".$result['result']['qrcode_url']."')";
			$mysqli->query($query);
			
			header('Location: qrcode.php?id='.$txn_id);
		}
		else
		{
			die('Error:'. $result['error']);
		}
		/****************************************************************
		Array
		(
			[error] => ok
			[result] => Array
				(
					[amount] => 0.00147117
					[txn_id] => CPCD0OKBTQ5CO6AQE2TTFLLPFH
					[address] => 34LhgUvHAQe2xYS1krWFeMeUtHBPNvNRQQ
					[confirms_needed] => 2
					[timeout] => 95400
					[status_url] => https://www.coinpayments.net/index.php?cmd=status&id=CPCD0OKBTQ5CO6AQE2TTFLLPFH&key=af75d9fef9fbefbf7ec0edb87f1c0426
					[qrcode_url] => https://www.coinpayments.net/qrgen.php?id=CPCD0OKBTQ5CO6AQE2TTFLLPFH&key=af75d9fef9fbefbf7ec0edb87f1c0426
				)
		
		)
		******************************************************************/
	}
}