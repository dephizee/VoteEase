<?php 
session_start();
if(isset($_SESSION['user_id'])){
        if($_SESSION['logged_in'] != 'true'){
            header("location: index.php");
        }
    }else{
        header("location: index.php");
    }
 ?>
<!doctype html>
<html lang="eng">
    <head>
        <title>About Vote ease.</title>
        <link rel="stylesheet" href="main.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</style>
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
        .logo{
            width: 30%;
            height: auto;
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
        <div class="col-8 col-offset-4" >
            <div class="row navbar">
                <div class="col-6">
                    <div class="col-6" style="padding: 0px">
                        <a href="./index.php"><img src="images/logo.png" alt="VoteEase" class="logo"></a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="col-4 col-offset-12 find"  style=" background-color: white; color: black;">
                            <?php
                                echo $_SESSION['user_name'];
                             ?>
                    </div>
                </div>
            </div>
            <div id="new_div">
                <section id="main_section" style="color: black; background-color: rgba(255, 255, 255, 0.7); padding: 5%;">
                <header>
                    <hgroup>
                        <h1>About Vote Ease</h1>
                    </hgroup>
                </header>
                    <p >Vote ease is an automated voting system that is aimed at providing services to conduct voting, surveys, audience response and data collection.
                    </p>
                </section>
                </div>
            </div>
</body>
</html>
