<?php

//Database for Host
$servername = "us-cdbr-azure-east-c.cloudapp.net";
$usernameDb = "bd07944a668fd5";
$passwordDb = "ee00cbfd";
$dbname = "employeerecognition";

$mysqli = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

if ($mysqli->connect_errno) {
    echo "Error: Database connection error: " . $mysqli->connect_errno . " - "
    . $mysqli->connect_error;	#
}
?>

