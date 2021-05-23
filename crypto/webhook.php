<form action="webhook.php" method="GET">
    Username: <input type="text" name="email">
   
</form>


<?php
$email = $_GET['email'];
echo $email;
?>
