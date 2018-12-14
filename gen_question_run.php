<?php
function insertFunc($msg, $acs_code, $opts)
{
  //require('./conn.php');
  $es_msg = mysqli_real_escape_string($conn, $msg);
  $es_code = mysqli_real_escape_string($conn, $acs_code);
  $query = "insert into questions (question_message, access_code) values ('{$es_msg}', '{$es_code}') ";
  if($result = mysqli_query($conn, $query)){
    echo "Upload 1 complete<br>";
    $query = "select question_id from questions where access_code = '{$es_code}' ";
    if($result = mysqli_query($conn, $query)){
      $result = mysqli_query($conn, $query);
      $arr = mysqli_fetch_assoc($result);
      if(count($arr)==1){
        $q_id = $arr['question_id'];
        $query = "";
        foreach ($opts as $key => $value) {
          $es_opt = mysqli_real_escape_string($conn, $value);
          $query = "insert into options (question_number,  option_value) values ('{$q_id}', '{$es_opt}') ";
          if($result = mysqli_query($conn, $query)){
            echo "Upload 2 complete<br>";
          }else {
            echo "option error>>> ". mysqli_error($conn);
          }
        }
        header("location: voteplace.php?access_code=$es_code");

      }
    }else {
      echo "error22>> ". mysqli_error($conn);
    }
  }else {
    echo "question>>> ". mysqli_error($conn);
  }
}
function genVal(){
  //require('./conn.php');
  $question_number_rand = rand(1, 10000000);
  $query = "select * from questions where access_code = '{$question_number_rand}' ";
  if($result = mysqli_query($conn, $query)){
    $arr = mysqli_fetch_array($result);
    if(! count($arr)>0){
      return $question_number_rand;
    }else{
      header("location: errorpage.php");
    }
  }else {
    echo "error22>> ". mysqli_error($conn);
  }
}
if(isset($_POST['submit'])){
    $question_number_rand = rand(1, 1000000);
    $access_code =  genVal();
    echo $question_number_rand." >>> ". $_POST['question_asked'] ." <br>";
    foreach ($_POST['options_supplied'] as $key => $value) {
      print_r($question_number_rand." ".$value." <br>");
    }
    insertFunc($_POST['question_asked'],$access_code,$_POST['options_supplied']);
  }

 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Question</title>
  </head>
  <script type="text/javascript">
    var question_number = 1;
    var option_arr;
    var question_div = "<br><input type='submit' name='submit' value='submit'><br>";


  </script>
  <body>
    <form method="post">
      <textarea name='question_asked' placeholder="Question"></textarea>
      <div id='genform'>
      </div>
      <input type='submit' name='submit'>
    </form>
    <br>
    <button id="add" value="add" onclick="change(this.value)">+</button>
    <button id="remove" value="remove" onclick="change(this.value)">-</button>

  </body>
</html>
<script type="text/javascript">
var form = document.getElementById('genform');
//form.innerHTML = "<textarea name='question[]' placeholder="+temp+"></textarea>";

  for (var i = 0; i < question_number; i++) {
    var temp = "Option"+(i+1);
    var value = ""+i;
    form.innerHTML += "<br><input name='options_supplied[]' placeholder="+temp+"></input>";
    form.innerHTML += "<br><input type='file' name='options_image_supplied[]' placeholder="+temp+">";
    //form.innerHTML+="<label id='add' value="+value+"  onclick='change_option(this.value)'>add</label> <label id='remove' value="+value+"  onclick='change_option(this.value)'>remove</label><br>";
  }
  //form.innerHTML += question_div;
  function change_option(val){
    var value = val+0;
    alert(val+"");
    for(var i in option_arr){
      alert(i);
    }
  }
  function change(val){
      switch(val){
        case 'add':
        question_number++;
        form.innerHTML="";
        for (var i = 0; i < question_number; i++) {
          var temp = "Option"+(i+1);
          var opt = ""+i;
          var value = ""+i;
          form.innerHTML += "<br><input name='options_supplied[]' placeholder="+temp+"></input>";
          form.innerHTML += "<br><input type='file' name='options_image_supplied[]' placeholder="+temp+">";
          //form.innerHTML+="<label id='add' value="+value+" onclick='change_option(this.value)'>add</label> <label id='remove' value="+value+"  onclick='change_option(this.value)'>remove</label><br>";
        }
        //form.innerHTML += question_div;
        break;
        case 'remove':
        question_number--;
        form.innerHTML="";
        for (var i = 0; i < question_number; i++) {
          var temp = "Option"+(i+1);
          var value = ""+i;
          form.innerHTML += "<br><input name='options_supplied[]' placeholder="+temp+"></input>";
          form.innerHTML += "<br><input type='file' name='options_image_supplied[]' placeholder="+temp+">";
          //form.innerHTML+="<label id='add' value="+value+"  onclick='change_option(this.value)'>add</label> <label id='remove' value="+value+"  onclick='change_option(this.value)'>remove</label><br>";
        }
        //form.innerHTML += question_div;
        break;
        default:
        //alert(val+"");
        break;
      }
    }
</script>
