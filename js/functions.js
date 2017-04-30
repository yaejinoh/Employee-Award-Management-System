//functions.js - CS467, Emmalee Jones, Yae Jin Oh Capstone  
//AJAX Functions For Editing
//index.php 
function userLogin()
{
    var username = document.getElementById("usernamer").value;
    var password = document.getElementById("passwordr").value;

    var login_message = document.getElementById("login_message");
    /*var register_message = document.getElementById("register_message");*/
    /*var signed_message = document.getElementById("signed_message");*/
    var reqXML;

    /*Clear out messages*/
    login_message.innerHTML = "";
    /*register_message.innerHTML="";*/
    /*signed_message.innerHTML="";*/

    if (username === "" || password === "") {
        login_message.innerHTML = "Either the username or password is missing, please try again.";
        return false;
    }
    var reqXML = new XMLHttpRequest();

    if (!reqXML) {
        throw "Unable to create HttpRequest.";
    }

    reqXML.onreadystatechange = function () {
        if ((this.readyState === 4) && (this.status === 200)) {

            var response = this.responseText;
            response = response.trim();
            //alert ("Response text");
            //alert (response);
            if (response === "ok") {

                window.location.href = "userforms/userMenu.php";
            }
            else {
                login_message.innerHTML = "Invalid username or password, try again.";
                return false;
            }
        }
    };

    /* Send Request*/
    var data = "&username=" + username + "&password=" + password + "&login=1";
    reqXML.open("POST", "userforms/userLogin.php");
    reqXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    reqXML.send(data);

}

//adminSignIn
function adminLogin()
{
    var adminname = document.getElementById("adminnamer").value;
    var password = document.getElementById("password2r").value;

    var admin_message = document.getElementById("admin_message");
    var req2XML;

    /*Clear out messages*/
    admin_message.innerHTML = "";

    if (adminname === "" || password === "") {
        admin_message.innerHTML = "Either the adminname or password is missing, please try again.";
        return false;
    }
    var req2XML = new XMLHttpRequest();

    if (!req2XML) {
        throw "Unable to create HttpRequest.";
    }

    req2XML.onreadystatechange = function () {
        if ((this.readyState === 4) && (this.status === 200)) {

            var response = this.responseText;
            response = response.trim();
            //alert ("Response text");
            //alert (response);
            if (response === "ok") {

                window.location.href = "adminMenu.php";
            }
            else {
                admin_message.innerHTML = "Invalid admin name or password, try again.";
                return false;
            }
        }
    };

    /* Send Request*/
    var admindata = "&adminname=" + adminname + "&password=" + password + "&login=1";
    req2XML.open("POST", "adminLogin.php");
    req2XML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req2XML.send(admindata);

}

//userRegist
function userEdit()
{
    var username = document.getElementById("username2r").value;
    var firstname = document.getElementById("firstnamer").value;
    var lastname = document.getElementById("lastnamer").value;
    var password = document.getElementById("password3r").value;
    var matchpassword = document.getElementById("confirmpassword3r").value;
    var signature = document.getElementById("signaturer").value;
  
   
    var error4_message = document.getElementById("error4_message");
    var error5_message = document.getElementById("error5_message");
    var error6_message = document.getElementById("error6_message");
    var userXML;

    /*Clear out messages*/
    error4_message.innerHTML = "";
    error5_message.innerHTML = "";
    error6_message.innerHTML = "";

    if (password !== matchpassword) {
        error5_message.innerHTML = "Passwords do not match, please try again.";
        return false;
    }
    if (password.length < 8) {
        error5_message.innerHTML = "Password must be as least 8 characters, please try again.";
        return false;
    }
    
    var userXML = new XMLHttpRequest();

    if (!userXML) {
        throw "Unable to create HttpRequest.";
    }

    userXML.onreadystatechange = function () {
        if ((this.readyState === 4) && (this.status === 200)) {

            var testresponse = this.responseText;
            testresponse = testresponse.trim();
            //alert ("Response text");
            //alert (testresponse);
            if (testresponse === "ok") {
                //window.location.href="index.php";
                error6_message.innerHTML = "User is registered.";
            }
            else if (testresponse === "Bademail") {
                error5_message.innerHTML = "Invalid email format, please try again.";
                return false;
            }
            else {
                error5_message.innerHTML = "User name already used, please try again.";
                return false;
            }
        }
    };

    /* Send Request*/
    var table = "&username=" + username + "&password=" + password + "&firstname=" + firstname + "&lastname=" + lastname + "&signature=" + signature + "&login=1";
    //var table = "&username=" + username + "&password=" + password + "&firstname=" + firstname + "&lastname=" + lastname + "&login=1";
    userXML.open("POST", "userregistration.php");
    userXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    userXML.send(table);

}
//adminRegist
function adminEdit()
{
    var username = document.getElementById("adminname2r").value;
    var password = document.getElementById("password4r").value;
    var matchpassword = document.getElementById("confirmpassword2r").value;

    var error1_message = document.getElementById("error1_message");
    var error2_message = document.getElementById("error2_message");
    var error3_message = document.getElementById("error3_message");
    var adminXML;

    /*Clear out messages*/
    error1_message.innerHTML = "";
    error2_message.innerHTML = "";
    error3_message.innerHTML = "";

    if (password !== matchpassword) {
        error1_message.innerHTML = "Passwords do not match, please try again.";
        return false;
    }
    if (password.length < 8) {
        error1_message.innerHTML = "Password must be as least 8 characters, please try again.";
        return false;
    }
    var adminXML = new XMLHttpRequest();

    if (!adminXML) {
        throw "Unable to create HttpRequest.";
    }

    adminXML.onreadystatechange = function () {
        if ((this.readyState === 4) && (this.status === 200)) {

            var testresponse = this.responseText;
            testresponse = testresponse.trim();
            //alert ("Response text");
            //alert (testresponse);
            if (testresponse === "ok") {
                //window.location.href="index.php";
                error3_message.innerHTML = "User is registered.";
            }
            else if (testresponse === "Bademail") {
                error2_message.innerHTML = "Invalid email format, please try again.";
                return false;
            }
            else {
                error1_message.innerHTML = "User name already used, please try again.";
                return false;
            }
        }
    };

    /* Send Request*/
    var table = "&username=" + username + "&password=" + password + "&login=1";
    adminXML.open("POST", "adminregistration.php");
    adminXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    adminXML.send(table);

}

//userRegist display image
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#signaturerb')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(120);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

function encodeImageFileAsURL(element) {
  var file = element.files[0];
  var reader = new FileReader();
  reader.onloadend = function() {
    console.log('RESULT', reader.result);
  };
  reader.readAsDataURL(file);
}
