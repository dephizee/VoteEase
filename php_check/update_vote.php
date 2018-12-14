<?php 
  $access_code = $_GET['access_code'];
  $access_code;
  $query = "select * from questions where access_code = '{$access_code}' ";
include ("./../conn.php");
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

echo json_encode($option_arr_count_re);