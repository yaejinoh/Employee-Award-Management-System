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
            <table>
              <h4>Awards:</h4>
              <tbody>
                      <tr>
                          <td>
                          ID
                          </td>
                          <td>
                              Date
                          </td>
                          <td>
                              Time
                          </td>
                          <td>
                              Presenter First Name
                          </td>
                          <td>
                              Presenter Last Name
                          </td>
                          <td>
                              Awardee First Name
                          </td>
                          <td>
                              Awardee Last Name
                          </td>
                          <td>
                              Certificate Type
                          </td>
                          <td>
                              Region
                          </td>
			  <td>
                              Signature
                          </td>
                      </tr>
                      
                      <?php
		      $eid = $_SESSION['employeeid'];
		      
                      // shows all award attributes with view button
                      if(isset($_POST["view"])){
                        if(! ($stmt = $mysqli->prepare( //SIMPLER TEST QUERY "SELECT id, name, date, time, awardee, region, type FROM `Awards`"))){
                        "SELECT	A.id, A.date, A.time,
                            PE.firstname AS PresenterFirstName, 
                            PE.lastname AS PresenterLastName,  
                            AE.firstname AS AwardeeFirstName, 
                            AE.lastname AS AwardeeLastName,
                            CT.type AS CertificateType,
                            R.sector AS Region,
			    HEX(A.signature) AS Signature
                        FROM Awards A
                        JOIN Employees PE ON PE.id=A.name
                        JOIN Employees AE ON AE.id=A.awardee
                        JOIN CertType CT ON CT.ctid=A.type
                        JOIN Regions R ON R.rid=A.region
			WHERE PE.id = '$eid'
			ORDER BY A.date, A.time;"))){
                          echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->execute()){
                          echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
/* SIMPLER TEST QUERY BIND/FETCH
			if(!$stmt->bind_result($id, $name, $date, $time, $awardee, $region, $type)){
                          echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while($stmt->fetch()){
                          echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $name . "\n</td>\n<td>\n" . $date . "\n</td>\n<td>\n" . $time . "\n</td>\n<td>\n" . $awardee . "\n</td>\n<td>\n" . $region . "\n</td>\n<td>\n" . $type . "\n</td>\n</tr>";
	                }*/
			if(!$stmt->bind_result($id, $date, $time, $PresenterFirstName, $PresenterLastName, $AwardeeFirstName, $AwardeeLastName, $CertificateType, $Region, $Signature)){
                          echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while($stmt->fetch()){
                          echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $date . "\n</td>\n<td>\n" . $time . "\n</td>\n<td>\n" . $PresenterFirstName . "\n</td>\n<td>\n" . $PresenterLastName  . "\n</td>\n<td>\n" . $AwardeeFirstName  . "\n</td>\n<td>\n" . $AwardeeLastName . "\n</td>\n<td>\n" . $CertificateType . "\n</td>\n<td>\n" . $Region . "\n</td>\n<td>\n" . $Signature . "\n</td>\n</tr>";
	                }
                        $stmt->close();
                      }
                      ?>						
              </tbody>
            </table>
            <br>
            <br>



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
