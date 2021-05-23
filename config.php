<?php 
$config = array();

// Required
$config['public_key'] = 'e104e59c791649a1931936b32c810d286c810d16f0770917dfcb35ac231f744c';
$config['private_key'] = '56607852FA56bE0173f622A79f6A0fD5cadD2Ec675Ab7e984B70d01454Ec0557';

// Optional
$config['merchant_id'] = 'b290650810ac76085268589b656837f7';
$config['ipn_secret'] = 'lO+m9)Gh.NbP$9755KkO&S';

$config['ipn_debug_email'] = 'iamvasim@gmail.com';


// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection was successfully established!";

function send_email($to, $subject, $body)
{
	$from = 'info@kliptu.com';
	$reply_to = 'info@kliptu.com';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'X-Mailer: PHP/'.phpversion() . "\r\n";

	// Additional headers		
	$headers .= "From: Kliptu <".$from.">" . "\r\n";
	$headers .= "To: <".$to.">" . "\r\n";
	$headers .= "Reply-To: No-Reply <".$from.">" . "\r\n";
	$headers .= "Return-Path: ".$from." \r\n";
	
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>'.$subject.'</title>
				</head>
				<body>'.$body.'</body>
				</html>
				';
				
	$mail = @mail($to, $subject, $body, $headers, "-f".$from);			
	
	return $mail;
}
