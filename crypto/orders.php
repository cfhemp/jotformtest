<?php require_once 'config.php';

$result = $mysqli->query("SELECT * FROM orders ORDER BY order_id DESC");

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
                	<?php while($order=$result->fetch_assoc()){?>
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
                    <?php } ?>
                </tbody>
            </table>
    	</div>
    </div>
</div>
</body>
</html>

