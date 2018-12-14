<?php
  session_start();
  if(isset($_SESSION['user_id'])){
    if($_SESSION['logged_in'] != 'true'){
      header("location: index.php");
    }
  }else{
        header("location: index.php");
    }


  if(!isset($_GET['access_code'])){
    $_SESSION['error_message'] = "Invalid access code";
    header("location: ./php_check/errorpage.php");
  }
  if(count($_GET['access_code'])==0){
    $_SESSION['error_message'] = "empty access code";
    header("location: ./php_check/errorpage.php");
  }
 ?>
<?php
$access_code =  $_GET['access_code'];
$question = "";
$question_number;
$option_arr;
$option_arr_count;
$query = "select * from questions where access_code = '{$access_code}' ";
include ("./conn.php");
if($result = mysqli_query($conn, $query)){
  while ($arr = mysqli_fetch_assoc($result)) {
    $question[] = $arr['question_message'];
    $question_number[] = $arr['question_id'];
  }
  if( count($question_number) > 0){
    foreach ($question_number as $key => $value) {
      $q = $value;
      $ops = array();
      $count = array();
      $query = "select * from options where question_number = '{$q}' ";
      if($result = mysqli_query($conn, $query)){
        while ($arr = mysqli_fetch_assoc($result)) {
          $ops[] = $arr['option_value'];
          $count[]= $arr['option_select_count'];
        }
      }else {
        die("error222>> ". mysqli_error($conn));
      }
      $option_arr[] = $ops;
      $option_arr_count[] = $count;
    }

  }else{
    $_SESSION['error_message'] = "Invalid Access Code";
    header("location: ./php_check/errorpage.php");
  }
}else {
  die("error22>> ". mysqli_error($conn));
}
 ?>
 <?php
  $survey_title = "";
  $survey_id = 0;
    include ("./conn.php");
    $query = "select * from surveys where survey_accesscode = '{$access_code}' ";
    $votequery = "";
    if($result = mysqli_query($conn, $query)){
      $arrtitle = mysqli_fetch_assoc($result);
      $survey_title = $arrtitle['survey_title'];
      $survey_id = $arrtitle['survey_id'];
      $temp = mysqli_real_escape_string($conn, $arrtitle['survey_id']);
      $t = $_SESSION['user_id'];
      $votequery = "insert into votes (vote_survey_number, vote_user_number) values ('{$temp}', '{$t}')";
    }else {
      die("error22>> ". mysqli_error($conn));
    }
   ?>
 <?php
 include ("./conn.php");
 if(isset($_POST['sub'])){
  $voted = false;
  include ("./conn.php");
  $query = "select * from votes where vote_user_number = '{$_SESSION["user_id"]}' and vote_survey_number = '{$survey_id}' ";
  if($result = mysqli_query($conn, $query)){
    if(mysqli_num_rows($result) > 0){
      $voted = true;
    }
  }else {
    die("error22>> ". mysqli_error($conn));
  }
  if(!$voted){
    $t = false;
    $s = false;
   foreach ($_POST['ans'] as $key => $value) {
     $temp = mysqli_real_escape_string($conn, $value);
     if($temp!=''){
      $s = true;
     }
     $qry = "update options set option_select_count = option_select_count + 1 where question_number = '{$question_number[$key]}' and ";
     $qry .= "option_value = '{$temp}'";
     if($r = mysqli_query($conn, $qry)){
        //echo "Done<br>";
        $t = true;
      }else {
        echo "error22>> ". mysqli_error($conn);
        $t = false;
      }
   }
   if($t && $s){
    if($r = mysqli_query($conn, $votequery)){
        echo "voted<br>";
      }else {
        echo "error22>> ". mysqli_error($conn);
      }
   }
 }else{
    $_SESSION['error_message'] = "Can't vote twice";
    header("location: ./php_check/errorpage.php");

 }
 }
 //var_dump($total)

 ?>
 <?php
 $query = "select * from questions where access_code = '{$access_code}' ";
