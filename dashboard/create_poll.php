<?php
  session_start();
  if(isset($_SESSION['user_id'])){
    if($_SESSION['logged_in'] != 'true'){
      header("location: index.php");
    }
  }else{
        header("location: index.php");
    }
    $survey_name = $_GET['survey_name'];
    // var_dump(($_GET));
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Poll Creator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/main.css">
    <link rel="stylesheet" href="./../css/icon.min.css">
    <link rel="stylesheet" href="./create_poll.css">
  <style type="text/css">
      

    
    </style>
  </head>
  <body>
    <div class="col-6 col-offset-6 note-pane">
      Errr
    </div>
    <div id="add_question" onclick="submitPolls()" class=" col-2 submit_polls">
      Submit Poll(s)
    </div>
    <div id="main_body" style="transition: 2s;">
      <div class="col-12 nav-bar">
        <span class="col-2 header-menu-toggle">
            <i class="icono-hamburger" style="font-size: 12px; color: #ffdd00;"></i>
        </span>

        <div class="col-8 main-nav-wrap" id="main-nav-wrap">
            <ul class="main-navigation">
                <a href="#" onclick="addPoll()"><li class="current">Add New Poll</li></a>
                <a href="#create_survey"><li>Modify Access Code</li></a>
                <a href="./"><li>Exit</li></a>
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
      <div class="row">
        <div class="col-12 survey_title">
        <?php echo $survey_name; ?>
        </div>
      </div>
      <div class="row">
            <div id="questions" class="col-12">
              <div id="default_question" class="col-4 questions">
                <div class="col-12 container_div" style="position: relative;">
                  <textarea name='question_asked' placeholder="Question" class="col-12 textarea_class"></textarea>
                </div>

                <button class="mbut" id="add" value="add" onclick="change(this)" style="">
                  <i class="icono-plusCircle" style="font-size: 12px; color: #0f0;"></i>
                </button>
                <button class="mbut" id="remove" value="remove" onclick="change(this)">
                  <i class="icono-crossCircle" style="font-size: 12px; color: #00f;"></i>
                </button>
                <button class="mbut" id="remove_question" value="remove_question" onclick="change(this)">
                  <i class="icono-trash" style="font-size: 12px; color: #f00;"></i>
                </button>
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
	var mainPollData ="";
  var default_question_text = default_question.innerHTML;
  var survey_name = <?php print(json_encode($survey_name) ); ?>;
  var start_date = <?php print(json_encode($_GET['start_date']) ); ?>;
  var start_time = <?php print(json_encode($_GET['start_time']) ); ?>;
  var end_date = <?php print(json_encode($_GET['end_date']) ); ?>;
  var end_time = <?php print(json_encode($_GET['end_time']) ); ?>;
  var mFormDataList = [];
  var mFileBarList = [];
  var mURLList = [];
  var urlCounter = 0;
  var survey_no = 0;

	function defaultQuestion(){
		var mdiv = document.createElement("div");
		mdiv.className = "questions col-4";
		mdiv.innerHTML=default_question_text;
		return mdiv;
	}


  function addPoll() {
		questionSetList.appendChild(defaultQuestion());
	}


	function submitPolls() {
    
    
    mFormDataList = [];
    mFileBarList = [];
    mURLList =[];
    arr = [];
    urlCounter = 0;

		var main_div_node = questionSetList.getElementsByClassName("questions");
		var count = main_div_node.length;
    if(count==0){
      displayNotePane("No questions");
      return;
    }
		for (var i = 0; i < count; i++) {
      var cur_ques = main_div_node[i].getElementsByTagName('div')[0].getElementsByTagName("textarea")[0].value;
			var cur_options = main_div_node[i].getElementsByClassName("options_class");
      if(cur_ques.length == 0){
        main_div_node[i].getElementsByTagName('div')[0].getElementsByTagName("textarea")[0].focus();
        displayNotePane("Question can not be empty");
        return;
      }

			//displayNotePane(cur_ques);
			var curArr = {};
			curArr.question = cur_ques;
      curOptArr = [];
      if(cur_options.length == 0){
        main_div_node[i].getElementsByTagName('div')[0].getElementsByTagName("textarea")[0].focus();
        displayNotePane("No Options for some questions");
        return;
      }
			for (var j = 0; j < cur_options.length; j++) {
        var tempoption = {};
        var temp_opt = cur_options[j].getElementsByClassName('options_supplied')[0].value;
        var temp_img = cur_options[j].getElementsByClassName('options_img_supplied').length>0;
        if(temp_img){
          var mFormData = new FormData();
          var f = cur_options[j].getElementsByClassName('options_img_supplied')[0].previousElementSibling.files[0];
          mFormData.append('file_key', f);
          mFormDataList.push(mFormData);
          mFileBarList.push(cur_options[j].getElementsByClassName('options_img_supplied')[0].nextElementSibling);
        }
        if(temp_opt.length == 0){
          cur_options[j].getElementsByClassName('options_supplied')[0].focus();
          displayNotePane("An Option is empty");
          return;
        }
        tempoption.option_text = temp_opt;
        tempoption.option_image = temp_img;
				curOptArr[j] = tempoption;
			}
			curArr.options = curOptArr;
			arr[i] = curArr;
		}
		mainPollData = arr;
    createPoll();
    // //console.log(mainPollData);
    // //console.log(mFormDataList);
		// sendToDB(temp);
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
        
        
        var cc_file= document.createElement('input');
        
        
        cc_file.type = 'file';
        cc_file.onchange = prewviewFile;
        cc_file.style.display = 'none';
        cc_file.style.visibility = 'hidden';
        

        
        option_div.appendChild(inputIconGen());
        option_div.appendChild(cc_file);
        // option_div.appendChild(imgGen());
        // option_div.appendChild(fileLoaderGen());
        form.appendChild(option_div);
        break;
      case 'remove':
        try{
        	var cc = form.getElementsByClassName("options_class").length - 1;
          var rm = form.getElementsByClassName("options_class")[cc];
          form.removeChild(rm);
        }catch(e){
        	displayNotePane("No options left");
        }
        break;
      case 'remove_question':
        var pn = form.parentNode;
        pn.removeChild(form);
        break;
      default:
        //displayNotePane(val+"");
        break;
    }
  }
  

    function sendToDB(str){
    	var ajax;
    	try{
    		ajax = new XMLHttpRequest();
         console.log("working");
    	}catch(e){
    		displayNotePane("Only Standardized used");
    	}
    	ajax.onreadystatechange = function(){
    		if(ajax.readyState == 4){
          console.log(ajax.responseText);
          if(ajax.responseText==200){
            window.open("./../poll?access_code="+survey_no, "_self")
          }
          // document.getElementById("result").innerHTML = ajax.responseText;
          // eval(ajax.responseText);
    		}
    	}

    	ajax.open("GET", "./process.php?poll="+str+"&survey_no="+survey_no, true);
    	ajax.send(null);

    }


    function prewviewFile() {
      //console.log(">>>>");
      var pNode = this.parentNode;
      //console.log(pNode.id);
      //var f = pNode.getElementsByClassName('pic');
      var f = this.files[0];
      if( !(f.type == 'image/jpeg' || f.type == 'image/png' || f.type == 'image/gif') ){
        displayNotePane("Unkown Format");
        return;
      }
      var img = pNode.getElementsByTagName("img");
      var bar = pNode.getElementsByClassName("img_bar");
      if(img.length>0){
        pNode.removeChild(img[0]);
        pNode.removeChild(bar[0]);
      }
      var imagePanel = imgGen();
      var imageLoader = fileLoaderGen();
      imagePanel.src = URL.createObjectURL(f);
      this.parentNode.appendChild(imagePanel);
      //console.log(this.parentNode.getElementsByTagName("img")[0]);
      this.parentNode.appendChild(fileLoaderGen());
      
      return;
      var formd = new FormData();
      formd.append('file_key', f);
      //console.log(formd);
      var imgdir = this.nextElementSibling;
      var bar = imgdir.nextElementSibling;
      if(f.type == 'image/jpeg' || f.type == 'image/png'){
        // sendimage(formd, imgdir, bar);
        imgdir.style.display ='block';
      }else{
        imgdir.alt = "Invalid picture file";
        imgdir.style.display ='block';
      }
    }


    function sendimage(dform, bar, index){
      
      var ajax;
      try{
        ajax = new XMLHttpRequest();
         //console.log("working");
      }catch(e){
        displayNotePane("Only Standardized used");
      }
      ajax.onreadystatechange = function(){
        if(ajax.readyState == 4){
            //console.log(ajax.responseText);
            var result = JSON.parse(ajax.responseText);
            
            //console.log(result);
            //console.log(bar.previousElementSibling.previousElementSibling.previousElementSibling.lastElementChild);
            if(result.result_code==200){
              bar.previousElementSibling.previousElementSibling.previousElementSibling.lastElementChild.className = "icono-check attach_icon";
              mURLList[index] = result.location;
              bar.style.display = 'none';
              urlCounter++;
              if(urlCounter==mFileBarList.length){
                sendToDB(fuseUrl());
              }
            }
              
            
        }
      }
      ajax.upload.addEventListener('progress', function(e){
        bar.style.display = 'block';
        bar.style.width = ((e.loaded/e.total * 100).toFixed(1)+'%');
        bar.innerHTML = ((e.loaded/e.total * 100).toFixed(1)+'%');
        
      } ,false);
        //var document.getElementById("myfile");
      ajax.open("POST", "./process.php", true);
      ajax.send(dform);

    }


    function browseafter(val){
      //console.log(val);
      try{
        this.previousElementSibling.click();
        this.parentNode.nextElementSibling.click();
      }catch(e){

      }
    }
    var iconGen = ()=>{
      var icon = document.createElement("i");
      icon.className = "icono-paperClip attach_icon";
      icon.onclick = browseafter;
      return icon;
      // <i class="icono-plusCircle" style="font-size: 12px; color: #0f0;"></i>
    }
    var optioninput = ()=>{
      var cc = document.createElement("input");
      cc.name='options_supplied';
      cc.placeholder="Option";
      cc.className = "col-12 options_supplied";
      cc.style.marginLeft = 0;
      return cc;
    }
    var inputIconGen = ()=>{
      var mdiv = document.createElement("div");
      mdiv.className = "col-12 input_icon";
      mdiv.appendChild(optioninput());
      mdiv.appendChild(iconGen());
      return mdiv;
    }
    var imgGen = ()=>{
      var cc_img = document.createElement("img");
      cc_img.alt = 'attach a photo';
          
      cc_img.className = "col-5 col-offset-7 options_img_supplied";
      cc_img.style.padding = 0;
      cc_img.style.backgroundColor = 'white';
      // cc_img.onclick = browseafter;
      cc_img.onload = (e) => {
        URL.revokeObjectURL(this.src);
        var temp = e.target.parentNode.firstElementChild.lastElementChild;
        temp.className = "icono-file attach_icon";
        temp.style.color = "green";
      }
      return cc_img;
      // <i class="icono-plusCircle" style="font-size: 12px; color: #0f0;"></i>
    }
    var fileLoaderGen = ()=>{
      var div_loader = document.createElement('div');
      div_loader.innerHTML='l';
      div_loader.className = "col- img_bar";
      div_loader.style.backgroundColor = 'green';
      div_loader.style.display = 'none';
      div_loader.style.textAlign = 'center';
      div_loader.style.color = 'white';
      return div_loader;
    }
    var createPoll = ()=>{
      
      var mForm = new FormData();
      mForm.append('survey_name', survey_name);
      mForm.append('start_date', start_date);
      mForm.append('start_time', start_time);
      mForm.append('end_date', end_date);
      mForm.append('end_time', end_time);
      var ajax;
      try{
        ajax = new XMLHttpRequest();
      }catch(e){
        displayNotePane("Only Standardized used");
      }
      ajax.onreadystatechange = function(){
        if(ajax.readyState == 4){
          
          console.log(ajax.responseText);
          var result = JSON.parse(ajax.responseText);
            if(result.result_code==200){
              survey_no =result.survey_no;
              sendAllFiles();
            }else{
              alert("Poll Creation Failed, Try Again Later");
            }
        }
      }
      ajax.upload.addEventListener('progress', function(e){
        displayNotePane((e.loaded/e.total * 100).toFixed(1)+'%');
      } ,false);
        //var document.getElementById("myfile");
      ajax.open("POST", "./process.php", true);
      ajax.send(mForm);
    }
    var sendAllFiles = ()=>{
      console.log("working  333");
      if(mFormDataList.length==0){
        sendToDB(JSON.stringify(mainPollData));
      }else{
        for (var i = 0; i < mFormDataList.length; i++) {
          sendimage(mFormDataList[i], mFileBarList[i], i);     
        }
      }
      
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
      document.body.scrollIntoView();
    }
    var fuseUrl = ()=>{
      var l_counter = 0;
      for (var i = 0; i < mainPollData.length; i++) {
        for (var j = 0; j < mainPollData[i].options.length; j++) {
          if(mainPollData[i].options[j].option_image){
            mainPollData[i].options[j].option_image = mURLList[l_counter++];
          }
        }
      }
      return JSON.stringify(mainPollData);
    }
</script>
