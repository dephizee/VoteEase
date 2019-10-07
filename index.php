<?php 
    session_start();
    $logged_in = false;
    if( (isset($_SESSION['user_id']) && $_SESSION['logged_in'] == 'true') ){
        $logged_in = true;
    }
    

 ?>
<!DOCTYPE html>
<html>
<head>
    <title>NO NAME</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/icon.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body id="top" onscroll="scrollTerm(this)" style="margin: 0;" onload="replacePage()">
    <div class="col-12 nav-bar">
        <span class="col-2 header-menu-toggle">
            <i class="icono-hamburger" style="font-size: 12px; color: #ffdd00;"></i>
        </span>

        <div class="col-8 main-nav-wrap" id="main-nav-wrap">
            <ul class="main-navigation">
                <a href="#home"><li class="current">Home</li></a>
                <a href="#about"><li>About</li></a>
                <?php 
                    if($logged_in){
                        echo '<a href="./dashboard"><li>Dashboard</li></a>';
                    }else{
                        echo '<a href="#login"><li>Login</li></a>';
                    }
                 ?>
                
            </ul> 
            
        </div>
        <div class="col-2 download-app" style="float: right;border: 1px solid #146941;">
            <span> Download App</span>
        </div>
    </div>
    <div class="col-12 current section" id="home" >
        <div class=" col-offset-2 col-10 main-container">
            <div class="col-6" style="">
                <h5 style="word-spacing: 10px;">Welcome To VoteEase</h5>
                <h3  style="font-family: monospace; text-transform: none;">Here We Make Polls easier to Conduct</h3>
                
            </div>
            <div class="col-6" style=" padding: 0;">
                <div class="col-12">
                    <div class="col-12">
                        <form method="GET" action="poll_results">
                            <input type="text" name="s" placeholder="Access Code" class="col-12 main_search_field" >
                            <input type="submit" name="main_submit" value="Find Survey" class="col-7 col-offset-5 mbutton">
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 section" id="about">
        <div class=" col-offset-1 col-11 ">
            <div class="col-offset-6 col-6" style="text-align: center; font-family: monospace;">    
                <h1>ABOUT</h1>
            </div>
            <div class="col-11 col-offset-1" style="background-color: #00116040; border-radius: 15px; font-family: monospace;">
                <p>An online platform where researchers can create surveys and questionnaires. The platform allows people to take part in surveys from any part the world. The platform provides a dashboard that gives users live updates of any given survey. </p>
            </div>
            
        </div>
    </div>
    
    
    <div class="col-12 section" id="login" style="display: <?php echo  $logged_in? "none":"block"; ?>">
        <div class="">
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
                <input type="text" name="username" placeholder="Username" class="col-10 col-offset-2" style="   border-color: black;">
                <input type="password" name="password" placeholder="Password" class="col-10 col-offset-2" style="   border-color: black;">
                <input type="submit" name="login" class="col-10 col-offset-2 signin mbutton" value="SIGN IN" />
              </form>
            </div>
        </div>
        <div style="visibility: hidden; display: none;" id="signinpanel">
            <div class="col-6 col-offset-6 header">
                <h1>Sign Up</h1>
            </div>
            <div id="signup" class="col-6 col-offset-6 panel">
                <input type="text" name="reg_username" placeholder="Username" class="col-10 col-offset-2" style="   border-color: black;" id="reg_username" onkeyup="checkusernameinDB(this.value)"  onblur="checkusernameinDB(this.value)">
                <div id="username_status" class="col-6 col-offset-2" style="visibility: none; display: none;"></div>
                <input type="password" name="reg_password" placeholder="Password" class="col-10 col-offset-2" style="   border-color: black;" id="reg_password" onblur="checkpassword(this.value)">
                <div id="password_status" class="col-6 col-offset-2" style="visibility: none; display: none;"></div>
                <input type="password" name="reg_password_repeat" placeholder="Repeat Password" class="col-10 col-offset-2" style=" border-color: black;" id="reg_password_repeat" onblur="checkpasswordrepeat(this.value)">
                <div id="password_status_repeat" class="col-6 col-offset-2"  style="visibility: none; display: none;"></div>
                <input type="submit" name="register" class="col-10 col-offset-2 signin mbutton" onclick ="registertoDB()" id="register" value=" SIGN UP"/>

            </div>
        </div>
    </div>
    </div>
    <div class="col-12 section" style="position: relative; text-align: right; color: #4d60a5;">
        <i>hafiz227@gmail.com</i>
    </div>
</body>
</html>
<script type="text/javascript" src="./js/index.js?2"></script>
<script type="text/javascript" src="./reg.js"></script>
<script type="text/javascript">
    document.getElementById('signinbar').style.backgroundColor = "#ffdd00";


</script>
