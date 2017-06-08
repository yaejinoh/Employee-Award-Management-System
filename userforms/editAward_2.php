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
                    <!-- --------------------------------- Logout Form --------------------------------- -->
                    <form class="navbar-form pull-right" method="POST" action="userLogout.php">
                        <input type="submit" value = "Sign out" name="logout form)"> 
                    </form>
		    <!-- --------------------------------- Account Form --------------------------------- -->
		    <form class="navbar-brand pull-right">
                         <a> <?php echo "Employee Name:" . " " . $_SESSION['employeeFirstName']. " " . $_SESSION['employeeLastName'] ; ?> </a>
			    </br><a href="userMod.php"><font size="3">Edit Profile</font></a>
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
            <h1>Edit Award</h1>
            </br>
            </br>
	</div>



        <!-- --------------------------------- Awards table view --------------------------------- -->
            <table class="awards-table">
	      <div class="table-title" align='center'><h4>Awards:</h4></div>
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
			  <td> </td>
			  <td> </td>
			  <td> </td>
			  <td> </td>
			  <td> </td>
			  <td> </td>
                      </tr>
                      
                      <?php
		      // Retrieve employee ID number of session user
		      $eid = $_SESSION['employeeid'];
     
		      /* ---------- If the user submits the --EDIT-- form ---------- */
		      if(isset($_POST["edit-award"])){
			if(!($stmt = $mysqli->prepare(
				"UPDATE `Awards` SET date=?, time=?, awardee=?, region=?, type=? WHERE id=?;"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			
			/*
			$date = $_POST['date'];
			$time = $_POST['time'];
			$name = $_POST['name'];
			$awardType = $_POST['awardType'];
			$region = $_POST['region'];
			$awardID = $_POST['awardID'];
			echo "date: " . $date . "          time: " . $time . "          name: " . $name . "          awardType: " . $awardType . "          region: " . $region . "          awardID: " . $awardID . "</br>";
			*/
			      
			if(!($stmt->bind_param("ssiiii", $_POST['date'], $_POST['time'], $_POST['name'], $_POST['region'], $_POST['awardType'], $_POST['awardID']))){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			      
			if(!$stmt->execute()){
				echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
			} else{
				// Feedback to the user
				echo "<div align='center' style='font:15px; color:#ff0000; font-weight:bold'> Updated " . $stmt->affected_rows . " row to awards table.</div>";
				echo "<div align='center' style='font:15px; color:#ff0000; font-weight:bold'>Award has been edited.</div>";  
			}
			$stmt->close();
			      
                        if(!($stmt = $mysqli->prepare( 
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
			WHERE PE.id = '$eid'
			ORDER BY A.date, A.time;"))){
                          echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                        }         
                        if(!$stmt->execute()){
                          echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
			if(!$stmt->bind_result($id, $date, $time, $PresenterFirstName, $PresenterLastName, $AwardeeFirstName, $AwardeeLastName, $CertificateType, $Region, $Signature)){
                          echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while($stmt->fetch()){
                          echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $date . "\n</td>\n<td>\n" . $time . "\n</td>\n<td>\n" . $PresenterFirstName . "\n</td>\n<td>\n" . $PresenterLastName  . "\n</td>\n<td>\n" . $AwardeeFirstName  . "\n</td>\n<td>\n" . $AwardeeLastName . "\n</td>\n<td>\n" . $CertificateType . "\n</td>\n<td>\n" . $Region . "\n</td>\n<td>\n";
			  echo '<img src="data:image/png;base64,'.base64_encode($Signature).'">';
			  echo "\n</td>\n<td>\n";
			/*-- --------------------------------- Award PDF Creation Form --------------------------------- */
			  echo	'<td class="award-pdf">
					<form action=\'createAwardPDF.php\' method="post">
						<input type="hidden" name="awardID" value="' . $id . '">
						<input type="submit" name="export" value="Export as PDF">
					</form>
				</td>';
			  echo "\n</td>\n<td>\n";
			/*-- --------------------------------- Award PDF and Send Form --------------------------------- */
			  echo	'<td class="award-pdf-mail">
					<form action=\'createAwardPDFmail.php\' method="post">
						<input type="hidden" name="awardID" value="' . $id . '">
						<input type="submit" name="export-mail" value="Send to Recipient">
					</form>
				</td>';
			  echo "\n</td>\n<td>\n";
			/*-- --------------------------------- Award Edit Form --------------------------------- */
			  echo	'<td class="award-pdf-mail">
					<form action=\'editAward.php\' method="post">
						<input type="hidden" name="awardID" value="' . $id . '">
						<input type="submit" name="edit" value="Edit">
					</form>
				</td>';
			  echo "\n</td>\n<td>\n";
			/*-- --------------------------------- Award Delete Form --------------------------------- */
			  echo	'<td class="award-delete">
					<form action=\'delAwards.php\' method="post">
						<input type="hidden" name="awardID" value="' . $id . '">
						<input type="submit" name="delete" value="Delete">
					</form>
				</td>';
			  echo "\n</td>\n</tr>";
	                }
                        $stmt->close();
                      }
		      
		      
		      
		      
		      
                      ?>						
              </tbody>
            </table>
	</div>
	<br>

        <!-- --------------------------------- Delete All Awards --------------------------------- -->
	<div class="container">
	<div class="container-fluid">
	<div class="row">
	<div class="col-lg-11">
	</div>
	<div class="col-s-1">
	    <form method="post" action="delAwards.php" id="del-form"> <!-- post to page handling form-->    
                <fieldset>
                    <p>
			<input type="submit" name="deleteall" value="Delete All">
                    </p>
                </fieldset>
            </form>
		
	<!-- --------------------------------- Create Award --------------------------------- -->
	<div class="container">
	<div class="container-fluid">
	<div class="row">
	<div class="col-lg-11">
	</div>
	<div class="col-s-1">
	    <form method="post" action="awards.php"> <!-- post to page handling form-->    
                <fieldset>
                    <p>
			<input type="submit" name="create" value="Create an Award">
                    </p>
                </fieldset>
            </form>
	</div>
	</div>
	</div>
	</div>
        <br>
        <br>




            </br> 
            <div align='center'><a href="userMenu.php">Return to Main Page</a></div>
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
 
