<?php
  session_start();
  // if(isset($_SESSION['user_id'])){
  //   if($_SESSION['logged_in'] != 'true'){
  //     header("location: index.php");
  //   }
  // }else{
  //       header("location: index.php");
  // }
  if(!isset($_GET['access_code'])){
    $_SESSION['error_message'] = "Invalid access code";
    header("location: ./../php_check/errorpage.php");
    return;
  }
  if(count($_GET['access_code'])==""){
    $_SESSION['error_message'] = "empty access code";
    header("location: ./../php_check/errorpage.php");
    return;
  }
  require("./../php_check/DBAccess.php");
  require("./../php_check/Utils.php");
  $mDBAccess = new DBAccess();
  $pollData = $mDBAccess->getPollData($_GET['access_code']);
  $voted = $pollData['has_voted'];
  $uploader =  $pollData["survey_data"]['uploader'];
  if(!$pollData){
    header("location: ./../php_check/errorpage.php");
  }
  $main_color = $pollData['colors']['p_color'];
  $sec_color = $pollData['colors']['s_color'];
  $bar_color = $pollData['colors']['b_color'];

  $start_date = $pollData["survey_data"]['start_date'];
  $start_time = $pollData["survey_data"]['start_time'];
  $end_date = $pollData["survey_data"]['end_date'];
  $end_time = $pollData["survey_data"]['end_time'];
  // var_dump(json_encode( $pollData ));
  $starts = strtotime(($start_date." ".$start_time))+(60*60);
  $ends = strtotime($end_date." ".$end_time)+(60*60);
  
  date_default_timezone_set("Africa/Lagos");

  $current_date = getdate();
  // var_dump(json_encode( $current_date ));
  $formatted_date = $current_date['year'] . "-";
  $formatted_date .= $current_date['mon'] . "-";
  $formatted_date .= $current_date['mday'] . " ";
  $formatted_date .= $current_date['hours'] . ":";
  $formatted_date .= $current_date['minutes'] . ":";
  $formatted_date .= $current_date['seconds'];
  $current = strtotime($formatted_date);
  $poll_status = 0;
  $poll_status_header = "";
  if($current<$starts){
    $poll_status = 0;
    $poll_status_header = "( Yet to start )";
  }elseif ($starts<$current && $current< $ends) {
    $poll_status = 1;
    $poll_status_header = "( Active )";
  }elseif ($ends<$current) {
    $poll_status = -1;
    $poll_status_header = "( Finished )";
  }
 ?>



