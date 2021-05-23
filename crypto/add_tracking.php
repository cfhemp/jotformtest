<?php

require_once 'config.php';

 
if(isset($_POST['btnAdd']))
{
    $error = "";
	$order_id = $_POST['order_id'];
	$tracking_id = $_POST['tracking_id'];
	
	$result = $mysqli->query("SELECT * FROM orders WHERE tracking_id = '$tracking_id'");
    if ($result->num_rows > 0) {
        
        $error = "Tracking ID already Present!";
    }
	else{
	$query = "UPDATE `orders` SET `tracking_id`= '$tracking_id' WHERE order_id = '$order_id'";
	$mysqli->query($query);
	
	?>
	<script>
	    alert("Tracking ID added!")
	    window.location.href="orders.php"
	</script>
	<?php
	}
}	
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
            <p style="margin:1.5rem 0;" class="h4 text-center">ADD Tracking ID</p>
            <div class="card">
            	<div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Select Order ID</label>
                            <select name="order_id" class="form-control">
                                <?php 
                                $result = $mysqli->query("SELECT * FROM orders ORDER BY order_id DESC");
                                while($order=$result->fetch_assoc()){
                                ?>
                                <option><?php echo $order['order_id'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Tracking ID</label>
                            <input type="text" name="tracking_id" required class="form-control" placeholder="Tracking ID" />
                        </div>
                        <div class="form-group">
                            <p class="label alert-danger text-center"><?php echo $error; ?></p>
                            <button class="btn btn-success btn-block" type="submit" name="btnAdd">ADD</button>
                        </div>        
                    </form>
            	</div>
            </div>
    	</div>
    </div>
</div>
</body>
</html>
