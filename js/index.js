var tNav = document.querySelector("div.nav-bar");
var flexslider = document.querySelectorAll("div.flexslider .hosp_container");
var hos_pointer = document.querySelectorAll(".hos_pointer");

function scrollTerm(e) {
	var tHome = document.querySelector("div#about");
	var tSections = document.querySelectorAll("body .section");
	var tMenu = document.querySelectorAll(".main-navigation a li");
	for (var i = 0; i < tSections.length; i++) {
		if(window.pageYOffset+ tNav.clientHeight*2 > tSections[i].offsetTop && window.pageYOffset+tNav.clientHeight*2 < tSections[i].offsetTop+tSections[i].clientHeight){
				for (var j = 0; j < tMenu.length; j++) {
					if(i==j){
						tMenu[j].className = "current";
					}else{
						tMenu[j].className = "";
					}
					
				}
			}
		
	}
	// console.log(window.pageYOffset +" " + (tHome.offsetTop) 	);
	

}
var myTop = document.getElementById("top");
function replacePage(){
	document.querySelector("div#home").style.marginTop = tNav.clientHeight+"px";
	var mainCon = document.querySelectorAll("div.main-container");
	for (var i = 0; i < mainCon.length; i++) {
		mainCon[i].style.paddingTop = (tNav.clientHeight) +"px";
	}
	for (var i = 1; i < flexslider.length; i++) {
		flexslider[i].style.display = "none";
	}
	
	'use strict'
	for (let i = 0; i < hos_pointer.length; i++) {
		if(i==0){
			hos_pointer[i].classList.add("hosp_pointer_current");
		}
		hos_pointer[i].addEventListener("click", () => {
				swapHosp(i);
		});

		
	}
	init();
}
var swapHosp = (ii)=>{
	for (var i = 0; i < flexslider.length; i++) {
		hos_pointer[i].classList.remove("hosp_pointer_current");
		if(i==ii){
			flexslider[i].style.display = "block";
			hos_pointer[i].classList.add("hosp_pointer_current");
			continue;
		}
		flexslider[i].style.display = "none";
	}
}
function h_login() {
	var request;
	var header_title = document.getElementById("header_title");
	var h_name = document.getElementById("h_name");
	var h_password = document.getElementById("h_password");
	var all = true;
	if(!h_name.value.length > 0){
		all = all && false;
		h_name.focus();
		return;
	}
	if( h_password.value.length < 8 ){
		all = all && false;
		h_password.focus();
		return;
	}
	var formData = new FormData();
	formData.append('h_name', h_name.value);
	formData.append('h_password', h_password.value);
	header_title.innerHTML = "loading....";
    header_title.style.backgroundColor = "#00ff0090";
	if (window.XMLHttpRequest) {
          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
      } else {
          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
      }
      request.onreadystatechange = function() {
          if (request.readyState == 4 && request.status == 200) {
              console.log(request.responseText);
              if(request.responseText === "Invalid Username"){
              	header_title.innerHTML = request.responseText;
              	header_title.style.backgroundColor = "#ff000090";
              	h_name.focus();
              	// alert(request.responseText);
				return;
              }else if(request.responseText === "Incorrect password or username"){
              	header_title.innerHTML = request.responseText;
              	header_title.style.backgroundColor = "#ff000090";
              	h_password.focus();
              	// alert(request.responseText);
              	return;
              }else{
              	eval(request.responseText);
              }

          }
      }
      request.open("POST", "./php_files/login_process.php", true);
      request.send(formData);
}
