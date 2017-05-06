
<?php
#awards.php - CS467, Emmalee Jones, Yae Jin Oh 
#Create Award PDFs
#Error Reporting Settings
error_reporting(E_ALL);
ini_set("display_errors", "ON");
//Start PHP Session
session_start();
include '../phpmysql/connect.php';
#Test for valid Session
if (!isset($_Session['employeeLastName']) && !isset($_SESSION['employeeLoggedIn'])) {
    $_SESSION = array();
    session_destroy();
    header("Location:../index.php");
    die();
}



if(!empty($_POST['export'])) {
    $awardID = $_POST['export'];
    require("../fpdf/fpdf.php");
    $pdf = new FPDF();

    $pdf->addPage();
    $pdf->SetFont("Arial", "B", "20");
    $pdf->Cell(0, 10, "Award Certificate", 0, 1, "C");

    $pdf->SetFont("Arial", "", "10");
    $pdf->Cell(0, 10, "certificate for: , " . $awardID . ". yay award", 0, 1, "C");

    $pdf->Output();
}
?>
