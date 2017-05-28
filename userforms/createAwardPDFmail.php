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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Delphinus Employee Recognition">
        <meta name="author" content="Emmalee Jones, Yae Jin Oh">

        <title>Employee Recognition Awards</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/blog.css" rel="stylesheet">
	<link href="../css/award.css" rel="stylesheet">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/functions.js"></script>

    </head>
    <body>
        <!-- --------------------------------- Navigation Bar --------------------------------- -->

        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <a class="navbar-brand" href="userLogout.php"> Employee Recognition Awards</a>  
                    <form class="navbar-brand pull-right">
                         <a> <?php echo "Employee Name:" . " " . $_SESSION['employeeFirstName']. " " . $_SESSION['employeeLastName'] ; ?> </a>
                    </form>
                    <!-- --------------------------------- Logout Form --------------------------------- -->
                    <form class="navbar-form pull-right" method="POST" action="userLogout.php">
                        <input type="submit" value = "Sign out" name="logout form)"> 
                    </form>
                </nav>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            </div>
        </div>
        <div class="container">
            <div class="row"> 
                <br/>
                <div class="col-sm-4"></div> 
                <div class="col-sm-4"></div>
                <div class="col-sm-4" style="color:#FF0000" id="login_message"></div>
                </br>
            </div>     
        </div>  

        <!-- --------------------------------- Admin Sign In Form --------------------------------- -->
        <div class="container" >
            <h1>Award Creation</h1>
            </br>
            </br>

<!-- --------------------------------- If the user submitted --SEND TO RECIPIENT-- button --------------------------------- -->
<?php
if(!empty($_POST['export-mail'])) {
    $awardID = $_POST['awardID'];
    
    if(! ($stmt = $mysqli->prepare( 
    "SELECT	A.id, A.date, A.time,
        PE.firstname AS PresenterFirstName, 
        PE.lastname AS PresenterLastName,  
        AE.emailaddress AS Email,
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
    if(!$stmt->bind_result($id, $date, $time, $PresenterFirstName, $PresenterLastName, $Email, $AwardeeFirstName, $AwardeeLastName, $CertificateType, $Region, $Signature)){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    while($stmt->fetch()){
        require("../fpdf/alphapdf.php");
        
        $pdf = new AlphaPDF('L','mm','A4');
        $pdf->addPage();
        
        $pdf->SetAlpha(1);
        // draw jpeg image
        $border_info = getimagesize('../img/certificate-border.jpg');
        $pdf->Image('../img/certificate-border.jpg', 0, 0, 299, "jpg");
       
        // restore full opacity
        $pdf->SetAlpha(1);
        
        $pdf->SetFont("Arial", "", "8");
        // USAGE: (width, height, "text", border, pos after cell, alignment)
        $pdf->Cell(0, 10, "                                               ID No. " . $awardID, 0, 1, "L");

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
                $pdf->Image('../img/temp.png', 180, 140, 0, 25, 'png');
            }
        }
        
        $pdf->Line(175, 160, 260, 160);
        
        $pdf->SetFont("Arial", "", "15");
        $pdf->Cell(0, 15, $PresenterFirstName . " " . $PresenterLastName . "                     ", 0, 0, "R");
        
        $stamp_info = getimagesize('../img/certstamp.png');
        $stamp_infosmaller[0] =  $stamp_info[0] / 7;
        $stamp_infosmaller[1] =  $stamp_info[1] / 7;
        $pdf->Image('../img/certstamp.png', 130, 125, $stamp_infosmaller[0], $stamp_infosmaller[1], 'png');
    }
    //  Delete image from server
    unlink('../img/temp.png');
    
    // If able to save pdf to github dir
    $dir = 'tempfile.pdf';
    if($pdf->Output($dir,'F')!==false) {
        require '../PHPMailer/PHPMailerAutoload.php';
        
        // SOURCE: PHPMailer github library - https://github.com/PHPMailer/PHPMailer 
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 0;                                                       // Enable debug output (0 for none, otherwise 3 for ouput)
        //$mail->Debugoutput = 'html';                                                // Output debugging as html
        $mail->isSMTP();                                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                                             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                                     // Enable SMTP authentication
        $mail->Username = "delphinusstate@gmail.com";                               // SMTP username
        $mail->Password = "test123$";                                               // SMTP password
        $mail->SMTPSecure = 'tls';                                                  // Enable TLS encryption
        $mail->Port = 587;                                                          // TCP por
        
        $mail->setFrom('delphinusstate@gmail.com', 'Employee Recognition');
        $mail->addAddress($Email, $AwardeeFirstName . " " . $AwardeeLastName);      // Send to awardee's email
        $mail->addAttachment('tempfile.pdf');                                       // Add award PDF attachment
        $mail->isHTML(true);                                                        // Set email format to HTML
        
        $mail->Subject = 'Congratulations! You have been selected for an award by Delphinus';
        $mail->Body    = 'Congrats! After careful consideration, your contribution to Delphinus has been recognized and you have been selected for an award. Please see the attached file.';
        $mail->AltBody = 'Congrats! After careful consideration, your contribution to Delphinus has been recognized and you have been selected for an award. Please see the attached file.';
   
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
	    echo "<div align='center' style='font:15px; color:#ff0000; font-weight:bold'>Award has been sent to " . $AwardeeFirstName . " " . $AwardeeLastName . ".</div>"; 
            echo '<form action=\'awards.php\' method="post">
			<input type="submit" name="return" value="Go Back">
		  </form>';
        }
    }
    else {
        echo "error attaching pdf";
    }
    unlink('tempfile.pdf');
    $stmt->close();
    $mysqli->close();
?>
		      
            </br> 
            <a href="userMenu.php">User Menu</a>
            </br>
 <!--       </div> -->
        <div class="container">
            <div class="row">   
                <div class="col-sm-4"></div> 
                <div class="col-sm-4"></div>
                <div class="col-sm-4" style="color:#006600" id="signed_message"></div>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
            </div>     
        </div>
        <!-- --------------------------------- Footer --------------------------------- -->
        <footer class="blog-footer">
            <p>Powered by <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a></p>
        </footer>
        <script src="../js/bootstrap.min.js"></script>

    </body>
</html>
