<?php 
	session_start();
	// if(isset($_SESSION['user_id'])){
	// 	if($_SESSION['logged_in'] == 'true'){
	// 		header("location: ./..");
 //            die();
 //            exit();

	// 	}
	// }
    if(isset($_GET['main_submit'])){
        $main_access_code = ($_GET['main_access_code']);
        $main_access_code = "./../poll/?access_code=".$main_access_code;
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

		@media only screen and (max-width: 960px){
			[class*=col-], #recentpost{
    		width: 80%;
    		margin-left: 10%;
    		}
            .mainlogodiv{
                display: none;
                visibility: hidden;
            }
            #main_search{
                width: 100%;
                margin: 0;
            }
            .main_search_field{
                height: 80px;
            }
		}
    </style>
</head>
<body>
	<div id="main_body" style="transition: 2s;">
		<div class="row navbar">
			<div class="col-6">
				<div class="col-6" style="padding: 0px">
					<img src="./../images/logo.png" alt="VoteEase" class="logo">
				</div>
			</div>
			<div class="col-6">
				
			</div>
		</div>
		<div class="col-8 col-offset-4" id="main_search" style="margin-top: 5%; border-width: 0;">
            <div class="col-6 col-offset-6 mainlogodiv" style="text-align: center; border-width: 0;">
                <img src="./../images/logo.png" alt="VoteEase" class="mainlogo">
            </div>
            <div class="col-12" style="border-width: 0;">
				<form method="GET" action="./../poll">
                    <input type="text" name="access_code" placeholder="Access Code" class="col-12 main_search_field" >
                    <input type="submit" name="main_submit" value="Find Survey" class="col-7 col-offset-5 mbutton">
                </form>
            </div>
		</div>
		<div class="col-3 menus" id="recentpost" style="border-width: 0;">
            <div class="col-8  col-offset-4 header" style="color: white;">Recent Surveys</div>

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
        ajax.open("GET", "./recentpost.php", true);
        ajax.send(null);
    }
    loadrecentpost();
</script>
