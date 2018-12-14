<?php
session_start();
if(isset($_SESSION['logged_in'])){
	if($_SESSION['logged_in'] == 'true'){
		header("location: dashboard.php");
	}
}


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style type="text/css">
	    *{
	    	box-sizing: border-box;
	    }
	    .row::after{
	    	content: "";
		    clear: both;
		    display: block;
	    }
    	[class*=col-]{
    		float: left;
		    padding: 15px;
		    border: 1px solid #146941;
    	}
    	.signin:active{
    		cursor: pointer;
    		border-width: 1px;
    		box-shadow: 0 0 2px #146941,0 0 2px magenta;
    	}
    	.navbar{
            text-align: center;
            background-color: #146941;
            box-shadow:0 0 5px #146941;
            margin-bottom: 0.5%;
        }
        .logo{
            width: 30%;
            height: auto;
        }
    	body{
    		color: black;
    		/*background-image: url("images/1.jpeg");
    		background-repeat: no-repeat;
    		background-size: cover;*/
    		background-color: rgba(30, 0, 30, 0.5);
    	}
    	input{
    		height: 40px;
    		border-style: solid;
    		border-width: 1px;
    		border-color: black;
    		text-align: center;
    		width: 80%;
    		margin: 5px;
    		color: white;
    		transition: 2s;
    		color: black;

    	}
    	.panel{
    		border-radius: 0 0 5px 5px;
    		background-color: rgba(255, 255, 255, 0.6);
    	}
    	.header{
    		text-align: center;
    		background-color: #146941;
    		color: #fff;
    	}
    	.nav{
    		text-align: center;
    		background-color: #146941;
    		border-radius: 10px 10px 0 0;
    	}
    	.bar{
    		color: black;
    		transition: 2s;
    		background-color: white;
    	}
    	.bar:hover{
    		cursor: pointer;
    		box-shadow: 0 0 6px black;
    	}
			.tip{
				position: absolute;
				border-color: white;
				color: white;
				box-shadow: 0 0 20px white;
				margin-top: 20px;
			}
			.tip_close{
				position: absolute;
				right: 5px;
				top: 5px;
				color: red;
			}

    	.bar:active{
    		background-color: rgb(0, 255, 0);
    		cursor: pointer;
    		box-shadow: 0 0 0px black;

    	}
    	.signinbar{
			border-color: black;
		}
		.signupbar{
			border-color: black;
		}
    	input:focus{
    		border-color: #146941;
    		box-shadow:0 0 5px #146941;
    		background-color: #146941;
    		color: white;
    	}
    	.mbutton{
    		background-color: #146941;
    		color: white;
    	}
    	.mbutton:hover{
    		cursor: pointer;
    		box-shadow:0 0 5px #146941;

    	}
    	.col-1 {width: 8.33%;}
		.col-2 {width: 16.66%;}
		.col-3 {width: 25%;}
		.col-4 {width: 33.33%;}
		.col-5 {width: 41.66%;}
		.col-6 {width: 50%;}
		.col-7 {width: 58.33%;}
		.col-8 {width: 66.66%;}
		.col-9 {width: 75%;}
		.col-10 {width: 83.33%;}
		.col-11 {width: 91.66%;}
		.col-12 {width: 100%;}

		.col-offset-1 {margin-left: 4.16%;}
		.col-offset-2 {margin-left: 8.33%;}
		.col-offset-3 {margin-left: 12.5%;}
		.col-offset-4 {margin-left: 16.66%;}
		.col-offset-5 {margin-left: 20.83%;}
		.col-offset-6 {margin-left: 25%;}
		.col-offset-7 {margin-left: 29.16%;}
		.col-offset-8 {margin-left: 33.33%;}
		.col-offset-9 {margin-left: 37.5%;}
		.col-offset-10 {margin-left: 41.66%;}
		.col-offset-11 {margin-left: 45.5%;}
		.col-offset-12 {margin-left: 50%;}

		@media only screen and (max-width: 768px){
			[class*=col-]{
    		width: 80%;
    		margin-left: 10%;
    		}
    		.signin{
    			width: 80%;
    			margin-left: 10%;
    			border:1;
    		}
    		.signinbar{
    			width: 50%;
    			float: left;
    			margin-left: 0;
    		}
    		.signupbar{
    			width: 50%;
    			float: left;
    			margin-left: 0;
    		}
		}
    </style>
  </head>
  <?php
  		include ("./conn.php");
  		if(isset($_POST['register'])){
  			$username = mysqli_real_escape_string($conn, $_POST["reg_username"]);
  			$password = mysqli_real_escape_string($conn, $_POST["reg_password"]);
  			$password_repeat = mysqli_real_escape_string($conn, $_POST["reg_password_repeat"]);
  			$hash_password = password_hash($password, PASSWORD_BCRYPT);
  			echo $username."<br>";
  			echo $password."<br>";
  			echo $password_repeat."<br>";
  			echo $hash_password."<br>";
  		}
   ?>
  <body>
		<div id="tip" class="col-8 col-offset-4 tip">Vote ease is an automated voting system that is aimed at providing services to conduct voting, surveys, audience response and data collection.
			<span class="tip_close" onclick="close_tip()" id="tip_close">close</span>
		</div>
  <div class="row navbar">
            <div class="col-6">
                <div class="col-6" style="padding: 0px">
                    <a href="./index.php"><img src="images/logo.png" alt="VoteEase" class="logo"></a>
                </div>
            </div>
        </div>
