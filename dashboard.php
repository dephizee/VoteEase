<?php 
	session_start();
	if(isset($_SESSION['user_id'])){
		if($_SESSION['logged_in'] != 'true'){
			header("location: index.php");
		}
	}else{
        header("location: index.php");
    }
    if(isset($_POST['main_submit'])){
        require('./conn.php');
        $main_access_code = mysqli_real_escape_string($conn, $_POST['main_access_code']);
        $main_access_code = "./voteplace_multiple.php?access_code=".$main_access_code;
        header("location: $main_access_code");
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		    padding: 10px;
		    border: 1px solid #146941;
    	}
    	.header{
    		text-align: center;
    		background-color: #146941;
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
        .navbar{
            text-align: center;
            background-color: #146941;
            box-shadow:0 0 5px #146941;
        }
        body{
            color: black;
            /*background-image: url("images/2.jpeg");
            background-repeat: no-repeat;
            background-size: cover;*/
            background-color: rgba(30, 0, 30, 0.5);
        }
    	input:focus{
    		border-color: #146941;
    		box-shadow:0 0 5px #146941;
    		background-color: #146941;
    		color: white;
    	}
    	.survey{
    		z-index: 1;
    		position: fixed;
    		background-image: url("images/4.jpg");
    		box-shadow:0 0 50px #146941;
    		top: 12.5%;
    		visibility: hidden;
    		display: none;
    		transition: 2s;
    	}
        .logo{
            width: 30%;
            height: auto;
        }
        .mainlogo{
            width: 35%;
            height: auto;
        }
    	.close{
    		position: absolute;
    		top: 5%;
    		right: 3%;
            color: red;
    	}
    	.close:hover{
    		cursor: pointer;
    		box-shadow:0 0 5px #fff;

    	}
    	.find{
    		padding: 8px;
    	}
    	.mbutton{
    		background-color: #146941;
    		color: white;
    	}
    	.mbutton:hover{
    		cursor: pointer;
    		box-shadow:0 0 5px #146941;

    	}
    	.menus ul{
    		padding: 0px;
    		}
    	.menus li{
    		margin-left: 0;
    		padding: 5px 15px;
    		border: 1px solid #146941;
    		text-decoration: none;
    		list-style-type: none;
    		background-color: #146941;
    		color: white;
    		text-decoration: none;
    	}
    	.menus a{
    		text-decoration: none;
    		color: white;
    	}
    	.menus li:hover{
    		cursor: pointer;
    		box-shadow:0 0 5px #146941;
    		border: 1px solid white;

    	}
    	.nav{
    		text-align: center;
    		background-color: #146941;
    		border-radius: 10px 10px 0 0;
    		border-color: black;
    	}
        .mv{
            position: absolute;
            top:60%;
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
            .mv{
                position: relative;
                top:0;
            }
            .mainlogodiv{
                display: none;
                visibility: hidden;
            }
		}
    </style>
</head>
<body>
	<div id="create_survey" class="col-11 col-offset-1 survey" >
	<span class="close" onclick="closeSurvey()">X</span>
		<div  class="col-10 col-offset-2 header">
			<h1>Create Survey</h1>
		</div>
	    <div id="signin" class="col-10 col-offset-2 panel">
	      <form method="post" action="./php_check/registersurvey.php">
            <input type="text" name="survey_name" placeholder="Survey Name" class="col-10 col-offset-2" style=" border-color: black;">
	      	<input type="text" name="accesscode" placeholder="Preferred Access Code" class="col-10 col-offset-2" style="	border-color: black;">
	      	<input type="submit" name="login" class="col-10 col-offset-2 signin mbutton" value="SIGN IN" />
	      </form>
	    </div>
	</div>

	<div id="main_body" style="transition: 2s;">
		<div class="row navbar">
			<div class="col-6">
				<div class="col-6" style="padding: 0px">
					<img src="images/logo.png" alt="VoteEase" class="logo">
				</div>
			</div>
			<div class="col-6">
				<div class="col-4 col-offset-12 find"  style=" background-color: white; ">
						<?php
							echo $_SESSION['user_name'];
						 ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3 menus ">
			<ul>
				<li>Home</li>
				<li onclick="createSurveyPanel()">Create Survey</li>
				<a href="about.php"><li>About Us</li></a>
				<a href="./php_check/logout.php"><li>Log out</li></a>
			</ul>
			</div>
			<div class="col-6" style="margin-top: 5%; border-width: 0;">
                <div class="col-12 mainlogodiv" style="text-align: center; border-width: 0;">
                    <img src="images/logo.png" alt="VoteEase" class="mainlogo">
                </div>
                <div class="col-12" style="border-width: 0;">
    				<form method="post" action="">
                        <input type="text" name="main_access_code" placeholder="Access Code" class="col-12">
                        <input type="submit" name="main_submit" value="Find Survey" class="col-7 col-offset-5 mbutton">
                    </form>
                </div>
			</div>
			<div class="col-3 menus" id="recentpost" style="border-width: 0;">
                <div class="col-8  col-offset-4 header" style="color: white;">Recent Surveys</div>

            </div>
            <div class="col-3 menus mv" id="myvotes" style="border-width: 0;" >
                <div class="col-8  col-offset-4 header" style="color: white;">Recent Activities</div>

            </div>

		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	function loadrecentpost(){
        var ajax;
        try{
            ajax = new XMLHttpRequest();
            console.log("working");
        }catch(e){
            alert("Only Standardized used");
        }
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
                var temp = document.getElementById('recentpost');
                var tempdiv = "<div class='col-12' >";
                tempdiv += ajax.responseText;
                tempdiv += "</div>";
                temp.innerHTML  += tempdiv;
            }
        }
        ajax.open("GET", "php_check/recentpost.php", true);
        ajax.send(null);
    }
    function loadmyvote(){
        var ajax;
        try{
            ajax = new XMLHttpRequest();
            console.log("working");
        }catch(e){
            alert("Only Standardized used");
        }
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
                var temp = document.getElementById('myvotes');
                var tempdiv = "<div class='col-12' >";
                tempdiv += ajax.responseText;
                tempdiv += "</div>";
                temp.innerHTML  += tempdiv;
            }
        }
        ajax.open("GET", "php_check/recentvote.php", true);
        ajax.send(null);
    }
    function createSurveyPanel(){
    	var temp = document.getElementById('main_body');
    	var create_survey = document.getElementById('create_survey');
    	create_survey.style.visibility = 'visible';
    	create_survey.style.display = 'block';
    	temp.style.visible = 'hidden';
    	temp.style.display = 'none';
    }
    function closeSurvey(){
    	var temp = document.getElementById('main_body');
    	var create_survey = document.getElementById('create_survey');
    	create_survey.style.visibility = 'hidden';
    	create_survey.style.display = 'none';
    	temp.style.visible = 'visible';
    	temp.style.display = 'block';
    }
    loadrecentpost();
    loadmyvote();
</script>
