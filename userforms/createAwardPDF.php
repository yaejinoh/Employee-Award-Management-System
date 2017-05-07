
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
        require("../fpdf/fpdf.php");
        // Landscape, units in mm, page size A4
        $pdf = new FPDF('L','mm','A4');
        $pdf->addPage();

        $pdf->SetFont("Arial", "", "10");
        $pdf->Cell(0, 10, "ID No. " . $awardID, 0, 1, "C");

        $pdf->SetFont("Arial", "B", "20");
        $pdf->Cell(0, 10, "Employee of the " . $CertificateType, 0, 1, "C");

        $pdf->SetFont("Arial", "", "10");
        $pdf->Cell(0, 10, "This certificate is presented to", 0, 1, "C");

        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 10, $AwardeeFirstName . " " . $AwardeeLastName, 0, 1, "C");

        $pdf->SetFont("Arial", "", "10");
        $pdf->Cell(0, 10, "In grateful recognition of your service and support at", 0, 1, "C");

        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 10, $Region, 0, 1, "C");

        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 10, $PresenterFirstName . " " . $PresenterLastName . "    " . $date, 0, 1, "C");

        //$SignatureImage = 'data://text/plain;base64,' . base64_encode($Signature);
        //$SignatureImage = data:image/png;base64,'.base64_encode($Signature).';
        //$info = getimagesize($SignatureImage);
        
        //$pdf->SetFont("Arial", "", "15");
        //$pdf->Image($SignatureImage, 10, 30, $info[0], $info[1], 'png');
        
        
        if($Signature!==false) {
            $filename = 'temp.png';
            //  Save image to a temporary location
            if(file_put_contents('../img/temp.png',$Signature)!==false) {
                $info = getimagesize('../img/temp.png');
                //  Open new PDF document and print image
                $pdf->Image('../img/temp.png', 10, 30, $info[0], $info[1], 'png');
            }
        }
        
    }
    
    $stmt->close();
    $pdf->Output();
    //  Delete image from server
    unlink('../img/temp.png');
}
?>
