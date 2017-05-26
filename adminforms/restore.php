<?php
#restore.php - CS467, Emmalee Jones, Yae Jin Oh
#User Restore Menu
#Error Reporting Settings
include "../phpmysql/connect.php";
require '../PHPMailer/PHPMailerAutoload.php';

$form_email = '';
//$error_msg[] = '';
//Set edit flag
$passedEdits = TRUE;

if (!empty($_POST)) {

    $emailaddr = $_POST["emailaddr"];

    //echo $passedEdits . "  " . "valid email";

    if (filter_var($emailaddr, FILTER_VALIDATE_EMAIL) === false) {
        $error_msg[] = "Please enter a valid email.";
        $passedEdits = FALSE;
        // echo $passedEdits . "  " . "invalid email";
    }


    if ($passedEdits == TRUE) {
        /* Test for Duplicate username */
        if (!($stmt = $mysqli->prepare("SELECT emailaddress, password, firstname, lastname FROM employees WHERE emailaddress=? "))) {
            $error_msg[] = "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
//$passedEdits = FALSE;
        }

        if (!$stmt->bind_param("s", $emailaddr)) {
            $error_msg[] = "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
//$passedEdits = FALSE;
#echo $passedEdits . "  " . " failed bind ";
        }

        if (!$stmt->execute()) {
            $error_msg[] = "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
//$passedEdits = FALSE;
        }

        $tabemailaddr = NULL;
        $tabFirstName = NULL;
        $tabLastName = NULL;
        $tabPassword = NULL;

        if (!$stmt->bind_result($tabemailaddr, $tabPassword, $tabFirstName, $tabLastName)) {
            $error_msg[] = "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
//$passedEdits = FALSE;
        }

        if (!$stmt->fetch()) {

//$form_email = htmlentities($_POST["emailaddr"]);
            $error_msg[] = "This account does not exist. Try again.";
        } else {


            // echo $tabemailaddr . "</br>";
            // echo $tabFirstName . "</br>";
            // echo $tabLastName . "</br>";
            // echo $tabPassword . "</br>";
            $tabFullName = $tabFirstName . " " . $tabLastName;

            // echo $tabFullName . "</br>";
            date_default_timezone_set('America/Los_Angeles');

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "delphinusstate@gmail.com";
            $mail->Password = "test123$";
            $mail->setFrom('delphinusstate@gmail.com', 'Employee Recognition');
            $mail->addAddress($tabemailaddr, $tabFullName);
            $mail->Subject = 'Delphinus Employee Recognition - Password Recovery';
            $mail->isHTML(true);
            $mail->Body = "This is your password: " . $tabPassword;
            if (!$mail->send()) {
                $error_msg[] = "Error: " . $mail->ErrorInfo;
            } else {
                $error_msg[] = "Email: " . $tabemailaddr . " password sent.";
            }
        }

        $stmt->close();
    }
}
$mysqli->close();
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
        <script src="../js/jquery.min.js"></script>
        <script src="../js/functions.js"></script>

    </head>
    <body>
        <!-- --------------------------------- Navigation Bar --------------------------------- -->

        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <h2><a class="navbar-brand" href="../index.php"> Employee Recognition Awards</a></h2>                   
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

        <!-- --------------------------------- Restore Form --------------------------------- -->
        <div class="container" >
            <div class="row">
                <div class="col-sm-8" >   
                    <h1>Password Recovery</h1>
                    <form method="POST" action="restore.php">
                        <label for="emailaddr" class="control-label">Email Address</label>
                        <input name="emailaddr" type="text" class="form-control" id="emailaddr" placeholder="Username(Email Address)" required>
                        </br>
                        <button type="submit" name="recovery" class="btn btn-sm btn-primary ">Submit</button> 
                    </form> 
                    </br>
                    <a href="../index.php">User Sign In</a>
                    </br>

                    <div class="row">
                        <div class="col-sm-6" style="color:#FF0000"</div>

                        <?php
                        if (isset($error_msg)) {
                            foreach ($error_msg as $message) {
                                echo $message . "<br/>";
                            }
                        }
                        ?>  

                    </div>
                </div>    
            </div>
        </div>
    </div>
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
