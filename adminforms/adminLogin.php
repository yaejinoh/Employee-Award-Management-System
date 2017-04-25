<?php

#adminLogin.php - CS467, Emmalee Jones, Yae Jin Oh 
#Admin Login and set session to go to Admina Menu page
#Error Reporting Settings
error_reporting(E_ALL);
ini_set("display_errors", "ON");
//Start PHP Session
session_start();

//Start PHP Session
include '../phpmysql/connect.php';

if (isset($_POST["adminname"]) && isset($_POST["password"])) {

    /* Adminname and Password */
    $adminname = $_POST["adminname"];
    $password = $_POST["password"];

    if (!($stmt = $mysqli->prepare("SELECT id, password, "
            . "emailaddress FROM admins WHERE emailaddress=? "))) {
        echo "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("s", $adminname)) {
        echo "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
    }

    $tabid = NULL;
    $tabPassword = NULL;
    $tabEmailAddress = NULL;

    if (!$stmt->bind_result($tabid, $tabPassword, $tabEmailAddress)) {
        echo "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->fetch()) {
        echo "Error: Failed fetch: (" . $stmt->errno . ") " . $stmt->error;
        echo "notOk";
    } else {
        if ($password === $tabPassword) {
            /* Create session variables */
            $_SESSION["adminid"] = $tabid;
            $_SESSION["adminEmailAddress"] = $tabEmailAddress;
            # employeeLoggedIn = 1 is for Admin Logged On
            $_SESSION["adminLoggedIn"] = 1;
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
