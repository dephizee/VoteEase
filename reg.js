
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
          		// console.log(ajax.responseText);
          		if(ajax.responseText == 0){
          			// console.log("good");
          			usernamecheck = true;
          			username_status.style.visibility = "hidden";
					username_status.style.display = "none";
          			username_status.innerHTML = "";
          		}else{
          			// console.log("badd");
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
	          			var link = "php_check/login.php?username="+orguser+"&password="+orgpass
	          			signup.innerHTML = "<a href="+link+"><div>Registration Successful<br>Click here To continue</div></a>";
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
			document.getElementById('signinbar').style.backgroundColor = "#ffdd00";
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
			document.getElementById('signupbar').style.backgroundColor = "#ffdd00";
			document.getElementById('signinbar').style.backgroundColor = "";
		}


	}
