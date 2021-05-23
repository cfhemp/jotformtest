<?php
/******************************************************
 
JotForm to MySQL Database Through Webhook - Sample Script
Elton Cris - JotForm Tech Support
www.jotform.com
 
Test form: https://form.jotform.com/62893435003959
Check request here: https://jotthemes.000webhostapp.com/jotform/view.php
 
******************************************************/
 
//Replace with your DB Details
$servername = "localhost";
$username = "idshubsc_kliptu";
$password = 'Rzp$vA}7CES{';
$dbname = "idshubsc_crypto";
$dbtable = "orders";
 
//Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
 
//Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
 
//Get field values from the form
//Get unique submissionID - nothing to change here
$sid = $mysqli->real_escape_string($_REQUEST['submissionID']);
 
//Get form field values and decode - nothing to change here
$fieldvalues = $_REQUEST['rawRequest'];
$obj = json_decode($fieldvalues, true);
 
//Replace the field names from your form here
$user_email = $mysqli->real_escape_string($obj['q54_email']);
$amount_usd = $mysqli->real_escape_string($obj['q279_total']);
 
$result = $mysqli->query("SELECT * FROM $dbtable WHERE sid = '$sid'");
 
//If submission ID exist, update record
if ($result->num_rows > 0) {
    $result = $mysqli->query("UPDATE $dbtable SET   amount_usd = '$amount_usd', user_email = '$user_email' WHERE sid = '$sid'");
    echo "Existing Record Updated!";
}
//If new submission, insert record
else{
    $result = $mysqli->query("INSERT IGNORE INTO $dbtable (sid, user_email, amount_usd) VALUES ('$sid', '$user_email', '$amount_usd')");
    echo "New Record Added!";
    if ($result === false) {echo "SQL error:".$mysqli->error;}
}
 
$mysqli->close();
?>