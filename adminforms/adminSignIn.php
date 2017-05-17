<?php
#adminMenu.php - CS467, Emmalee Jones, Yae Jin Oh 
#Admin Menu  
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
                    <h1><a class="navbar-brand " href="../index.php"> Employee Recognition Awards</a></h1>                   
                </nav>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            </div>
        </div>


        <!-- --------------------------------- Admin Sign In Form --------------------------------- -->
        <div class="container" >
            <div class="row">
                <div class="col-sm-8" >   
            <h1>Admin Sign In</h1>
            <form method="POST" onsubmit="adminLogin(); return false;">
                <span class="glyphicon glyphicon-user"></span>
                <label for="adminname" class="control-label">Admin Name</label>
                <input name="adminname" type="text" class="form-control" id="adminnamer" placeholder="Admin Name(Email Address)" required>
                <span class="glyphicon glyphicon-lock"></span>
                <label for="password" class="control-label">Password</label>
                <input name="password" type="password" class="form-control" id="password2r" placeholder="Password" required>
                </br>
                <button type="submit" name="adminsignin" class="btn btn-sm btn-primary ">Submit</button> 
            </form> 
            </br>
            <a href="../index.php">User Sign In</a>
            </br>

        </div>
          </div>
            </div>
        <div class="container">
            <div class="row">   
                <div class="col-sm-4" style="color:#FF0000" id="admin_message"></div>
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

    </body>
</html>