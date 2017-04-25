<?php

#userLogin.php - CS467, Emmalee Jones, Yae Jin Oh 
#User Login and set session to go to User Menu page
#Error Reporting Settings
error_reporting(E_ALL);
ini_set("display_errors", "ON");
//Start PHP Session
session_start();

//Start PHP Session
include '../phpmysql/connect.php';

if (isset($_POST["username"]) && isset($_POST["password"])) {

    /* Username and Password */
    $username = $_POST["username"];
    $password = $_POST["password"];

    #$hashed_password = \base64_encode(hash("sha256",$password));

    if (!($stmt = $mysqli->prepare("SELECT id, firstname, lastname, password, "
            . "emailaddress FROM employees WHERE emailaddress=? "))) {
        echo "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("s", $username)) {
        echo "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
    }

    $tabid = NULL;
    $tabFirstName = NULL;
    $tabLastName = NULL;
    $tabPassword = NULL;
    $tabEmailAddress = NULL;

    if (!$stmt->bind_result($tabid, $tabFirstName, $tabLastName, $tabPassword, $tabEmailAddress)) {
        echo "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->fetch()) {
        echo "Error: Failed fetch: (" . $stmt->errno . ") " . $stmt->error;
        echo "notOk";
    } else {
        if ($password === $tabPassword) {
            /* Create session variables */
            $_SESSION["employeeid"] = $tabid;
            $_SESSION["employeeFirstName"] = $tabFirstName;
            $_SESSION["employeeLastName"] = $tabLastName;
            $_SESSION["employeeEmailAddress"] = $tabEmailAddress;
            # employeeLoggedIn = 1 is for Employee Logged On
            $_SESSION["employeeLoggedIn"] = 1;
            echo "ok";
        } else {
            echo "Password does not match";
            echo "notOk";
        }
    }
    $stmt->close();
    $mysqli->close();
}
?>
