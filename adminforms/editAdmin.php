<?php
#editAdmin.php - CS467, Emmalee Jones, Yae Jin Oh 
#Edit/Delete Admin Users  
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

include "../phpmysql/connect.php";

#Delete one row of Admin User
function delRow($id, $mysqli) {
    if (!($mysqli->query("DELETE FROM admins WHERE id=\"{$id}\""))) {
        echo "Error: id Field Not Found on Delete: " . $mysqli->errno . " - " . $mysqli->error;
    }
}

//Check for changes to Post
if (!empty($_POST)) {
    
    #Test for deleting Admin User
    if (isset($_POST['delete'])) {
        $id = $_POST ['delete'];
        delRow($id, $mysqli);
      $signed_msg = "User is deleted.";  
    }
        
    #Test for editing Admin User
    if (isset($_POST['edit'])) {
        $id = $_POST ['edit'];
        $_SESSION["editid"] = $id;
        header("Location:editAdmin2.php");
    }
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
                    <!-- --------------------------------- Logout Form --------------------------------- -->
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
            <h1>Edit Admin</h1>
            </br>
            </br>
  <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'ON');
                
    #Build admin user list
    
    
    $tableList = "SELECT id, password, datetimestamp, emailaddress FROM admins order by id";

        if (!($stmt = $mysqli->prepare($tableList))) {
            echo "Error: Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }

            if (!$stmt->execute()) {
                echo "Error: Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
           }
                $tabid = NULL;
                $tabpassword = NULL;
                $tabdatetimestamp = NULL;
                $tabemailaddr = NULL;

                if (!$stmt->bind_result($tabid, $tabpassword, $tabdatetimestamp, $tabemailaddr)) {
                    echo "Error: Binding failed: (" . $stmt->errno . ") " 
                       . $stmt->error;
              }
 ?>
              
        <form action="editAdmin.php" method="POST" name="printForm">
            <br/>
                 <h3>Admin User List</h3>
            <table border="1">
                <tbody>
                    <tr>
                        <th>Admin User Id</th>
                        <th>Email Address</th>
                    </tr>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'ON');

// Populate the table rows with movie data.
while ($stmt->fetch()) {  
    printf("<tr>\n" . "\t<td>%s</td>\n" . "\t<td>%s</td>\n"  
                . "\t<td><button type=\"submit\" name=\"edit\"" 
        . " value=\"{$tabid}\">Edit</button></td>\n" 
         . "\t<td><button type=\"submit\" name=\"delete\"" 
        . " value=\"{$tabid}\">Delete</button></td>\n" 
        . "</tr>\n", $tabid, $tabemailaddr);
}
#Close fetch of $stmt
$stmt->close();

?> 
            
            
                            </tbody>
            </table>
        </form> 

            </br> 
             <a href="adminMenu.php">Admin Menu</a>
            </br>
                           <div class="col-sm-6" style="color:#FF0000"</div>

<?php
if (isset($signed_msg)) {
            echo $signed_msg . "<br/>";
}
?>  

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