<div class="row">
		<div class="col-6 col-offset-6 nav" >
			<div class="col-6 signinbar bar" onclick="signin()" id="signinbar">
				Sign In
			</div>
			<div class="col-6 signupbar bar"  onclick="signup()" id="signupbar">
				Sign Up
			</div>
		</div>
		<div style="visibility: visible;" id="signuppanel">
			<div  class="col-6 col-offset-6 header">
				<h1>Sign In</h1>
			</div>
		    <div id="signin" class="col-6 col-offset-6 panel">
		      <form method="post" action="./php_check/login.php">
		      	<input type="text" name="username" placeholder="Username" class="col-10 col-offset-2" style="	border-color: black;">
		      	<input type="password" name="password" placeholder="Password" class="col-10 col-offset-2" style="	border-color: black;">
		      	<input type="submit" name="login" class="col-10 col-offset-2 signin mbutton" value="SIGN IN" />
		      </form>
		    </div>
		</div>
		<div style="visibility: hidden; display: none;" id="signinpanel">
			<div class="col-6 col-offset-6 header">
				<h1>Sign Up</h1>
			</div>
		    <div id="signup" class="col-6 col-offset-6 panel">
		      	<input type="text" name="reg_username" placeholder="Username" class="col-10 col-offset-2" style="	border-color: black;" id="reg_username" onkeyup="checkusernameinDB(this.value)"  onblur="checkusernameinDB(this.value)">
		      	<div id="username_status" class="col-6 col-offset-2" style="visibility: none; display: none;"></div>
		      	<input type="password" name="reg_password" placeholder="Password" class="col-10 col-offset-2" style="	border-color: black;" id="reg_password" onblur="checkpassword(this.value)">
		      	<div id="password_status" class="col-6 col-offset-2" style="visibility: none; display: none;"></div>
		      	<input type="password" name="reg_password_repeat" placeholder="Repeat Password" class="col-10 col-offset-2" style="	border-color: black;" id="reg_password_repeat" onblur="checkpasswordrepeat(this.value)">
		      	<div id="password_status_repeat" class="col-6 col-offset-2"  style="visibility: none; display: none;"></div>
		      	<input type="submit" name="register" class="col-10 col-offset-2 signin mbutton" onclick ="registertoDB()" id="register" value="	SIGN UP"/>

		    </div>
		</div>
	</div>
  </body>
