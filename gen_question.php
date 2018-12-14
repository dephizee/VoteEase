<?php
  $xml=simplexml_load_file("formgen.xml");
  $question_number = $xml->counter+0;
  if(isset($_POST['submit'])){
    include('./conn.php');
    $question_number_rand = rand(1, 1000000);
    foreach ($_POST['options'] as $key => $value) {
      echo $question_number_rand." ".$value." <br>";
    }
    $count  = 0;
    $temp_ask = $_POST['question_asked'];
    $xml->question[$question_number]->ask = $temp_ask;
    foreach ($_POST['options'] as $value) {
      $xml->question[$question_number]->option[$count] = $value;
      $count++;
    }
    $xml->counter = $question_number+1;
    $temp = $xml->addChild('question');
    $temp->addChild('ask','temp');

    $xml->asXML('formgen.xml');
    header("location: gen_question.php");
  }
?>
<?php
  if(isset($_POST['add'])){
    $xml->question[$question_number]->addChild("option");
    $xml->asXML('formgen.xml');
  }
  if(isset($_POST['remove'])){
    $cur = count($xml->question[$question_number]) - 1;
    for ($i=0; $i < $cur; $i++) {
      if($i == $cur -1){
      unset( $xml->question[$question_number]->option[$cur-1] );
    }

    }
    $xml->asXML('formgen.xml');
  }

 ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Question</title>
  </head>
  <script type="text/javascript">
  </script>
  <body>
    <form id='genform' method="post">

      <?php
      for ($i=0; $i <$question_number ; $i++) {
        $temp = $i+1;
        $temp_q =$xml->question[$i]->ask;

        print_r("<b> $temp :$temp_q</b><br>");
        $count  = 1;
        print_r("<ol>");
        foreach ($xml->question[$i]->option as $value) {
          print_r("<li>$value</li>");
          $count++;
        }
        print_r("</ol>");
      }
      $temp = 1+$question_number;
      print_r("<textarea name='question_asked' placeholder='Enter a Question $temp'></textarea>");
      $count  = 1;
      foreach ($xml->question[$question_number]->option as $value) {
        print_r("<br>");
        print_r("<input type='text' name='options[]' value='' placeholder='Options $count'>");
        $count++;
        }

       ?>
      <input type="submit" name="submit" value="set up vote"><br>
      <input type=submit name="add" value="+">
      <input type=submit name="remove" value="-">

    </form>

  </body>
</html>
