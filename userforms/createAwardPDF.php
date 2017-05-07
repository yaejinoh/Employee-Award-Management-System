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
    $awardID = $_POST['awardID'];
    
    if(! ($stmt = $mysqli->prepare( 
    "SELECT	A.id, A.date, A.time,
        PE.firstname AS PresenterFirstName, 
        PE.lastname AS PresenterLastName,  
        AE.firstname AS AwardeeFirstName, 
        AE.lastname AS AwardeeLastName,
        CT.type AS CertificateType,
        R.sector AS Region,
        A.signature AS Signature
    FROM Awards A
    JOIN Employees PE ON PE.id=A.name
    JOIN Employees AE ON AE.id=A.awardee
    JOIN CertType CT ON CT.ctid=A.type
    JOIN Regions R ON R.rid=A.region
    WHERE A.id = '$awardID';"))){
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    } 
    if(!$stmt->execute()){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->bind_result($id, $date, $time, $PresenterFirstName, $PresenterLastName, $AwardeeFirstName, $AwardeeLastName, $CertificateType, $Region, $Signature)){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    while($stmt->fetch()){
//        require("../fpdf/fpdf.php");
        require("../fpdf/alphapdf.php");
        
        // Landscape, units in mm, page size A4
//        $pdf = new FPDF('L','mm','A4');       // commented out, experimenting with transparency add-on
        $pdf = new AlphaPDF('L','mm','A4');
        $pdf->addPage();
        
        // set alpha to semi-transparency
  //      $pdf->SetAlpha(0.5);
        $pdf->SetAlpha(1);
        // draw jpeg image
        $border_info = getimagesize('../img/certificate-border.jpg');
        $pdf->Image('../img/certificate-border.jpg', 0, 0, 299, "jpg");
       
        // restore full opacity
        $pdf->SetAlpha(1);
        
        $pdf->SetFont("Arial", "", "8");
        // USAGE: (width, height, "text", border, pos after cell, alignment)
        $pdf->Cell(0, 10, "                                               ID No. " . $awardID, 0, 1, "L");

      //  $pdf->SetFont("Arial", "B", "30");
      //  $pdf->Cell(0, 10, "", 0, 1, "C");
        
        $pdf->SetFont("Arial", "B", "40");
        $pdf->Cell(0, 40, $CertificateType, 0, 1, "C");
        
        $pdf->Line(50, 53, 250, 53);

        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 10, "This certificate is awarded to", 0, 1, "C");

        $pdf->SetFont("Arial", "", "26");
        $pdf->Cell(0, 20, $AwardeeFirstName . " " . $AwardeeLastName, 0, 1, "C");

        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 10, "In grateful recognition of your service and support at", 0, 1, "C");

        $pdf->SetFont("Arial", "", "18");
        $pdf->Cell(0, 10, $Region, 0, 1, "C");

        $pdf->SetFont("Arial", "", "10");
        $pdf->Cell(0, 20, "", 0, 1, "C");
        
        $pdf->SetFont("Arial", "", "10");
        $pdf->Cell(0, 10, "Presented by                                                       ", 0, 1, "R");
        
        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 20, "                              " . $date, 0, 1, "L");
        
        if($Signature!==false) {
            $filename = 'temp.png';
            //  Save image to a temporary location
            if(file_put_contents('../img/temp.png',$Signature)!==false) {
                $info = getimagesize('../img/temp.png');
                $infosmaller[0] = $info[0] / 3;
                $infosmaller[1] = $info[1] / 3;
                // Open new PDF document and print image
                // USAGE: Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
                $pdf->SetFont("Arial", "", "15");
//                $pdf->Image('../img/temp.png', 80, 150, 0, $infosmaller[1], 'png');
                $pdf->Image('../img/temp.png', 180, 140, 0, 25, 'png');
            }
        }
        
        $pdf->Line(175, 160, 255, 160);
        
        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 15, $PresenterFirstName . " " . $PresenterLastName . "                              ", 0, 0, "R");
        
        $stamp_info = getimagesize('../img/certstamp.png');
        $stamp_infosmaller[0] =  $stamp_info[0] / 7;
        $stamp_infosmaller[1] =  $stamp_info[1] / 7;
        $pdf->Image('../img/certstamp.png', 130, 125, $stamp_infosmaller[0], $stamp_infosmaller[1], 'png');
    }
    
    
    
    $stmt->close();
    $pdf->Output();
    //  Delete image from server
    unlink('../img/temp.png');
}
?>
