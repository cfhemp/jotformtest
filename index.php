<?php
// This function will run within each post array including multi-dimensional arrays
function ExtendedAddslash(&$params){
    foreach($params as &$var){
        // check if $var is an array. If yes, it will start another ExtendedAddslash() function to loop to each key inside.
        is_array($var) ? ExtendedAddslash($var) : $var=addslashes($var);
    }
}

// Initialize ExtendedAddslash() function for every $_POST variable
ExtendedAddslash($_POST);


$submission_id = $_POST['submission_id'];
$formID = $_POST['formID'];
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];


$db_host = 'localhost';
$db_username = 'topwax_jotform';
$db_password = 'wA]QGirhco^6';
$db_name = 'topwax_jotform';
mysql_connect( $db_host, $db_username, $db_password) or die(mysql_error());
mysql_select_db($db_name);


// search submission ID
$query = "SELECT * FROM `jotform` WHERE `submission_id` = '$submission_id'";
$sqlsearch = mysql_query($query);
$resultcount = mysql_numrows($sqlsearch);

if($resultcount > 0){
    mysql_query(
        "UPDATE `jotform` SET
        `name` = '$name',
        `email` = '$email',
        `message` = '$message'
        WHERE `submission_id` = '$submission_id'"
    ) or die(mysql_error());
}else{
    mysql_query(
        "INSERT INTO `jotform` (submission_id, formID, name, email,  message)
        VALUES ('$submission_id', '$formID', $name', '$email',  '$message')"
    ) or die(mysql_error());
}
?>
