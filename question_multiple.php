<?php
  session_start();
  if(isset($_SESSION['user_id'])){
    if($_SESSION['logged_in'] != 'true'){
      header("location: index.php");
    }
  }else{
        header("location: index.php");
    }

  if(isset($_GET['access_code'])){
    if($_SESSION['logged_in'] != 'true'){
      header("location: index.php");
    }
  }else{
        header("location: index.php");
    }
?>
<?php
$survey_title;
require('./conn.php');
if(isset($_GET['access_code'])){
$ace = mysqli_real_escape_string($conn, $_GET['access_code']);
$query = "select * from surveys where survey_accesscode = '{$ace}'";
   if($result = mysqli_query($conn, $query)){
      if( !mysqli_num_rows($result) > 0){
        $_SESSION['error_message'] = 'Invalid url';
        header("location: ./php_check/errorpage.php");
      }else{
        $r = mysqli_fetch_assoc($result);
        $survey_title= $r['survey_title'];
      }

   }else{
    echo "please refresh";
  }
}
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Question</title>
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
        color: white;
      }
      .mbut{
        height: 40px;
        border-style: solid;
        border-width: 1px;
        border-color: black;
        text-align: center;
        width: 32%;
        color: white;
        transition: 2s;
        color: black;
        background-color: #146941;
        color: white;
      }
      .mbut:hover{
        cursor: pointer;
        border-color: white;
        box-shadow:0 0 5px white;

      }
      .options_img_supplied{
        display: none;
      }
      .options_class:hover > img{
        display: block;
      }
      textarea{
        height: 80px;
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
      input:focus{
        border-color: #146941;
        box-shadow:0 0 5px #146941;
        background-color: #146941;
        color: white;
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
        .logo{
            width: 30%;
            height: auto;
        }
      .close{
        position: absolute;
        top: 5%;
        right: 3%;
      }
      .close:hover{
        cursor: pointer;
        box-shadow:0 0 5px #fff;

      }
      .find{
        padding: 8px;
      }
      .mbutton{
        height: 40px;
        border-style: solid;
        border-width: 1px;
        border-color: black;
        text-align: center;
        width: 80%;
        color: white;
        transition: 2s;
        color: black;
        background-color: #146941;
        color: white;
      }
      .mbutton:hover{
        cursor: pointer;
        border-color: white;
        box-shadow:0 0 5px white;

      }
      .mediaspan{
        position: absolute;
        right: 5%;
        top: 15%;
        display: none;
      }
      .mediaspan:hover {
        cursor: pointer;
      }
      .container_div:hover > .mediaspan{
        display:block;
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
        width: 80%;
        margin-left: 10%;
        }
      .mediaspan{
        position: absolute;
        right: 15%;
        top: 5%;
      }
      .options_img_supplied{
        max-width: 200px;
        height: auto;
      }
      .img_bar{
        margin: 0;
      }
      .mbut{
        width: 30%;
      }
    }
    </style>
  </head>
  <body>
    <div id="main_body" style="transition: 2s;">
      <div class="row navbar">
        <div class="col-6">
          <div class="col-6" style="padding: 0px">
            <a href="./index.php"><img src="images/logo.png" alt="VoteEase" class="logo"></a>
          </div>
        </div>
        <div class="col-6">
          <div class="col-offset-6 col-6 find"  style=" background-color: white; ">
              <?php
                echo $_SESSION['user_name'];
               ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 header">
        <?php echo $survey_title; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <button id="add_question" value="add" onclick="addQuestion()" class="mbutton" style="background-color: rgba(0, 0, 300, 0.7);">Add Question</button>
        </div>
        <div class="col-6">
          <button id="add_question" onclick="submitQuestion()" class="mbutton" style="background-color: rgba(0, 255, 0, 0.7);">Submit Question(s)</button>
        </div>
      </div>
      <div class="row">
            <div id="questions" class="col-12">
              <div id="default_question" class="col-4 questions">
                <div class="col-12 container_div" style="position: relative;">
                  <textarea name='question_asked' placeholder="Question" class="col-12 textarea_class"></textarea>
                </div>

                <button class="mbut" id="add" value="add" onclick="change(this)" style="background-color: rgba(0, 255, 0, 0.7);">+</button>
                <button class="mbut" id="remove" value="remove" onclick="change(this)" style="background-color: rgba(0, 0, 300, 0.7);">-</button>
                <button class="mbut" id="remove_question" value="remove_question" onclick="change(this)"  style="background-color: rgba(255, 0, 0, 1); border-width: 0;">x</button>
              </div>
            </div>
            <div id="result" style="background-color: white;">

            </div>
      </div>
    </div>
  </body>
</html>
<script type="text/javascript">

	var default_question = document.getElementById("default_question");
  var questionSetList = document.getElementById("questions");
	var add_question = document.getElementById("add_question");
	var arr = [];
	var temp ="";
  var default_question_text = default_question.innerHTML;
	function defaultQuestion(){
		var mdiv = document.createElement("div");
		mdiv.className = "questions col-4";
		mdiv.innerHTML=default_question_text;
		return mdiv;
	}
  	function addQuestion() {
		questionSetList.appendChild(defaultQuestion());
	}
	function submitQuestion() {
    arr = [];
		var main_div_node = questionSetList.getElementsByClassName("questions");
		var count = main_div_node.length;
		for (var i = 0; i < count; i++) {
      var cur_ques = main_div_node[i].getElementsByTagName('div')[0].getElementsByTagName("textarea")[0].value;
			var cur_options = main_div_node[i].getElementsByClassName("options_class");
			//alert(cur_ques);
			var curArr = {};
			curArr.question = cur_ques;
      curOptArr = [];
			for (var j = 0; j < cur_options.length; j++) {
        var tempoption = {};
        var temp_opt = cur_options[j].getElementsByClassName('options_supplied')[0].value;
        var temp_img = cur_options[j].getElementsByClassName('options_img_supplied')[0].value;
        tempoption.option_text = temp_opt;
        tempoption.option_image = temp_img;
				curOptArr[j] = tempoption;
			}
			curArr.options = curOptArr;
			arr[i] = curArr;
		}
		temp = JSON.stringify(arr);
    if(arr.length == 0){
      alert("No questions");
      return;
    }
    for (var i = 0; i < arr.length; i++) {
      if(arr[i].options.length == 0){
        alert("No Options for some questions");
        return;
      }
    }
    console.log(">>>>");
    console.log(temp);
		sendToDB(temp);

	}
  	function change(v){
  		var node = v;
  		var val = node.value;
  		var form = node.parentNode;
      	switch(val){
        case 'add':
        var option_div = document.createElement("div");
        option_div.className = " options_class col-12";
        option_div.style.padding = 0;
        var cc = document.createElement("input");
        var cc_img = document.createElement("img");
        var cc_file= document.createElement('input');
        var div_loader = document.createElement('div');
        div_loader.innerHTML='l';
        div_loader.className = "col- img_bar";
        div_loader.style.backgroundColor = 'green';
        div_loader.style.display = 'none';
        div_loader.style.textAlign = 'center';
        div_loader.style.color = 'white';
        cc_file.type = 'file';
        cc_file.onchange = submitfile;
        cc_file.style.display = 'none';
        cc_file.style.visibility = 'hidden';
        cc_img.alt = 'attach a photo';
        cc.name='options_supplied';
        cc.placeholder="Option";
        cc.className = "col-12 options_supplied";
        cc.style.marginLeft = 0;
        cc_img.className = "col-5 col-offset-7 options_img_supplied";
        cc_img.style.padding = 0;
        cc_img.style.backgroundColor = 'white';
        cc_img.onclick = browseafter;
        option_div.appendChild(cc);
        option_div.appendChild(cc_file);
        option_div.appendChild(cc_img);
        option_div.appendChild(div_loader);
        form.appendChild(option_div);
        break;
        case 'remove':
        try{
        	var cc = form.getElementsByClassName("options_class").length - 1;
	        var rm = form.getElementsByClassName("options_class")[cc];
	        form.removeChild(rm);
        }catch(e){
        	alert("No options left");
        }
        break;
        case 'remove_question':
        var pn = form.parentNode;
        pn.removeChild(form);

        break;
        default:
        //alert(val+"");
        break;
      }
    }
    var trap = "<?php echo $_GET['access_code']; ?>";
    function sendToDB(str){
    	var ajax;
    	try{
    		ajax = new XMLHttpRequest();
         console.log("working");
    	}catch(e){
    		alert("Only Standardized used");
    	}
    	ajax.onreadystatechange = function(){
    		if(ajax.readyState == 4){
          console.log(ajax.responseText);
          document.getElementById("result").innerHTML = ajax.responseText;
          eval(ajax.responseText);
    		}
    	}

    	ajax.open("GET", "process.php?form="+str+"&access_code="+trap, true);
    	ajax.send(null);

    }
    function submitfile() {
      console.log(">>>>");
      var pNode = this.parentNode;
      console.log(pNode.id);
      //var f = pNode.getElementsByClassName('pic');
      var f = this.files[0];
      var formd = new FormData();
      formd.append('file_key', f);
      console.log(formd);
      var imgdir = this.nextElementSibling;
      var bar = imgdir.nextElementSibling;
      if(f.type == 'image/jpeg' || f.type == 'image/png'){
        sendimage(formd, imgdir, bar);
        imgdir.style.display ='block';
      }else{
        imgdir.alt = "Invalid picture file";
        imgdir.style.display ='block';
      }
      console.log();


    }
    function sendimage(formd, imgdir, bar){
        var ajax;
        try{
          ajax = new XMLHttpRequest();
           console.log("working");
        }catch(e){
          alert("Only Standardized used");
        }
        ajax.onreadystatechange = function(){
          if(ajax.readyState == 4){
              //console.log(ajax.responseText);
              //document.getElementById("result").innerHTML += ajax.responseText+"<br>";
              var result = JSON.parse(ajax.responseText);
              imgdir.src = result.thumbnail;
              imgdir.value = result.original;
              imgdir.style.display = 'block';
              bar.style.display = 'none';


          }
        }
        ajax.upload.addEventListener('progress', function(e){
          imgdir.style.display = 'none';
          bar.style.display = 'block';
          bar.style.width = ((e.loaded/e.total * 100).toFixed(1)+'%');
          bar.innerHTML = ((e.loaded/e.total * 100).toFixed(1)+'%');
          console.log(bar.style.width);
        } ,false);
          //var document.getElementById("myfile");
        ajax.open("POST", "./php_check/process_image.php", true);
        ajax.send(formd);

      }
    function browseafter(val){
      console.log(val);
      this.previousElementSibling.click();

    }

</script>
