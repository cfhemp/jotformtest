<?php require_once 'config.php';    

//send_email('iamvasim@gmail.com', 'CoinPayments IPN', print_r($_POST, true));

$txn_id = $_POST['txn_id']; 
$status = intval($_POST['status']); 
$status_text = $_POST['status_text']; 

$result = $mysqli->query("SELECT *FROM orders WHERE txn_id='".$txn_id."'");
$transaction = $result->fetch_assoc();

if(!empty($transaction['order_id']))
{
	$query = "UPDATE orders SET 
				order_status='".$status."', 
				status_text='".$status_text."', 
				last_ipn_time='".date('Y-m-d H:i:s')."' 
			WHERE 
				txn_id='".$txn_id."'
	";
	
	$mysqli->query($query);
	
	
	if($status=='100')
	{
		//send_email($transaction['user_email'], 'Payment Received #'.$transaction['order_id'], 'We have received payment of '.$transaction['deposit_amount'].' '.$transaction['deposit_currency']);
	}
}
