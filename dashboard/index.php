<?php 
	session_start();
	if(isset($_SESSION['user_id'])){
		if($_SESSION['logged_in'] != 'true'){
			header("location: ./../index.php");
		}
	}else{
        header("location: ./../index.php#login");
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/main.css">
    <link rel="stylesheet" href="./../css/icon.min.css">
    <link rel="stylesheet" href="./dashboard.css">
</head>
<body>
	<div class="col-6 col-offset-6 note-pane">
      Errr
    </div>
    <div class="col-12 nav-bar">
        <span class="col-2 header-menu-toggle">
            <i class="icono-hamburger" style="font-size: 12px; color: #ffdd00;"></i>
        </span>

        <div class="col-8 main-nav-wrap" id="main-nav-wrap">
            <ul class="main-navigation">
                <a href="./.."><li>Home</li></a>                
                <a href="#active_polls_h"><li>Active Poll</li></a>
                <a href="#recentpost_h"><li class="current">Recent Polls</li></a>
                <a href="#create_survey"><li>Create Poll</li></a>
                <a href="./../php_check/logout.php"><li>Log out</li></a>
            </ul> 
            
        </div>
        <div class="col-2 download-app" style="float: right;border: 1px solid #146941;">
            <span> 
                <?php
                    echo $_SESSION['user_name'];
                 ?>                 
            </span>
        </div>
    </div>
    <div id="active_polls_h" class="col-8  col-offset-4 header header_a">Active Polls</div>
    <div class="col-12" id="active_polls" style="border-width: 0;" >
        
    </div>
    <div class="col-6  col-offset-6 a_more" onclick="loadActivePolls()">More Active Polls</div>

    <div id="recentpost_h" class="col-8  col-offset-4 header">Recent Polls</div>
    <div class="col-12" id="recentpost" style="border-width: 0;">

    </div>
    <div class="col-6  col-offset-6 a_more" onclick="loadrecentpost()">More Recents Polls</div>
    
    <div id="create_survey" class="col-12 survey" >
        <div  class="col-12" style="text-align: center; color: #ffdd00">
            <h1>Create a Poll</h1>
        </div>
        <div id="signin" class="col-10 col-offset-2 panel">
          <form method="get" action="./create_poll.php" onsubmit="return verifyForm(this)">
            <input type="text" name="survey_name" placeholder="Survey Name" class="col-10 col-offset-2" style=" border-color: black;">
            <div class="col-10 col-offset-2  date_container">
                <label class="col-2 date_label">Starting Date</label>
                <input type="date" name="start_date" placeholder="Starting Date" class="col-5 date_input" onchange="checkCurrentDate(this)">
                <input type="time" name="start_time" placeholder="Starting Time" class="col-5 date_input" onchange="checkCurrentTime(this)">
            </div>
            <div class="col-10 col-offset-2 date_container">
                <label class="col-2 date_label">Ending Date</label>
                <input type="date" name="end_date" placeholder="Ending Date" class="col-5 date_input" onchange="checkEndDate(this)">
                <input type="time" name="end_time" placeholder="Ending Time" class="col-5 date_input" onchange="checkEndTime(this)">
            </div>
            
            <input type="submit" name="login" class="col-10 col-offset-2 signin mbutton" value="CREATE POLL" />
          </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    var sameDay = false;
    var sameEndDay = false;
    var a_page = 0, r_page= 0, a_loading= -1, r_loading =-1;

	function loadrecentpost(){
        if(r_page == r_loading){
            displayNotePane("No Recent Polls Returned");
            return;
        }
        r_loading++;
        displayNotePane("Loading Recent Polls", true);
        var ajax;
        try{
            ajax = new XMLHttpRequest();
        }catch(e){
            alert("Only Standardized used");
        }
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
                console.log(ajax.responseText);
                var temp = document.getElementById('recentpost');
                var tempdiv = "<div class='col-12' >";
                const voteList =JSON.parse(ajax.responseText);
                for (var i = 0; i < voteList.length; i++) {
                    var tempLink = "./../poll?access_code="+voteList[i].survey_accesscode;
                    var tempdiv = '<a href="'+tempLink+'"> <div class="col-12 poll_item">';
                    tempdiv += voteList[i].survey_title;
                    tempdiv += "</div></a>";
                    temp.innerHTML  += tempdiv;

                }
                if(voteList.length<10){

                }else{
                    r_page++;
                }
            }
        }
        ajax.open("GET", "./../php_check/recentpost.php?r_page="+r_page, true);
        ajax.send(null);
    }
    function loadActivePolls(){
        if(a_page == a_loading){
            displayNotePane("No Active Polls Returned");
            return;
        }
        a_loading++;
        displayNotePane("Loading Active Polls", true);
        var ajax;
        try{
            ajax = new XMLHttpRequest();
        }catch(e){
            alert("Only Standardized used");
        }
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
                
                // return;
                var temp = document.getElementById('active_polls');
                
                var tempdiv = "<div class='col-12' >";
                const voteList =JSON.parse(ajax.responseText);
                for (var i = 0; i < voteList.length; i++) {
                    var tempLink = "./../poll?access_code="+voteList[i].survey_accesscode;
                    var tempdiv = '<a href="'+tempLink+'"> <div class="col-12 poll_item">';
                    tempdiv += voteList[i].survey_title;
                    tempdiv += "</div></a>";
                    temp.innerHTML  += tempdiv;

                }
                if(voteList.length<10){

                }else{
                    a_page++;
                }
            }
        }
        ajax.open("GET", "./../php_check/activepolls.php?a_page="+a_page, true);
        ajax.send(null);
    }
    function createPollPanel(){
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
    function displayNotePane(message, ab=false){
      var note_pane = document.querySelector("div.note-pane");
      note_pane.style.marginTop = "5%";
      note_pane.innerHTML = message;
      if(ab){
        note_pane.style.backgroundColor = "green";
      }else{
        note_pane.style.backgroundColor = "#ffdd00";
      }
      setTimeout(()=>{note_pane.style.marginTop = "-100%";}, 3000);      
    }
    function verifyForm(form) {
        var inputs = form.elements;
        if(inputs.survey_name.value.length<3){
            displayNotePane("Survey Name can not be less than three character");
            inputs.survey_name.focus();
            return false;
        }
        if(inputs.start_date.value.length==""){
            displayNotePane("Starting Date has not been selected");
            inputs.start_date.focus();
            return false;
        }
        if(inputs.end_date.value.length==""){
            displayNotePane("Ending Date has not been selected");
            inputs.end_date.focus();
            return false;
        }
        if(inputs.start_time.value.length=="" || inputs.end_time.value.length==""){
            displayNotePane("Set all time");
            return false;
        }
        displayNotePane("Pass", true);
        console.log(form);
        return true;
    }
    var checkCurrentDate = (date)=>{
        sameDay = false;
        var start_time = document.querySelector("input[name=start_time]");
        var end_date = document.querySelector("input[name=end_date]");
        var d = new Date();
        var nd = new Date(date.value);
        // console.log(d.getTime() + " Cant " + nd.getTime() );
        if( nd.getFullYear() == d.getFullYear() && nd.getMonth() == d.getMonth() && nd.getDate() == d.getDate()){
            sameDay = true;
            // displayNotePane("Same date");
            // date.focus();
        }else if( nd.getTime() < d.getTime() ){
            displayNotePane("Cant Choose Old Date");
            date.value="";
            start_time.value="";
            end_date.value="";
            date.focus();
        }

        if( (!date.checkValidity()) || date.value == ""){
            end_date.value="";
        }
    }
    var checkCurrentTime = (time)=>{
        var end_date = document.querySelector("input[name=end_time]");
        var d = new Date();
        var nd = time.value.split(":");
        // console.log(parseInt(nd[1]) + " Cant " + d.getMinutes());
        var start_date = document.querySelector("input[name=start_date]");
        if( (!start_date.checkValidity()) || start_date.value == ""){
            displayNotePane("select a Starting Date");
            time.value="";
            time.focus();
            return;
        }
        ///CONTINUEEE
        if( sameDay && parseInt(nd[0]) == d.getHours() &&  parseInt(nd[1]) <= d.getMinutes()){
            displayNotePane("Cant choose Old Time *");
            time.value = "";
            time.focus();
        }
        if( sameDay && parseInt(nd[0]) < d.getHours()){
            displayNotePane("Cant choose Old Time");
            time.value = "";
            time.focus();
        }
    }
    var checkEndDate = (date)=>{
        sameEndDay = false;
        // displayNotePane("Cant " + (new Date(date.value).getTime()));
        var start_date = document.querySelector("input[name=start_date]");
        if( (!start_date.checkValidity()) || start_date.value == ""){
            displayNotePane("select a Starting Date");
            date.value="";
            start_date.focus();
            return;
        }
        var d = new Date(start_date.value);
        var nd = new Date(date.value);
        if( nd.getFullYear() == d.getFullYear() && nd.getMonth() == d.getMonth() && nd.getDate() == d.getDate()){
            sameEndDay = true;
        }
        if(nd.getTime()<d.getTime()){
            displayNotePane("Ending Date can not be less than Starting Date");
            date.value="";
            date.focus();
        }
    }
    var checkEndTime = (time)=>{
        var start_date = document.querySelector("input[name=start_date]");
        var end_date = document.querySelector("input[name=end_time]");
        var start_time = document.querySelector("input[name=start_time]");
        var d = start_time.value.split(":");
        var nd = time.value.split(":");
        // console.log(parseInt(nd[1]) + " Cant " + d[1]);
        
        if( (!end_date.checkValidity()) || end_date.value == ""){
            displayNotePane("select a Ending Date");
            time.value="";
            time.focus();
            return;
        }
        ///CONTINUEEE
        if( sameEndDay && parseInt(nd[0]) == parseInt(d[0]) &&  parseInt(nd[1]) <= parseInt(d[1])){
            displayNotePane("Cant choose Time less than Starting");
            time.value = "";
            time.focus();
        }
        if( sameEndDay && parseInt(nd[0]) < d[0] ){
            displayNotePane("Cant choose Time less than Starting");
            time.value = "";
            time.focus();
        }
    }
    var mfom = document.querySelector("#signin form");
    inputs = mfom.elements;
    if(inputs.start_date.value.length!="" || inputs.end_date.value.length!=""){
        window.location.reload();
    }
    loadrecentpost();
    loadActivePolls();
</script>
