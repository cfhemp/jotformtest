<?php
/******************************************************
 
JotForm to MySQL Database Through Webhook - Sample Script
Elton Cris - JotForm Tech Support
www.jotform.com
 
Test form: https://form.jotform.com/62893435003959
Check request here: https://jotthemes.000webhostapp.com/jotform/view.php
 
******************************************************/

//Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
//Get field values from the form
//Get unique submissionID - nothing to change here
$sid = $mysqli->real_escape_string($_POST['submission_id']);


/*foreach ($_POST as $key => $value) {
    echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
}*/
 
//Get form field values and decode - nothing to change here
$fieldvalues = $_REQUEST['rawRequest'];
$obj = json_decode($fieldvalues, true);


//Replace the field names from your form here
$user_email = $mysqli->real_escape_string($_POST['email']);
if($_POST['payment']=="BitCoin"){
$amount_usd = $mysqli->real_escape_string($_POST['15discount280']);
}
else{
$amount_usd = $mysqli->real_escape_string($_POST['total']);
}
$amount_usd = str_replace('$','',$amount_usd);



$user_email = "";
if(isset($_GET['mail']))
    $user_email = $_GET['mail'];

$amount_usd = "";
if(isset($_GET['amount']))
    $amount_usd = $_GET['amount'];
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IdsHubs.com</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
    	<div class="col-md-4 col-sm-6 mx-auto">
            <p style="margin:1.5rem 0;" class="h4 text-center">IdsHubs.com</p>
            <p style="margin:1.5rem 0;" class="h4 text-center"><a href="https://track.idshubs.com" target="_blank">Track Order</a></p>
            <div class="card">
            	<div class="card-body">
                    <form action="create_transaction.php" method="post">
                        <div class="form-group">
                            <label>Enter email address</label>
                            <input type="text" name="buyer_email" <?php if($user_email!=""){echo "readonly";} ?> class="form-control" value="<?php echo $user_email; ?>" placeholder="e.g. yourname@gmail.com" />
                            <input type="hidden" name="sid" readonly value="<?php echo $sid; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Enter deposit amount (USD)</label>
                            <input type="text" name="amount" readonly class="form-control" value="<?php echo $amount_usd; ?>" placeholder="e.g. 10" />
                        </div>
                        <div class="form-group">
                            <label>Payment via Cryptocoins</label>
                            <select name="currency2" class="form-control">
                                <option value="BTC">BTC - Bitcoin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit" name="btnDeposit">Pay Now</button>
                        </div>        
                    </form>
            	</div>
            </div>
    	</div>
    </div>
</div>
</body>
</html>