</html>
<script type="text/javascript">
	function signin() {
		var signin = document.getElementById('signinpanel');
		var signup = document.getElementById('signuppanel');
		if(signin.style.visibility != "visible"){
			//
		}else{
			signin.style.visibility = "hidden";
			signin.style.display = "none";
			signup.style.visibility = "visible";
			signup.style.display = "block";
			document.getElementById('signinbar').style.backgroundColor = "#99ff99";
			document.getElementById('signupbar').style.backgroundColor = "";
		}


	}
	function signup() {
		var signin = document.getElementById('signinpanel');
		var signup = document.getElementById('signuppanel');
		if(signup.style.visibility != "visible"){
			//
		}else{
			signup.style.visibility = "hidden";
			signup.style.display = "none";
			signin.style.visibility = "visible";
			signin.style.display = "block";
			document.getElementById('signupbar').style.backgroundColor = "#99ff99";
			document.getElementById('signinbar').style.backgroundColor = "";
		}

	}
	var reg_username = document.getElementById('reg_username');
	var reg_password = document.getElementById('reg_password');
	var reg_password_repeat = document.getElementById('reg_password_repeat');
	var username_status = document.getElementById('username_status');
	var password_status = document.getElementById('password_status');
	var register = document.getElementById('register');
	var orguser = "";
	var orgpass = "";
	var usernamecheck = false;
	var passwordlengthcheck = false;
	var passwordcorresponds = false;
	document.getElementById('signinbar').style.backgroundColor = "#99ff99";
	function checkpassword(v){
		orgpass = v;
		if(v.length < 8){
			password_status.style.visibility = "visible";
			password_status.style.display = "block";
			password_status.innerHTML = "Password must be atleast 8";
			passwordlengthcheck = false;
		}else{
			password_status.style.visibility = "hidden";
			password_status.style.display = "none";
			password_status.innerHTML = "";
			passwordlengthcheck = true;
		}
	};
	function checkpasswordrepeat(v){
		if(orgpass != v){
			password_status_repeat.style.visibility = "visible";
			password_status_repeat.style.display = "block";
			password_status_repeat.innerHTML = "Password doesnt correspond";
			passwordcorresponds =false;
		}else{
			password_status_repeat.style.visibility = "hidden";
			password_status_repeat.style.display = "none";
			password_status_repeat.innerHTML = "";
			passwordcorresponds = true;
		}
		if(usernamecheck && passwordlengthcheck && passwordcorresponds){
			//alert("good to go");
		}else{
			//alert("not good to go");

		}
	}
	function checkusernameinDB(str){
		orguser = str;
    	var ajax;
    	try{
    		ajax = new XMLHttpRequest();
         	console.log("working");
    	}catch(e){
    		alert("Only Standardized used");
    	}
    	ajax.onreadystatechange = function(){
    		if(ajax.readyState == 4){
          		console.log(ajax.responseText);
          		if(ajax.responseText == 0){
          			console.log("good");
          			usernamecheck = true;
          			username_status.style.visibility = "hidden";
					username_status.style.display = "none";
          			username_status.innerHTML = "";
          		}else{
          			console.log("badd");
          			usernamecheck = false;
          			username_status.style.visibility = "visible";
					username_status.style.display = "block";
          			username_status.innerHTML = "Username name taken";
          		}
    		}
    	}
    	ajax.open("GET", "php_check/checkusername.php?user="+str, true);
    	ajax.send(null);
    }
    function registertoDB(str){
    	var ajax;
    	if(usernamecheck && passwordlengthcheck && passwordcorresponds){
    		//alert(orguser+" : "+orgpass);
    		try{
	    		ajax = new XMLHttpRequest();
	         	console.log("working");
	    	}catch(e){
	    		alert("Only Standardized used");
	    	}
	    	ajax.onreadystatechange = function(){
	    		if(ajax.readyState == 4){
	          		if(ajax.responseText == "successful"){
	          			var signup = document.getElementById('signup');
	          			signup.innerHTML = "<div>Registration Successful</div>";
	          		}else
	          		if(ajax.responseText == "failed"){
	          			alert("An error occurred");
	          		}
	    		}
	    	}
	    	ajax.open("GET", "php_check/registeruser.php?user="+orguser+"&password="+orgpass, true);
	    	ajax.send(null);
	    }else{
	    	alert("Fill fields correctly");
	    }
    }
		function close_tip(){
			document.getElementById("tip").style.display = 'none';
			console.log(">>>>");
		}

</script>