<html>
  <head>
    <meta charset="utf-8">
    <title><?php print($pollData['survey_data']['survey_title']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/main.css">
    <link rel="stylesheet" href="./../css/icon.min.css">
    <link rel="stylesheet" href="./poll.css">
    <?php if (strlen($main_color) > 0): ?>
      <style type="text/css">
        .survey_title, .close, h4.date_pane, .count_number{
          background-color: <?php print($main_color); ?>;
        }
        .date_pane, .time_case h3, .date_case h3, .date_pane h6{
          color: <?php print($main_color); ?>;
        }
        .main_holder{
          background-color: <?php print($main_color); ?>25;
          border-top: 20px solid <?php print($main_color); ?>;
        }
        .main_poll_container{
          box-shadow: 0 0 2px <?php print($main_color); ?>;
        }
        .unit_container{
          box-shadow: 0 0 4px <?php print($main_color); ?>; margin-bottom:2%;
        }
        .unit_item{
          border-bottom: 1px solid <?php print($main_color); ?>;
        }
        .pat_toggle:hover, .time_case{
          background-color: <?php print($main_color); ?>90;
        }
        .votebar{
          background-color: <?php print($bar_color) ?>;
          color: <?php print($bar_color) ?>;
          border-right-color: <?php print($sec_color) ?>;
        }
        .question_container, .edit{
          background-color: <?php print($sec_color) ?>;
        }
        .count_number_sub{
          background-color: <?php print($sec_color) ?>90; 
        }
      
      </style>
    <?php endif ?>

  </head>
  <body>
  <div class="col-2 edit" style="display:  <?php echo $uploader?"block":"none"; ?>;" onclick="show_customize()">Edit</div>
  <?php if (isset($_SESSION['logged_in'])): ?>
  <div class="col-6 col-offset-6 customize-panel">

      <div class="col-12" style="background-color: <?php print($main_color); ?>">
        <span class="col-3"> Main Color </span>
        <input class="col-1 col-offset-7 main_color c_color" type="color" 
              style="background-color: <?php print($main_color); ?>" value=<?php print($main_color); ?> >
      </div>
      <div class="col-12" style="background-color: <?php print($sec_color); ?>">
        <span class="col-3"> Secondary Color </span>
        <input class="col-1 col-offset-7 bar_color c_color" type="color" 
              style="background-color: <?php print($sec_color); ?>" value=<?php print($sec_color); ?> >  
      </div>
      <div class="col-12" style="background-color: <?php print($bar_color); ?>">
        <span class="col-3"> Bar Color </span>
        <input class="col-1 col-offset-7 bar_color c_color" type="color" 
              style="background-color: <?php print($bar_color); ?>" value=<?php print($bar_color); ?> >
      </div>
      
      
      <button class="col-3 col-offset-1" onclick="save_customize()">Save</button>
      <button class="col-3 col-offset-1" onclick="close_customize()">Cancel</button>
      <button class="col-3 col-offset-1" onclick="setDault()">default</button>
  </div>
  <?php endif ?>
  <div id="myModal" class="modal col-8 col-offset-4">
    
    <img class="modal-content col-6 col-offset-6" id="imgbig" style=" padding: 0; ">
    <div class="col-12 close" style="font-size: 2em;">close</div>
  </div>
  <div class="col-12 nav-bar">
      <span class="col-2 header-menu-toggle">
          <i class="icono-hamburger" style="font-size: 12px; color: #ffdd00;"></i>
      </span>

      <div class="col-8 main-nav-wrap" id="main-nav-wrap">
          <ul class="main-navigation">
              <a href="./.."><li>Home</li></a>                              
              <a href="./../dashboard#create_survey"><li>Create a Poll</li></a>
          </ul> 
          
      </div>
      <div class="col-2 poll_status_header" >
          
              <?php echo $poll_status_header; ?>
          
      </div>
  </div>
  <div class="col-12 survey_title" style="background-color: #;">
    <?php print($pollData['survey_data']['survey_title']); ?>
  </div>

  <div class="col-8 col-offset-4 main_time_date" style="text-align: center; margin-bottom: 0; padding: 0;">
    <div class="col-6 time_case">
      <h3>CountDown</h3>
      <div class="col-12">
      <div class="col-3 count_case">
        <div class="col-12 count_number">
          00
        </div>
        <h4 class="col-12 count_number_sub">
          Days
        </h4>
      </div>
      <div class="col-3 count_case">
        <div class="col-12 count_number">
          00
        </div>
        <h4 class="col-12 count_number_sub">
          Hours
        </h4>
      </div>
      <div class="col-3 count_case">
        <div class="col-12 count_number">
          00
        </div>
        <h4 class="col-12 count_number_sub">
          Minutes
        </h4>
      </div>
      <div class="col-3 count_case">
        <div class="col-12 count_number">
          00
        </div>
        <h4 class="col-12 count_number_sub">
          Seconds
        </h4>
      </div>    
      </div>
    </div>
    <div class="col-6 date_case" >
      <h3 style="padding: 0; margin: 0;"><?php echo $poll_status_header; ?></h3>
      <div class="col-12"  style="background-color:  #ffffff59; padding: 2px;">
        <h4 class="date_pane">
          <?php print(($start_date." ".$start_time)) ?>
        </h4>
        <h6 class="date_pane">
          to
        </h6>
        <h4 class="date_pane">
          <?php print(($end_date." ".$end_time)) ?>
        </h4>
      </div>
    </div>
  </div>
  <?php if ($poll_status == 1): ?>
    <div class=" col-12 pat_toggle" onclick="show_vote()" style="display: <?php echo  $voted? "none":"block"; ?>">
      Tap to Vote
    </div>    
  <?php endif ?>
  <?php
    if(!$voted){
      print( Utils::votingBlock($pollData) );
    }    
   ?>
  <div class="col-12 main_holder"  style="">

    <div class="col-9 col-offset-3 main_poll_container">
      <?php
        print( Utils::renderVotes($pollData) );
      ?>
    </div>
  </div>

  </body>
</html>
<script type="text/javascript">
  var span = document.getElementsByClassName("close")[0];
  var modal = document.getElementsByClassName("modal")[0];
  var modalImg = document.getElementById("imgbig");
  var modalTitle = document.getElementById("title");

  var poll_status = <?php print(json_encode($poll_status )); ?>;
  var starts = <?php print(json_encode($starts )); ?>;
  var ends = <?php print(json_encode($ends )); ?>;
  var current = <?php print(json_encode($current )); ?>;


  function show_big(val){
    var temploc = val.src.replace("\/thumbnail", "");
      modal.style.display = "block";
      modalImg.src = val.src.replace("\/thumbnail", "");
      modalImg.alt = val.alt;
      modalTitle.innerHTML = val.parentNode.nextElementSibling.innerHTML;
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
      console.log(span);
      modal.style.display = "none";
  }
  function update(){
    // console.log('>>>');
    var votebar = document.getElementsByClassName('votebar');
    var votevalue = document.getElementsByClassName('votevalue');
    var ajax;
    try{
      ajax = new XMLHttpRequest();
       // console.log("updating");
    }catch(e){
      alert("Only Standardized used");
    }
    ajax.onreadystatechange = function(){
      if(ajax.readyState == 4){
          // console.log(ajax.responseText);
          var temp_arr = ajax.responseText;
          temp_arr = JSON.parse(temp_arr);
          //console.log(temp_arr[0]);
          updateVoteBar(votebar, votevalue, temp_arr);
      }
    }
      //var document.getElementById("myfile");
    var temp = "<?php echo $_GET['access_code']; ?>";
    ajax.open("GET", "./../php_check/poll_updater.php?access_code="+temp, true);
    ajax.send();

  }
  function updateVoteBar(nodes, valm, arr) {
    s = 0;
    total_arr = [];
    for (var i = 0; i < arr.length; i++) {
      temp =0;
      for (var j = 0; j < arr[i].length; j++) {
        temp += parseInt(arr[i][j]);
        s++;
      }
      total_arr[i] = temp;
    }

    if(valm.length > 0){
      s = 0;
      for (var i = 0; i < arr.length; i++) {
        for (var j = 0; j < arr[i].length; j++) {
          width_temp = ((arr[i][j]/total_arr[i]) * 100).toFixed(1) + '%';
          nodes[s].style.width = width_temp;
          valm[s].innerHTML = width_temp +" (" + arr[i][j]+")";
          s++;
        }
      }
    }else{
      for(var i =0;i<total_arr.length; i++){
        //console.log(total_arr[i]);
        if(total_arr[i]>0){
          location.reload();
        }
      }
    }

  }
  var show_vote = ()=>{
    var v_panel = document.querySelector("div.v_panel");
    console.log(v_panel.style.maxHeight);
    if(v_panel.style.maxHeight){
      v_panel.style.maxHeight = null;      
    }else{
      v_panel.style.maxHeight =  v_panel.scrollHeight+"px";
      
    }
  }
  var check_vote = ()=>{
    var votes = document.querySelectorAll("select.selection");
    for (var i = 0; i < votes.length; i++) {
      if(votes[i].value == "-1"){
        votes[i].focus();
        return false;
      }
    }
  return true;
  }
  var myVar = setInterval(update, 10000);
  var customizePanel = document.querySelector(".customize-panel");
  var values = document.querySelectorAll("input.c_color");

  var show_customize = ()=>{
    
    customizePanel.style.marginTop = "5%";
  }
  var close_customize = ()=>{
    customizePanel.style.marginTop = "-300%";
  }
  var updateColor= (e)=>{
    
    e.target.parentNode.style.backgroundColor = e.target.value;
    e.target.style.backgroundColor = e.target.value;
  }
  try{
    values[0].onchange = updateColor;
    values[1].onchange = updateColor;
    values[2].onchange = updateColor;
  }catch(e){
    console.log(e);
  }
  var setDault = () =>{
    values[0].value="#4d60a5";
    values[0].parentNode.style.backgroundColor = "#4d60a5";
    values[0].style.backgroundColor = "#4d60a5";
    values[1].value="#ffdd00";
    values[1].parentNode.style.backgroundColor = "#ffdd00";
    values[1].style.backgroundColor = "#ffdd00";
    values[2].value="#4c36ef";
    values[2].parentNode.style.backgroundColor = "#4c36ef";
    values[2].style.backgroundColor = "#4c36ef";
  }
  var save_customize = ()=>{
    
    
    
    var access_code = (new URL(window.location.href)).searchParams.get('access_code');
    window.location.href = "color_setting.php?p_color="+values[0].value.replace('#','$')
                            +"&s_color="+values[1].value.replace('#','$')
                            +"&b_color="+values[2].value.replace('#','$')
                            +"&access_code="+access_code
    ;
  }
  
  var timer_update = ()=>{
    // console.log(current-starts);
    var diffTime = 0;
    if(current<starts){
      diffTime = starts - current++;
    }else if (starts<current && current< ends) {
      diffTime = ends - current++;
    }
    if(diffTime<=0){
      window.location.reload();
    }
    var xDays = Math.floor(diffTime/(24*60*60));
    var xHours = Math.floor((diffTime%(24*60*60))/(60*60));
    // xHours += 1;
    
    
    var xMinutes = Math.floor((diffTime%(60*60))/60);
    var xSeconds = Math.floor(diffTime%60);
    var remainingTime = [xDays, xHours, xMinutes, xSeconds];
    var CountDown = document.querySelectorAll("div.count_number");
    for (var i = 0; i < CountDown.length; i++) {
      CountDown[i].innerHTML = remainingTime[i];
    }
  }  
  var myVarTime;
  if ( !(ends<current) ) {
      myVarTime = setInterval(timer_update, 1000);
  }
  

</script>
