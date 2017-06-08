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
                        <input type="submit" name="view" value="Refresh the Page">
                    </p>
                </fieldset>
            </form>
			</div>
		</div>
	</br>
	</br>
        </br>
        </br>
	</div>
        </br>
        </br>
	</div>
	</div> <!-- extra div -->

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
		      
                      /* ---------- If the user pressed the --VIEW-- button ---------- */
		      // Display all the awards that exist made by session user     
                      if(isset($_POST["view"])){
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
		      
		      
		      /* ---------- If the user pressed the --CREATE AWARD-- button ---------- */
                      if(isset($_POST["add"])){
			// Query to store signature in session employee's account
			if(! ($stmt = $mysqli->prepare( 
                        "SELECT signature FROM Employees WHERE id = '$eid';"))){
                          echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                        }         
                        if(!$stmt->execute()){
                          echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
			// Save signature image as $signature 
			if(!$stmt->bind_result($signature)){
                          echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }   
			while($stmt->fetch()){
	                }
			      
	                // Grab date and time in UTC, will be automatically entered when creating an award
			$cur_date = date("y-m-d");
			$cur_time = date("h:i:s");

			// Create a row in Awards with the information from the form
			if(!($stmt = $mysqli->prepare("INSERT INTO `Awards`(name, date, time, awardee, region, type, signature) VALUES (?,?,?,?,?,?,?)"))){
			  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!($stmt->bind_param("issiiis",$eid,$cur_date,$cur_time,$_POST['name'],$_POST['region'],$_POST['awardType'],$signature))){
			  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
                          echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
			// Feedback to the user
			echo "<div align='center' style='font:15px; color:#ff0000; font-weight:bold'>Award has been created.</div>";  
			      
			// Display all the awards that exist made by session user     
                        if(! ($stmt = $mysqli->prepare( 
                        "SELECT	A.id, A.date AS date, A.time AS time,
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
	</div>
	</div>
	</div>
	</div>
        <br>
        <br>




            </br> 
            <a href="userMenu.php">Return to Main Page</a>
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
