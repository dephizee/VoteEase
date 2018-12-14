<?php 
	if(isset($_POST['submit'])){
		//echo var_dump($_FILES['pic']);
		foreach ($_FILES['pic']['tmp_name'] as $key => $value) {
			echo var_dump($value);
			
		}
		
		// echo "<br>";
		// $temp = $value['size']/1000;
		// echo $temp."kb";
		// echo "<br>";
		// echo $value['type'];
		// echo "<br>";
		// echo $value['error'];
		// echo "<br>";
		// echo basename($value['type']);
		// echo "<br>";


	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div id="main">
		<div>
			<input type="file" class="pic" value="+" id="one" style="display: none; visibility: hidden;">
			<img src="./temp_photo_folder/000.jpg" id="photo" style="width: 100px; height: auto;" onclick="browse(this)" >
		</div>
		<div>
			<input type="file" class="pic" value="+" id="two" style="display: none; visibility: hidden;">
			<img src="./temp_photo_folder/000.jpg" id="photo" style="width: 100px; height: auto;" onclick="browse(this)">
		</div>
	</div>
	
	<div id="result">
		
	</div>
	<button id="all_image" onclick="listphotolist()"> show All images</button>

</body>
</html>
<script type="text/javascript">
var file1 = document.getElementById("one");
file1.onchange = submitfile;
var file2 = document.getElementById("two");
file2.onchange = submitfile;
	function submitfile() {
		var pNode = this.parentNode;
		console.log(pNode.id);
		//var f = pNode.getElementsByClassName('pic');
		var f = this.files[0];
		var formd = new FormData();
		formd.append('file_key', f);
		console.log(formd);
		var imgdir = this.nextElementSibling;
		sendimage(formd, imgdir);
		
	}
	function sendimage(formd, imgdir){
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
	          document.getElementById("result").innerHTML += ajax.responseText+"<br>";
	          imgdir.src = ajax.responseText;
    		}
    	}
      	//var document.getElementById("myfile");
    	ajax.open("POST", "./php_check/process_image.php", true);
    	ajax.send(formd);

    }
    function listphotolist(){
    	var photolist = document.getElementById('main').getElementsByTagName('div');
    	for(var i = 0; i< photolist.length; i++){
    		console.log(">>> "+ photolist[i].getElementsByTagName('img')[0].src);
    	}
    }
    function browse(val){
    	console.log(val);
    	val.previousElementSibling.click();

    }
</script>