include ("./conn.php");
if($result = mysqli_query($conn, $query)){
  while ($arr = mysqli_fetch_assoc($result)) {
    $question_re[] = $arr['question_message'];
    $question_number_re[] = $arr['question_id'];
  }
  if( count($question_number_re) > 0){
    foreach ($question_number_re as $key => $value) {
      $q = $value;
      $ops = array();
      $option_img = array();
      $count = array();
      $query = "select * from options where question_number = '{$q}' ";
      if($result = mysqli_query($conn, $query)){
        while ($arr = mysqli_fetch_assoc($result)) {
          $ops[] = $arr['option_value'];
          $ops_id = $arr['option_id'];
          $count[]= $arr['option_select_count'];

            $qry = "select image_option_url from image_option where image_option_number = '{$ops_id}' ";
            if($re = mysqli_query($conn, $qry)){
              if(mysqli_num_rows($re) == 1){
                while ($ar = mysqli_fetch_assoc($re)) {
                  $option_img[] = $ar['image_option_url'];
                }
              }elseif(mysqli_num_rows($re) == 0){
                $option_img[] ='';
              }else{
                die("error>> more than a record ". mysqli_num_rows($re));
              }
            }else {
              echo ("error22>> ". mysqli_error($conn));
            }
        }
      }else {
        die("error22>> ". mysqli_error($conn));
      }





      $option_arr_re[] = $ops;
      $option_arr_img_re[] = $option_img;
      $option_arr_count_re[] = $count;
    }
    //var_dump($option_arr_img_re);

  }else{
    die("error22>> ". mysqli_error($conn));
    header("location: errorpage.php");
  }
}else {
  die("error22>> ". mysqli_error($conn));
}
$total = array();
 foreach ($option_arr_count_re as $key => $value) {
   $total[$key] = 0;
   foreach ($value as $k => $v) {
     $total[$key] += $v;
   }
 }
 ?>



