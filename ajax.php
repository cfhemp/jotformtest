<?php require_once 'config.php';

$action = $_POST['action'];

if($action=='getStatus'):
	
	$txn_id = $_POST['txn_id'];
	
	$result = $mysqli->query("SELECT *FROM orders WHERE txn_id='".$txn_id."'");
	
	$transaction = $result->fetch_assoc();
		
	$response = array('order_status'=>$transaction['order_status'], 'status_text'=>$transaction['status_text']);
	
	echo json_encode($response);
	
endif;
		