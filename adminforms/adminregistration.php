<?php
#adminresgistration.php - CS467, Emmalee Jones, Yae Jin Oh 
#Admin Login and set session to go to Admin Menu page
#Error Reporting Settings
error_reporting(E_ALL);
ini_set("display_errors", "ON");
//Start PHP Session
session_start();

//Start PHP Session
include '../phpmysql/connect.php';
 
if ($mysqli->connect_errno) {
    echo "Error: Database connection error: " . $mysqli->connect_errno . " - "
    . $mysqli->connect_error;
}
/*Bring in data from POST*/
$username = $_POST["username"];
$password = $_POST["password"];
$datetimestamp = date("Y-m-d H:i:s");
$passedEdits = TRUE;


if (filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
        echo "Bademail"; 
    $passedEdits = FALSE;
}

/*Test for Duplicate username*/
if (!($stmt = $mysqli->prepare("SELECT emailaddress FROM admins WHERE emailaddress=? "))) {
    echo "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
}
    
if (!$stmt->bind_param("s", $username)) {    
    echo "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
}
    
if (!$stmt->execute()) {
    echo "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
}
    
$tabusername = NULL;
    
if (!$stmt->bind_result($tabusername)) {
    echo "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
}
          
if(!$stmt->fetch()){  
    //echo "Error: Failed fetch: (" . $stmt->errno . ") " . $stmt->error;
    //No match 
}
else {
    echo "Dupname"; 
    $passedEdits = FALSE;
}
    
$stmt->close();  

#Passed Edits and store row in database
if ($passedEdits === TRUE) {

    /*Insert a new user*/

   
    if (!($stmt = $mysqli->prepare("INSERT INTO admins (password, emailaddress, datetimestamp) VALUES (?, ?, ?)"))) {
        echo "Error: Prepare failed: (" . $mysqli->errno . ") " 
                    . $mysqli->error;
    } 
    
    if (!$stmt->bind_param("sss", $password, $username, $datetimestamp)) {
                    echo "Error: Binding parameters failed: (" . $stmt->errno 
                        . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
                    echo "Error: Execute failed: (" . $stmt->errno . ") " 
                        . $stmt->error;
    }
    else {
     /* Valid New User */   
        echo "ok";   
    }
    $stmt->close(); 
}
$mysqli->close();
?>

