<?php 
    if(!isset($_GET['s'])){
    $_SESSION['error_message'] = "Invalid access code";
    header("location: ./../php_check/errorpage.php");
    return;
  }
  if(count($_GET['s'])==""){
    $_SESSION['error_message'] = "empty access code";
    header("location: ./../php_check/errorpage.php");
    return;
  }
  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/main.css">
    <link rel="stylesheet" href="./poll_results.css">
</head>
<body>
	
    <div class="col-12 nav-bar">
        <div class="col-5 search" id="search">
            <?php echo $_GET["s"]; ?>
        </div>
        <div class="col-7">
                <input type="text" name="s" placeholder="Access Code" class="col-9 main_search_field" >
                <input type="submit" name="main_submit" value="Find" class="col-3 mbutton" onclick="searchPoll()">
        </div>
    </div>
    <div class="col-12" id="results" style="border-width: 0;" >
        <div class="col-8  col-offset-4 header">Poll Results</div>
        <div id="result_list">
            
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    function loadmyvote(url_s){
        var temp = document.querySelector('#result_list');
        var search = document.getElementById('search');
        search.innerHTML = url_s;
        if(url_s.length==0){
            var t = alert("No search Value");
            return false;
        }
        temp.innerHTML = "loading..";
        var ajax;
        try{
            ajax = new XMLHttpRequest();
        }catch(e){
            alert("Only Standardized used");
        }
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){

                console.log(ajax.responseText);
                
                var tempLink
                var tempdiv = "<div class='col-12' >";
                const voteList =JSON.parse(ajax.responseText);
                if(voteList.length==0){
                    alert("No Results");
                    return;
                }
                temp.innerHTML = "";
                for (var i = 0; i < voteList.length; i++) {
                    tempLink = "./../poll?access_code="+voteList[i].survey_accesscode;
                    var tempdiv = '<a href="'+tempLink+'"> <div class="col-12 poll_item">';
                    tempdiv += voteList[i].survey_title + "   ("+ voteList[i].survey_accesscode +")";
                    tempdiv += "</div></a>";
                    temp.innerHTML  += tempdiv;

                }
            }
        }
        
        ajax.open("GET", "./Results.php?s="+url_s, true);
        ajax.send(null);
    }
    var main_search_field = document.querySelector("input.main_search_field");
    main_search_field.onkeyup = (e)=>{
                        if(e.keyCode==13){
                            loadmyvote(e.target.value);
                        }
    }
    var searchPoll = ()=>{
        loadmyvote(document.querySelector("input.main_search_field").value);
        return false;
    }
    loadmyvote(<?php echo json_encode($_GET["s"]); ?>);
</script>
