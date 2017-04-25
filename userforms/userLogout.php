<?php
#userLogout.php - CS290, Emmalee Jones, Assignment Final Project
#Destroy all sessions
#Error Reporting Settings
error_reporting(E_ALL);
ini_set('display_errors', 'ON');
session_start();
session_destroy();
header("Location:../index.php");
die();
?>