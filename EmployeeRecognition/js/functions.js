//functions.js - CS290, Emmalee Jones, Assignment Final Project
//AJAX Functions For Editing
function login()
{ 
        var username=document.getElementById("username").value;
        var password=document.getElementById("password").value;
         
	var log_message = document.getElementById("login_message");
        var register_message = document.getElementById("register_message");
        var signed_message = document.getElementById("signed_message");
	var reqXML;
	
        /*Clear out messages*/
	log_message.innerHTML="";
        register_message.innerHTML="";
        signed_message.innerHTML="";
	
    if (username==="" || password===""){
       log_message.innerHTML="Either the username or password is missing, please try again.";
    return false;
    }
    var reqXML = new XMLHttpRequest();
        
    if(!reqXML){
        throw "Unable to create HttpRequest.";
    }

    reqXML.onreadystatechange = function (){
        if((this.readyState === 4) && (this.status === 200)) {

            var  response = this.responseText;
            response = response.trim();
            //alert ("Response text");
            //alert (response);
            if (response==="ok"){
                window.location.href="homepage.php"; 
            }
            else {
                log_message.innerHTML="Invalid userid or password, try again.";
                return false;
            }
        }
    } 
    
    /* Send Request*/
    var data = "&username="+username+"&password="+password+"&login=1";
    reqXML.open("POST","login.php");
    reqXML.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    reqXML.send(data);
   
} 

function editdata()
{ 
        var username=document.getElementById("usernamer").value;
        var password=document.getElementById("passwordr").value;
        var matchpassword=document.getElementById("matchpassword").value;
         
	var log_message = document.getElementById("login_message");
        var register_message = document.getElementById("register_message");
        var signed_message = document.getElementById("signed_message");
	var testXML;
	
        /*Clear out messages*/
	log_message.innerHTML="";
        register_message.innerHTML="";
        signed_message.innerHTML="";
        
    if (password !== matchpassword){
       register_message.innerHTML="Passwords do not match, please try again.";
    return false;
    }
    if (password.length < 8){
       register_message.innerHTML="Password must be as least 8 characters, please try again.";
    return false;
    }
    var testXML = new XMLHttpRequest();
        
    if(!testXML){
        throw "Unable to create HttpRequest.";
    }
    
     testXML.onreadystatechange = function (){
        if((this.readyState === 4) && (this.status === 200)) {

            var  testresponse = this.responseText;
            testresponse = testresponse.trim();
            //alert ("Response text");
            //alert (testresponse);
            if (testresponse=="ok"){
                //window.location.href="index.php";
                signed_message.innerHTML="You are now registered."; 
            }
            else {
                register_message.innerHTML="User name already used, please try again.";
                return false;
            }
        }
    }
    
    /* Send Request*/
    var table = "&username="+username+"&password="+password+"&login=1";
    testXML.open("POST","registered.php");
    testXML.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    testXML.send(table);
   
} 


