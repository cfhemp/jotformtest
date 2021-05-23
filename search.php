<?php require_once 'config.php';

if(isset($_POST['search'])){

$order_id = $_POST['order_id'];
$result = $mysqli->query("SELECT * FROM orders where order_id = '$order_id' ORDER BY order_id DESC");

    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orders</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <p style="margin:1.5rem 0;" class="h4">Search with Order ID</p>
            <form action="" method="post">
            <input type="text" name="order_id" required class="form-control" value="<?php echo $_POST['order_id'] ?: "" ?>" placeholder="Enter Order ID" >
            <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit" name="search">Search</button>
            </div> 
            </form>
        </div>  
        <?php if(isset($_POST['search'])){ ?>
    	<div class="col-md-12 col-sm-12">
            <p style="margin:1.5rem 0;" class="h4 text-center">Orders</p>
            <table class="table table-bordered table-hover">
            	<thead>
                	<tr>
                    	<th>Order ID</th>
                    	<th>TXN ID</th>
                        <th>Amount</th>
                        <th>Deposit</th>
                        <th>Deposit Address</th>
                        <th>Status</th>
                        <th>Order Time</th>
                        <th>Tracking ID</th>
                    </tr>
                </thead>
                <tbody>
                	<?php 
                	$found = 0;
                	while($order=$result->fetch_assoc()){
                	$found++;
                	?>
                    <tr>
                        <td><?php echo $order['order_id']?></td>
                    	<td><?php echo $order['txn_id']?></td>
                        <td>$<?php echo $order['amount_usd']?></td>
                        <td><?php echo $order['deposit_amount']?> <?php echo $order['deposit_currency']?></td>
                        <td><?php echo $order['deposit_address']?></td>
                        <td><?php echo $order['order_status'].' '.$order['status_text']?></td>
                        <td><?php echo date('d M, Y H:i:s', strtotime($order['order_time']))?></td>
                        <td><?php echo $order['tracking_id']?></td>
                    </tr>
                    <?php }
                    if($found==0){
                     ?>
                     <tr>
                        <td colspan="7" class="text-center">No data Found!</td>
                    </tr>
                     <?php  
                    }
                    ?>
                </tbody>
            </table>
    	</div>
    	<?php } ?>
    </div>
</div>
</body>
</html>

