<?php require_once 'config.php';

$txn_id = $_GET['id'];

$result = $mysqli->query("SELECT *FROM orders WHERE txn_id='".$txn_id."'");

$transaction = $result->fetch_assoc();

if(!empty($transaction['order_id']))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send Payment</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
    	<div class="col-md-6 col-sm-6 mx-auto">
            <p style="margin:1.5rem 0;" class="h4 text-center">IdsHubs.com</p>
            <div class="card">            	
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="2"><strong>Payment Information</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="right">Status:</td>
                            <td>
                            	<span id="payment_status"><?php echo $transaction['status_text']?></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Total Amount to Send:</td>
                            <td><?php echo $transaction['deposit_amount']?> <?php echo $transaction['deposit_currency']?> (total confirms needed: <?php echo $transaction['confirms_needed']?>)</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <img src="<?php echo $transaction['qrcode_url']?>" class="img-fluid img-thumbnail" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Send To Address:</td>
                            <td><?php echo $transaction['deposit_address']?></td>
                        </tr>
                        <tr>
                            <td align="right">Time Left:</td>
                            <td><span id="payment_timeout"><?php echo $transaction['timeout_seconds']?></span> seconds</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                            	<a class="btn btn-success btn-lg" target="_blank" href="<?php echo $transaction['status_url']?>"><?php echo $transaction['txn_id']?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>            	
            </div>
    	</div>
    </div>
</div>
<script>
$(document).ready(function() {
	getTimer('#payment_timeout', <?php echo $transaction['timeout_seconds']?>);
	getStatus('<?php echo $transaction['txn_id']?>');
});
function getStatus(txn_id)
{
	$('#payment_status').html('Checking...');
	
	$.ajax({
		url:'ajax.php',
		data:'action=getStatus&txn_id='+txn_id,
		type:'post',
		dataType:'json',
		success:function(json){				
			$('#payment_status').html(json.status_text);					
			
			if(json.order_status!='100') {
				setTimeout('getStatus("'+txn_id+'")', (10*1000)); 				
			}else{
				// Transaction Completed	
				alert('Congrats! Fund Received!');			
			}
		}
	});	
}
function getTimer(div, timer) {
    //alert(seconds);
	setInterval(function () {
		
		hours = parseInt(timer / 3600, 10);
		rem_mins = timer - (hours*3600);
		mins = parseInt(rem_mins / 60, 10);
		seconds = parseInt(timer % 60, 10);
			
		if (timer == 0) {
			$(div).html('Expired!');
			return false;
		} else {
			hours = hours < 10 ? "0" + hours : hours;
			mins = mins < 10 ? "0" + mins : mins;
			seconds = seconds < 10 ? "0" + seconds : seconds;
			
			$(div).html(hours+'h : '+mins+'m : '+seconds+'s');
			timer--;
		}
	}, 1000);			
}
</script>
</body>
</html>
        
<?php }else{ 

	header('Location: index.php');
	
}?>
