<?php
$access_code =  $_GET['access_code'];
$question = "";
$query = "select * from questions where access_code = '{$access_code}' ";
include ("./conn.php");
if($result = mysqli_query($conn, $query)){
  $arr = mysqli_fetch_assoc($result);
  if( count($result)== 1){
    $question = $arr['question_message'];
    $question_number = $arr['question_id'];
    //echo $question.count($result);
    $query = "select * from options where question_number = '{$question_number}' ";
    if($result = mysqli_query($conn, $query)){
      while ($arr = mysqli_fetch_assoc($result)) {
        $ops[] = $arr['option_value'];
        $count[]= $arr['option_select_count'];
      }
    }else {
      die("error22>> ". mysqli_error($conn));
    }
  }else{
    die("error22>> ". mysqli_error($conn));
    header("location: errorpage.php");
  }
}else {
  die("error22>> ". mysqli_error($conn));
}
 ?>
 <?php

 include ("./conn.php");
 if(isset($_POST['sub'])){
   //echo $_POST['ans'];
   $opt =mysqli_real_escape_string($conn, $_POST['ans']);
   $new_value = 0;
   for ($i=0; $i <count($ops) ; $i++) {
     if($ops[$i] === $opt){
       $new_value =$count[$i] + 1;
       //echo "True Occured<br>";
       break;
     }else{
       //echo "False Occured<br>";
     }
   }
   //echo $new_value.'>>>'.count($ops);
   $qry = "update options set option_select_count = '{$new_value}' where question_number = '{$question_number}' and option_value = '{$opt}'";
   if($r = mysqli_query($conn, $qry)){
     echo "Done<br>";
   }else {
     echo "error22>> ". mysqli_error($conn);
   }
 }
 $total = 0;
 foreach ($count as $value) {
   $total+=$value;
 }
 echo $total;

 ?>
 <?php
 //rREMEBER TO REMOVE THIS
 $query = "select * from questions where access_code = '{$access_code}' ";
 if($result = mysqli_query($conn, $query)){
   $arr = mysqli_fetch_assoc($result);
   if( count($result)== 1){
     $question = $arr['question_message']  ;
     $question_number = $arr['question_id'];
     //echo $question.count($result);
     $query = "select * from options where question_number = '{$question_number}' ";
     if($result = mysqli_query($conn, $query)){
       while ($arr = mysqli_fetch_assoc($result)) {
         $opsNext[] = $arr['option_value'];
         $countNext[]= $arr['option_select_count'];
       }
     }else {
       die("error22>> ". mysqli_error($conn));
     }
   }else{
     die("error22>> ". mysqli_error($conn));
     header("location: errorpage.php");
   }
 }else {
   die("error22>> ". mysqli_error($conn));
 }
 $total = 0;
 foreach ($countNext as $value) {
   $total+=$value;
 }
 echo $total;
 //rREMEBER TO REMOVE THIS
  ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Voting...</title>
  </head>
  <body>
    <form method="post" action="">
      <?php echo $question; ?>
      <select name="ans">
        <?php
        foreach ($opsNext as $value) {
            echo '<option value="'. $value. '">'. $value.'</option>';
        }
        ?>
      </select><br>
      <input type="submit" name="sub" value="check">
    </form>
    <table border="2">
      <tr>
        <?php
          foreach ($opsNext as $value) {
              echo "<th>$value</th>";
          }
        ?>
      </tr>
      <tr>
        <?php
          foreach ($countNext as $value) {
              echo "<td>$value</td>";
          }
        ?>
      </tr>
      <tr>
        <?php
        if($total != 0){
          foreach ($countNext as $value) {
            $temp = round(( $value/$total )* 100, 2);
            echo "<td>$temp.%</td>";
          }
        }else{
          $temp = count($countNext);
          echo "<td colspan='$temp'>Unresolve Stats</td>";
        }
        ?>
      </tr>
    </table>
  </body>
</html>
<?php
 ?>
