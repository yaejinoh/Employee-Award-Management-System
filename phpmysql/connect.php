<?php

//Database for Host
$servername = "delphinusmysql.database.windows.net";
$usernameDb = "delphinus";
$passwordDb = "OSUdatproj8615";
$dbname = "delphinus";

$mysqli = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

if ($mysqli->connect_errno) {
    echo "Error: Database connection error: " . $mysqli->connect_errno . " - "
    . $mysqli->connect_error;
}
?>

