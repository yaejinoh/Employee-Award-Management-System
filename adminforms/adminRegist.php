<?php
#adminRegist.php - CS467, Emmalee Jones, Yae Jin Oh 
#Admin Regist 
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
                <div class="col-sm-4"></div> 
                <div class="col-sm-4"></div>
                <div class="col-sm-4" style="color:#FF0000" id="login_message"></div>
                </br>
            </div>     
        </div>  

        <!-- --------------------------------- Admin Sign In Form --------------------------------- -->
        <div class="container" >
            <div class="row">
                <div class="col-sm-8" >  
                    <h1>Admin Registration</h1>
                    <form method="POST" onsubmit="adminEdit();
                    return false;">
                        <label for="username" class="control-label">Username</label>
                        <input name="username" type="text" class="form-control" id="adminname2r" placeholder="Username(Email Address)" required>
                        <label for="password" class="control-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password4r" placeholder="Password" required>
                        <span class="help-block">Minimum of 8 characters</span>
                        <label for="confirmpassword" class="control-label">Confirm Password</label>
                        <input name="confirmpassword" type="password" class="form-control" id="confirmpassword2r" placeholder="Confirm Password" required>
                        </br>
                        <button type="submit" name="adminedit" class="btn btn-sm btn-primary">Submit</button> 

                    </form> 
                    </br>
                    <a href="adminMenu.php">Admin Menu</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">   
                <div class="col-sm-4"></div> 
                <div class="col-sm-4"></div>
                <div class="col-sm-6" style="color:#FF0000" id="error1_message"></div>
                <div class="col-sm-6" style="color:#FF0000" id="error2_message"></div>
                <div class="col-sm-6" style="color:#FF0000" id="error3_message"></div>
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