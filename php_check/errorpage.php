<?php 
session_start();

 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>error</title>
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
		    text-align: center;
    	}
    	.header{
    		text-align: center;
    		background-color: #146941;
    		border-radius: 5px 5px 0 0;
    		font-size: 2em;
    		color: white;
    	}
    	.error{
    		padding: 5%;
    		color: red;
    	}
    	.back{
    		text-align: center;
    		background-color: #146941;
    		color: #fff;
    		border-radius: 0 0 5px 5px;
    	}
    	.back:hover{
    		text-align: center;
    		cursor: pointer;
    		box-shadow: 0 0 2px black;
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
		}
    </style>
 </head>
 <body>
 <div class="row">
 	<div class="col-6 col-offset-6 header">
 		ERROR
 	</div>
 	<div class="col-6 col-offset-6 error">
 		<?php
		 if($_SESSION['error_message'] == "checked"){
			echo "Bad Access...";
		}
		echo $_SESSION['error_message'];
		$_SESSION['error_message'] = "checked";
		 ?>
 	</div>
 	<div class="col-6 col-offset-6 back" onclick="back()">
 		HOME
 	</div>

 </div>



 </body>
 </html>
 <script type="text/javascript">
 	function back() {
 		window.location="./../index.php";
 	}
 </script>
