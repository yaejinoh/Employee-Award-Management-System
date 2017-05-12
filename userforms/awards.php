<?php
#awards.php - CS467, Emmalee Jones, Yae Jin Oh 
#Create Awards 
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

        <!-- --------------------------------- Award Creation Form --------------------------------- -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3">
			</div>
			<div class="col-lg-6">
	<div id="award-body">
	    <form method="post" action="createAward.php" id="award-form"> <!-- post to page handling form-->    
                <fieldset>
                    <legend> Create an Award Certificate </legend>
                    <p>Name: 
                        <select name="name"> 
                            <?php
                            // creates option for origin
                            if(!($stmt = $mysqli->prepare("SELECT id, firstname, lastname, emailaddress FROM `Employees`"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }
                            if(!$stmt->execute()){
                                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                            }
                            if(!$stmt->bind_result($id, $firstname, $lastname, $emailaddress)){
                                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                            }
                            while($stmt->fetch()){
                                echo '<option value=" '. $id . ' "> ' . $firstname . ", " . $lastname . '</option>\n';
                            }
                            $stmt->close();
                            ?>
                        </select> </p>
                    <p>Award Type: 
                        <select name="awardType"> 
                            <?php
                            // creates option for origin
                            if(!($stmt = $mysqli->prepare("SELECT ctid, type FROM `CertType`"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }
                            if(!$stmt->execute()){
                                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                            }
                            if(!$stmt->bind_result($ctid, $type)){
                                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                            }
                            while($stmt->fetch()){
                                echo '<option value=" '. $ctid . ' "> ' . $type . '</option>\n';
                            }
                            $stmt->close();
                            ?>
                        </select>
                    </p>
                    <p>Region: 
                        <select name="region"> 
                            <?php
                            // creates option for origin
                            if(!($stmt = $mysqli->prepare("SELECT rid, sector FROM `Regions`"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }
                            if(!$stmt->execute()){
                                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                            }
                            if(!$stmt->bind_result($rid, $sector)){
                                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                            }
                            while($stmt->fetch()){
                                echo '<option value=" '. $rid . ' "> ' . $sector . '</option>\n';
                            }
                            $stmt->close();
                            ?>
                        </select>
                    </p>
                    <p>
                        <input type="submit" name="add" value="Create Award">
                        <input type="submit" name="view" value="View All Awards">
                    </p>
                </fieldset>
        </form>
	</div>
			</div>
		</div>
	</div>


            </br> 
            <a href="userMenu.php">User Menu</a>
            </br>
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
