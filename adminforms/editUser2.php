<?php
#editUser2.php - CS467, Emmalee Jones, Yae Jin Oh 
#Edit User2 from Admin Screen
#Error Reporting Settings
error_reporting(E_ALL);
ini_set("display_errors", "ON");
//Start PHP Session
session_start();

#Test for valid Session
if (!isset($_Session['adminEmailAddress']) && !isset($_SESSION['adminLoggedIn'])) {
    $_SESSION = array();
    session_destroy();
    header("Location:../index.php");
    die();
}

//Start PHP Session
include '../phpmysql/connect.php';

//Load the form first time
if (!empty($_POST)) {

    //   echo "post submit" . "</br>";

    $passedEdits = TRUE;
    $emailaddr = $_POST["emailaddr"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $signature = $_FILES["signature"];
    $adminid = $_SESSION["editid"];

#echo $emailaddr . "  " . "emailaddr" . "</br>";
#echo $firstname . "  " . "firstname" . "</br>";
#echo $lastname . "  " . "lastname" . "</br>";
#echo $password . "  " . "password" . "</br>";
#echo $confirmpassword . "  " . "confirmpassword" . "</br>";
#echo "</br>";

    if (filter_var($emailaddr, FILTER_VALIDATE_EMAIL) === false) {
        $error_msg[] = "Please enter a valid email.";
        $passedEdits = FALSE;
#echo $passedEdits . "  " . "valid email";
    }
    /* Test for Duplicate username */
    if (!($stmt = $mysqli->prepare("SELECT emailaddress, id FROM employees WHERE emailaddress=? "))) {
        $error_msg[] = "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
        $passedEdits = FALSE;
    }

    if (!$stmt->bind_param("s", $emailaddr)) {
        $error_msg[] = "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
        $passedEdits = FALSE;
        #echo $passedEdits . "  " . " failed bind ";
    }

    if (!$stmt->execute()) {
        $error_msg[] = "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
        $passedEdits = FALSE;
    }

    $tabemailaddr = NULL;
    $tabtestid = NULL;

    if (!$stmt->bind_result($tabemailaddr, $tabtestid)) {
        $error_msg[] = "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
        $passedEdits = FALSE;
    }

    if (!$stmt->fetch()) {
        
    } elseif ($adminid == $tabtestid) {
        
    } else {
        $error_msg[] = "User name already used, please try again.";
        $passedEdits = FALSE;
    }


    $stmt->close();

    $length = strlen(utf8_decode($password));
    if ($length < 8) {
        $error_msg[] = "Password must be as least 8 characters, please try again.";
        $passedEdits = FALSE;
    } else if ($password !== $confirmpassword) {
        $error_msg[] = "Passwords do not match, please try again.";
        $passedEdits = FALSE;
    }

    if (!preg_match("!image!", $_FILES["signature"]["type"])) {
        $error_msg[] = "Signature file is not an image, please try again.";
        $passedEdits = FALSE;
    }

    if ($passedEdits == TRUE) {

        $datetimestamp = date("Y-m-d H:i:s");
        $signature_path = "images/" . $_FILES["signature"]["name"];

        #echo $signature_path . "  " . "signaturepath" . "</br>";
        #echo $datetimestamp . "  " . "datetimestamp" . "</br>";

        define("UPLOAD_DIR", "../images/");
        $img = $_POST['image-data'];
        #echo $img . "  " . "img1" . "</br>";
        $img = str_replace("data:image/png;base64,", "", $img);
        $img = str_replace(" ", "+", $img);
        $data = base64_decode($img);
        #echo $data . "  " . "data img2" . "</br>";
        $sigfile = UPLOAD_DIR . uniqid() . ".png";

        if (!($stmt = $mysqli->prepare("UPDATE employees SET password=?, firstname=?, lastname=?, emailaddress=?, datetimestamp=?, signature=? WHERE id=?"))) {
            $error_msg[] = "Error: Prepare failed: (" . $mysqli->errno . ") "
                    . $mysqli->error;
            $passedEdits = FALSE;
        }

        if (!$stmt->bind_param("ssssssi", $password, $firstname, $lastname, $emailaddr, $datetimestamp, $data, $adminid)) {
            $error_msg[] = "Error: Binding parameters failed: (" . $stmt->errno
                    . ") " . $stmt->error;
            $passedEdits = FALSE;
        }

        if (!$stmt->execute()) {
            $error_msg[] = "Error: Execute failed: (" . $stmt->errno . ") "
                    . $stmt->error;
            $passedEdits = FALSE;
        } else {
            /* Valid New User */
            $error_msg[] = "User is modified.";
        }
        $stmt->close();
    }
} else {
    /* Username and Password */

    //echo $_SESSION["editid"] . "  " . "employee id" . "</br>";

    $employeeid = $_SESSION["editid"];

    if (!($stmt = $mysqli->prepare("SELECT firstname, lastname, password, "
            . "emailaddress, signature FROM employees WHERE id=? "))) {
        $error_msg[] = "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("i", $employeeid)) {
        $error_msg[] = "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        $error_msg[] = "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
    }

    $tabFirstName = NULL;
    $tabLastName = NULL;
    $tabPassword = NULL;
    $tabEmailAddress = NULL;
    $tabsignature = NULL;

    if (!$stmt->bind_result($tabFirstName, $tabLastName, $tabPassword, $tabEmailAddress, $tabsignature)) {
        $error_msg[] = "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->fetch()) {
        $error_msg[] = "Error: Failed fetch: (" . $stmt->errno . ") " . $stmt->error;
        $error_msg[] = "notOk";
    } else {

        $_POST["emailaddr"] = $tabEmailAddress;
        $_POST["firstname"] = $tabFirstName;
        $_POST["lastname"] = $tabLastName;
        $_POST["password"] = $tabPassword;
        $_POST["confirmpassword"] = $tabPassword;
    }
    $stmt->close();
}

//echo  "mysqli close" . "</br>";

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
        <script src="../js/jquery.cropit.js"></script>

    </head>
    <body>
        <!-- --------------------------------- Navigation Bar --------------------------------- -->

        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <a class="navbar-brand" href="adminLogout.php"> Employee Recognition Awards</a>  
                    <form class="navbar-brand pull-right">
                        <a> <?php echo "Admin Email Address:" . " " . $_SESSION['adminEmailAddress']; ?> </a>
                    </form>
                    <!-- --------------------------------- Registration Form --------------------------------- -->
                    <form class="navbar-form pull-right" method="POST" action="adminLogout.php">
                        <input type="submit" value = "Sign out" name="logout form)"> 
                    </form>
                </nav>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            </div>
        </div>
        <div class="container">
            <div class="row"> 
                <br/>
                <div class="col-sm-4" style="color:#FF0000" id="login_message"></div>
                <div class="col-sm-4"></div> 
                <div class="col-sm-4"></div>
                </br>
            </div>     
        </div>  

        <!-- --------------------------------- User Mod Form --------------------------------- -->
        <div class="container" >
            <div class="row">
                <div class="col-sm-8" >  
                    <h1>Edit User</h1>
                    <form method="POST" id="modification" enctype="multipart/form-data" action="editUser2.php">  
                        <!--  <form method="POST" id="registration" enctype="multipart/form-data"  onsubmit="userEdit(); return false;"> -->
                        <label for="emailaddr" class="control-label">Username</label>
                        <input name="emailaddr" type="text" class="form-control" id="emailaddr" placeholder="Username(Email Address)" value="<?PHP if (isset($_POST['emailaddr'])) echo htmlspecialchars($_POST['emailaddr']); ?>" required>
                        <label for="firstname" class="control-label">First Name</label>
                        <input name="firstname" type="text" class="form-control" id="firstname" placeholder="First Name" value="<?PHP if (isset($_POST['firstname'])) echo htmlspecialchars($_POST['firstname']); ?>" required>
                        <label for="lastname" class="control-label">Last Name</label>
                        <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last Name" value="<?PHP if (isset($_POST['lastname'])) echo htmlspecialchars($_POST['lastname']); ?>" required>
                        <label for="password" class="control-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="<?PHP if (isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>" required>
                        <span class="help-block">Minimum of 8 characters</span>
                        <label for="confirmpassword" class="control-label">Confirm Password</label>
                        <input name="confirmpassword" type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password" value="<?PHP if (isset($_POST['confirmpassword'])) echo htmlspecialchars($_POST['confirmpassword']); ?>" required>
                        <div class="image-editor">
                            <label>Upload Signature</label><input type="file" class="cropit-image-input" name="signature" accept="image/*" required />
                            <div class="cropit-preview img-responsive"></div>
                            <div class="image-size-label">
                                Resize image
                            </div>
                            <input type="range" class="cropit-image-zoom-input">
                            <input type="hidden" name="image-data" class="hidden-image-data" />
                        </div>

                        </br>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-4"> <button type="submit" name="modification" class="btn btn-sm btn-primary">Submit</button>
                                    </form>
                                    </br> 
                                    </br>
                                    <a href="editUser.php">Edit/Delete User</a>
                                    </br>
                                    </br>
                                    <a href="adminMenu.php">Admin Menu</a> 

                                    <div style="color:#FF0000">
                                        </br>

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
            </div>
        </div>

        <div class="container">
            <div class="row">   
                <div class="col-sm-4" style="color:#006600" id="signed_message"></div>
                <div class="col-sm-4"></div> 
                <div class="col-sm-4"></div>
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

        <script>
            $(function () {
                $('.image-editor').cropit();
                $('form').submit(function () {
                    var imageData = $('.image-editor').cropit('export');
                    $('.hidden-image-data').val(imageData);
                });
            });
        </script>   
    </body>
</html>