<html>
  <head>
    <meta charset="utf-8">
    <title>Voting...</title>
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
        border: 1px solid #fff;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

      }
      [class*=col-]:hover{
        text-overflow: inherit;
        overflow: visible;
      }
      .header{
        text-align: center;
        background-color: #146941;
      }
      .votebar{
        background: linear-gradient(to right, grey , #990099, #990099);
        transition: 2s;
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
      input:focus{
        border-color: #146941;
        box-shadow:0 0 5px #146941;
        background-color: #146941;
        color: white;
      }
      .question{
        margin-top: 2%;
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
      .modal{
        position: fixed;
        z-index: 1;
        display: none;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 4%;

      }
      .modal-content {
        animation-name: zoom;
        animation-duration: 0.6s;
        max-width: 40%;
      }
      @keyframes zoom {
          from {transform: scale(0.1)}
          to {transform: scale(1)}
      }
      .close{
        position: absolute;
        left: 90%;
        top: 5%;
        color: red;
      }
      .close:hover{
        cursor: pointer;
      }
      .find{
        padding: 8px;
      }
      .mbutton{
        background-color: #146941;
        color: white;
        margin-top: 2%;
      }
      .navbar{
          text-align: center;
          background-color: #146941;
          box-shadow:0 0 5px #146941;
      }
      .logo{
          width: 30%;
          height: auto;
      }
      .mbutton:hover{
        cursor: pointer;
        box-shadow:0 0 5px #146941;

      }
      body{
            color: black;
            /*background-image: url("images/1.jpeg");
            background-repeat: no-repeat;
            background-size: cover;*/
            background-color: rgba(30, 0, 30, 0.5);
            color: white;
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
        width: 90%;
        margin-left: 5%;
        padding: 0px;
        }
      .imageclass{
        width: 30%;
        margin-left: 20%;
      }
      .modal-content {
        animation-name: zoom;
        animation-duration: 0.6s;
        max-width: 800px;
      }
      .model{
        padding: 0;
      }
      .close{
        left: 95%;
        top: 0;

      }
    }
    </style>
  </head>
  <body>
  <div id="myModal" class="modal col-8 col-offset-4">
    <span class="close" style="font-size: 2em;">×</span>
    <img class="modal-content col-6 col-offset-6" id="imgbig" style=" padding: 0;">
    <p class="col-7 col-offset-4" id="title" style="margin-top: 0; text-align: center; background-color: rgba(0, 0, 0, 1);"></p>
  </div>
  <div class="row">
    <div class="col-9 col-offset-3 header">
      <div class="col-6" style="border-width: 0;">
        <div class="col-6" style="padding: 0px;">
          <a href="./index.php"><img src="images/logo.png" alt="VoteEase" class="logo"></a>
        </div>
      </div>
      <div class="col-6" style="border-width: 0;">
        <div class="col-4 col-offset-12 find"  style=" background-color: white; color: black; ">
            <?php
              echo $_SESSION['user_name'];
             ?>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
      <div class="col-9 col-offset-3" style="text-align: center; background-color: rgba(255, 255, 255, 0.2);">
        <?php echo"Access Code : ". $_GET['access_code'] ?>
      </div>
      <div class="col-9 col-offset-3 header">
        <?php echo $survey_title; ?>
      </div>
  </div>
  <div class="row">
    <div class="col-9 col-offset-3">
      <?php
        $voted = false;
        include ("./conn.php");
        $query = "select * from votes where vote_user_number = '{$_SESSION["user_id"]}' and vote_survey_number = '{$survey_id}' ";
        if($result = mysqli_query($conn, $query)){
          if(mysqli_num_rows($result) > 0){
            $voted = true;
          }
        }else {
          die("error22>> ". mysqli_error($conn));
        }
        if(!$voted){
          echo '<form method="post" action="">';
          foreach ($question as $key => $value) {
            $t = $key+1;
            echo "<div class='col-3 col-offset-1 question' style='padding:0; border-width: 0;'>";
            echo "<div class='col-12'>";
            echo $t." : ". $value;
            echo "</div>";
            echo "<div class='col-12'>";
            echo "<select name='ans[]' class='selection col-12'>";
            echo '<option value=""> - - - </option>';
            foreach ($option_arr[$key] as $value) {
                echo '<option value="'. $value. '">'. $value.'</option>';
            }
            echo "</select>";
            echo "</div>";
            echo "</div>";

          }
          echo '<button type="submit" name="sub" value="submit" class="mbutton col-9 col-offset-2" >check</button>';
          echo "</form>";
        }else{

        }

         ?>
    </div>
  </div>
  <div class="row">

    <div class="col-9 col-offset-3">
      <?php
        foreach ($option_arr_count_re as $key => $value) {
          echo "<div class='col-12' style='box-shadow: 0 0 8px white; margin-bottom:2%; background-color:#146941;'>";
          echo '<div class="col-12" style="border-width:0px; font-size: 1.8em; text-align:center;">';
          echo $question[$key];
          echo "</div>";
          echo '<div class="col-12" style="border-width:0px; font-size: 1.5em;">';
          /*echo '<img src="" >';
          echo '<img src="" >';*/
          echo "</div>";
          echo "<div class='col-12' style='padding:0; border:0;'>";
          $c = count($option_arr_re[$key]);
          //$temp = 12 /count($option_arr_re[$key]);

          //$temp = 'col-'.$temp;
          for ($i=0; $i < $c; $i++) {
            if($total[$key] != 0){
              $t = round(($value[$i]/$total[$key]) * 100, 1);
              $t.="%";
              if(isset($option_arr_img_re[$key][$i]) && $option_arr_img_re[$key][$i] != ''){

                echo '<div class="row" style="padding:0;">';
                echo '<div class="col-3" style="padding:0;border-color:white;">';
                echo '<div class="col-3" style="padding:0; border-width:0;">';
                echo '<img src="'.'./thumbnail/'.$option_arr_img_re[$key][$i].'" alt="image" class="col-12 imageclass" style="padding:0; border-width:1;" onclick="show_big(this)">';
                echo '</div>';
                echo '<div class="col-9" style="padding:0; border-width:0; font-size:1.2em;border-color:white;">';
                echo $option_arr_re[$key][$i];
                echo '</div>';
                echo '</div>';
                echo '<div class="col-2 votevalue" style="border-color:white;">'.$value[$i].'<span style="position:relative; left:55%;" class="votepercent">'.$t.'</span></div>';
                echo '<div class="col-7" style="padding:0; border-width:0;">';
                echo '<div class="col- votebar" style="border-color:white;margin-left:0; border-right-width: 5;border-right-color: white; width:'.$t.';">'.'.'.'</div>';
                echo '</div>';
                echo '</div>';
              }else{
                echo '<div class="col-3" style="border-color:white;">'.$option_arr_re[$key][$i].'</div>';
                echo '<div class="col-2 votevalue" style="border-color:white;">'.$value[$i].'<span style="position:relative; left:55%;" class="votepercent">'.$t.'</span></div>';
                echo '<div class="col-7" style="padding:0; border-width:0;border-color:white;">';
                echo '<div class="col-12 votebar" style="margin-left:0; border-right-width: 5;border-right-color: white; width:'.$t.';">'.'.'.'</div>';
                echo '</div>';
              }

            }else{
              if(isset($option_arr_img_re[$key][$i]) && $option_arr_img_re[$key][$i] != ''){

                echo '<div class="row" style="padding:0;">';
                echo '<div class="col-3" style="padding:0;">';
                echo '<div class="col-3" style="padding:0; border-width:0;">';
                echo '<img src="'.'./thumbnail/'.$option_arr_img_re[$key][$i].'" alt="image" class="col-12 imageclass" style="padding:0; border-width:1;max-height:40px;" onclick="show_big(this)" >';
                echo '</div>';
                echo '<div class="col-9" style="padding:0; border-width:0; font-size:1.2em;">';
                echo $option_arr_re[$key][$i];
                echo '</div>';
                echo '</div>';
                echo '<div class="col-2">No Vote Yet</div>';
                echo '<div class="col-7" style="padding:0; border-width:0;">';
                echo '<div class="col- votebar" style="margin-left:0; border-right-width: 5;border-right-color: white; width:0%;">'.'.'.'</div>';
                echo '</div>';
                echo '</div>';
              }else{
                echo '<div class="col-3">'.$option_arr_re[$key][$i].'</div>';
                echo '<div class="col-2">No Vote Yet</div>';
                echo '<div class="col-7" style="padding:0; border-width:0;">';
                echo '<div class="col-8 votebar" style="margin-left:0; border-right-width: 5;border-right-color: white; width:0%;">'.'.'.'</div>';
                echo '</div>';
              }

            }


          }
          echo "</div>";
          echo "</div>";
        }


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
    console.log('>>>');
    var votebar = document.getElementsByClassName('votebar');
    var votevalue = document.getElementsByClassName('votevalue');
    var ajax;
    try{
      ajax = new XMLHttpRequest();
       console.log("updating");
    }catch(e){
      alert("Only Standardized used");
    }
    ajax.onreadystatechange = function(){
      if(ajax.readyState == 4){
          //console.log(ajax.responseText);
          var temp_arr = ajax.responseText;
          temp_arr = JSON.parse(temp_arr);
          //console.log(temp_arr[0]);
          updateVoteBar(votebar, votevalue, temp_arr);
      }
    }
      //var document.getElementById("myfile");
    var temp = "<?php echo $access_code; ?>";
    ajax.open("GET", "./php_check/update_vote.php?access_code="+temp, true);
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
          valm[s].innerHTML = arr[i][j];
          var tem = document.createElement('span');
          tem.style.position = 'relative';
          tem.style.left = '55%';
          tem.innerHTML = width_temp;
          valm[s].appendChild(tem);
          // perc[s].innerHTML = width_temp;
          // console.log(valm[s].innerHTML);
          // console.log(perc[s].innerHTML);
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
  var myVar = setInterval(update, 10000);
</script>
