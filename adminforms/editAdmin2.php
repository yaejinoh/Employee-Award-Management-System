<?php
#editAdmin2.php - CS467, Emmalee Jones, Yae Jin Oh 
#Edit/Delete Admin User - Edit of Admin User 
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
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $adminid = $_SESSION["editid"];

    #echo $emailaddr . "  " . "emailaddr" . "</br>";
    #echo $password . "  " . "password" . "</br>";
    #echo $confirmpassword . "  " . "confirmpassword" . "</br>";
    #echo "</br>";

    if (filter_var($emailaddr, FILTER_VALIDATE_EMAIL) === false) {
        $error_msg[] = "Please enter a valid email.";
        $passedEdits = FALSE;
#echo $passedEdits . "  " . "valid email";
    }
    /* Test for Duplicate username */

    if (!($stmt = $mysqli->prepare("SELECT emailaddress, id FROM admins WHERE emailaddress=? "))) {
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
    $tabetestid = NULL;

    if (!$stmt->bind_result($tabemailaddr, $tabtestid)) {
        $error_msg[] = "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
        $passedEdits = FALSE;
    }

    if (!$stmt->fetch()) {

        #echo $adminid . "  " . "adminid" . "</br>";
        #echo "</br>";
        #echo $tabtestid . "  " . "tabtestid" . "</br>";
        #echo "</br>";
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

    if ($passedEdits == TRUE) {

        $datetimestamp = date("Y-m-d H:i:s");

        $adminid = $_SESSION["editid"];

        #echo $datetimestamp . "  " . "datetimestamp" . "</br>";
        #echo "</br>";
        #echo $adminid . "  " . "adminid" . "</br>";
        #echo "</br>";

        if (!($stmt = $mysqli->prepare("UPDATE admins SET  password=?, emailaddress=?, datetimestamp=? WHERE id=?"))) {
            $error_msg[] = "Error: Prepare failed: (" . $mysqli->errno . ") "
                    . $mysqli->error;
            $passedEdits = FALSE;
        }

        if (!$stmt->bind_param("sssi", $password, $emailaddr, $datetimestamp, $adminid)) {
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

    #echo $_SESSION["editid"] . "  " . "edit id" . "</br>";

    $adminid = $_SESSION["editid"];

    if (!($stmt = $mysqli->prepare("SELECT password, "
            . "emailaddress FROM admins WHERE id=? "))) {
        $error_msg[] = "Error: Failed prepare: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("i", $adminid)) {
        $error_msg[] = "Error: Failed Bind: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        $error_msg[] = "Error: Failed execute: (" . $stmt->errno . ") " . $stmt->error;
    }

    $tabPassword = NULL;
    $tabEmailAddress = NULL;

    if (!$stmt->bind_result($tabPassword, $tabEmailAddress)) {
        $error_msg[] = "Error: Failed bind_result: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->fetch()) {
        $error_msg[] = "Error: Failed fetch: (" . $stmt->errno . ") " . $stmt->error;
        $error_msg[] = "notOk";
    } else {

        $_POST["emailaddr"] = $tabEmailAddress;
        $_POST["password"] = $tabPassword;
        $_POST["confirmpassword"] = $tabPassword;
    }
    $stmt->close();
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

        <div class="container" >
            <h1>Admin Modification</h1>
            <form method="POST" id="modification" action="editAdmin2.php">
                <label for="emailaddr" class="control-label">Username</label>
                <input name="emailaddr" type="text" class="form-control" id="emailaddr" placeholder="Username(Email Address)" value="<?PHP if (isset($_POST['emailaddr'])) echo htmlspecialchars($_POST['emailaddr']); ?>" required>
                <label for="password" class="control-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="<?PHP if (isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>" required>
                <span class="help-block">Minimum of 8 characters</span>
                <label for="confirmpassword" class="control-label">Confirm Password</label>
                <input name="confirmpassword" type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password" value="<?PHP if (isset($_POST['confirmpassword'])) echo htmlspecialchars($_POST['confirmpassword']); ?>" required>
                </br>
                <button type="submit" name="adminedit" class="btn btn-sm btn-primary">Submit</button> 

            </form> 
            </br>
            <a href="editAdmin.php">Edit/Delete Admin</a>
            </br>
            <a href="adminMenu.php">Admin Menu</a>
        </div>
        </br>
        <div class="container">
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
            <div class="container">
                <div class="row">   
                    <div class="col-sm-4"></div> 
                    <div class="col-sm-4"></div>
                    <div class="col-sm-6" style="color:#FF0000" id="error1_message"></div>
                    <div class="col-sm-6" style="color:#FF0000" id="error2_message"></div>
                    <div class="col-sm-6" style="color:#006600" id="error3_message"></div>
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

