<?php

//Database for Host
/*
$servername = "us-cdbr-azure-east-c.cloudapp.net";
$usernameDb = "bd07944a668fd5";
$passwordDb = "ee00cbfd";
$dbname = "employee_recognition";
*/

// Database v2.0
$servername = "us-cdbr-azure-east-c.cloudapp.net";
$usernameDb = "b55264aeb0054a";
$passwordDb = "10beb550";
$dbname = "employee_recognition_v2";

$mysqli = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

if ($mysqli->connect_errno) {
    echo "Error: Database connection error: " . $mysqli->connect_errno . " - "
    . $mysqli->connect_error;	#
}
?>

