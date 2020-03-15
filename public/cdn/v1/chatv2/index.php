<!doctype html>
<html>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<head>
<meta charset="utf-8">
<title>Чат</title>

<link href="css/style_frontend.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="neiros__btn_block" >
<div class="neiros__out_block neiros__slideUp" >
<div class="neiros__text_block">Перезвоним за 8 секунд!</div>

<div id="neiros__chat_btn" class="neiros__btn_round neiros__fadeIn">
	<div class="neiros__toltip neiros__fadeIn">Написать в чат</div>
    <img src="images/icons/icon-chat.png" alt="">
</div>
 
<div id="neiros__phone_btn" class="neiros__btn_round neiros__fadeIn">
<div class="neiros__toltip neiros__fadeIn" >Обратный звонок</div>
    <img src="images/icons/icon-phone.png" alt="">
</div>    

<div id="neiros__lid_btn" class="neiros__btn_round neiros__fadeIn">
<div class="neiros__toltip neiros__fadeIn" >Оставить заявку</div>
    <img src="images/icons/icon-lid.png" alt="">
</div>

<div id="neiros__geo_btn" class="neiros__btn_round neiros__fadeIn">
	<div class="neiros__toltip neiros__fadeIn" >Наши<br>
адреса</div>
    <img src="images/icons/icon-geo.png" alt="">
</div>  

<div id="neiros__socialpng_btn" class="neiros__btn_round neiros__fadeIn">
<div class="neiros__toltip neiros__fadeIn" >Ответим в соц сетях</div>
    <img src="images/icons/icon-socialpng.png" alt="">
</div>
<div class="neiros__botoom_border"></div>
<div class="neiros__botoom_btn"><span>Отмена</span></div>
</div>  
</div>  

<div id="neiros__chat_start" class="neiros__start_btn neiros__fadeIn">
<img src="images/agent.png" alt="">
</div>
<div id="neiros__chat_hello_window" class="neiros__fadeIn">
<img class="neiros__closet__hello_window" src="images/icons/closet-icon-modal.PNG" alt="">
    <div class="neiros__operator__name">Виктория</div>
    <div class="neiros__operator__dol">Консультант</div>
    <div class="neiros__operator__text">
    	Здравствуйте! Готова Вам помочь.
Напишите, если у вас возник вопрос. 
    </div>
    <div class="neiros__open__chart">ответить</div>
</div>
<div id="neiros__chat_before_iframe" class="neiros__fadeIn" style="display:none;">


</div>
 
<script>
var  window_wight = window.screen.availWidth;
function addIframe(){
	var  window_wight = window.screen.availWidth;
	if(window_wight <= 450){
	divise = 'mobile';
	}
else{
	divise = 'desctop';
	}	
list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="chat.html?'+divise+'"  ></iframe>'
	
	}
function addIframe_new(type){
	
		var  window_wight = window.screen.availWidth;
	if(window_wight <= 450){
	divise = 'mobile';
	}
else{
	divise = 'desctop';
	}	
	
list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="chat.html?'+divise+'&type='+type+'"  ></iframe>'
	
	
   	var elem = document.querySelectorAll(".neiros__btn_round");
   	for (var i = 0; i < elem.length; i++) {
      elem[i].classList.remove("visionthis");
		}

	div = document.querySelector("#neiros__btn_block");
	classes = div.classList; 
  	classes.remove("visabled");
	
list = document.querySelector("#neiros__chat_before_iframe");
	list.style.display = 'block';
	list = document.querySelector("#neiros__chat_hello_window");
	list.style.display = 'none';	
	}

 function ready() {

var matches;
(function(doc) {
   matches =
      doc.matchesSelector ||
      doc.webkitMatchesSelector ||
      doc.mozMatchesSelector ||
      doc.oMatchesSelector ||
      doc.msMatchesSelector;
})(document.documentElement);

/*выбор услуги*/	 
mass = [];
mass.forEach.call( document.querySelectorAll('.neiros__all-servises li'), function(el) { el.addEventListener('click', function() {
	div = document.querySelector("#neiros__panel_widget .neiros__active_servis");
	classes = div.classList; 
  	classes.remove("neiros__active_servis");
	classes = el.classList; 
  	classes.add("neiros__active_servis");
	return false;

 }, false);
})

if(window_wight >= 450){
/*Описание услуги*/
mass.forEach.call( document.querySelectorAll('.neiros__btn_round'), function(el) { el.addEventListener('mouseover', function() {
this.querySelector(".neiros__toltip").classList.add("visablethis");

 }, false);
})

mass.forEach.call( document.querySelectorAll('.neiros__btn_round'), function(el) { el.addEventListener('mouseout', function() {
this.querySelector(".neiros__toltip").classList.remove("visablethis");

 }, false);
})



/*вывод услуг*/	 
mass.forEach.call( document.querySelectorAll('#neiros__chat_start'), function(el) { el.addEventListener('mouseover', function() {
   	var elem = document.querySelectorAll(".neiros__btn_round");
   	for (var i = 0; i < elem.length; i++) {
      elem[i].classList.add("visionthis");
		}
	list = document.querySelector("#neiros__chat_hello_window");
	list.style.display = 'none';
    div = document.querySelector(".neiros__start_btn");
 	classes = div.classList; 
  	classes.add("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'none';	
 }, false);
})
	}
else{
	
	document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__fadeIn");
	document.querySelector("#neiros__chat_before_iframe").classList.add("neiros__slideUp");

	
	
	
	mass.forEach.call( document.querySelectorAll('#neiros__chat_start'), function(el) { el.addEventListener('click', function() {
   	var elem = document.querySelectorAll(".neiros__btn_round");
   	for (var i = 0; i < elem.length; i++) {
      elem[i].classList.remove("neiros__fadeIn");
		}
	div = document.querySelector("#neiros__btn_block");
	classes = div.classList; 
  	classes.add("visabled");	
	list = document.querySelector("#neiros__chat_hello_window");
	list.style.display = 'none';
    div = document.querySelector(".neiros__start_btn");
 	classes = div.classList; 
  	classes.add("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'none';	
 }, false);
})
	
	
	}	






/*mass.forEach.call( document.querySelectorAll('#neiros__chat_start'), function(el) { el.addEventListener('mouseout', function() {
   	var elem = document.querySelectorAll(".neiros__btn_round");
   	for (var i = 0; i < elem.length; i++) {
      elem[i].classList.remove("visionthis");
		}
 }, false);
})*/



/*Открыть чат*/
mass.forEach.call(
 document.querySelectorAll('.neiros__open__chart'), function(el) { el.addEventListener('click', function() {
 	div = document.querySelector(".neiros__start_btn");
 	classes = div.classList; 
  	classes.add("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'none';
	addIframe_new('chat');
	list = document.querySelector("#neiros__chat_before_iframe");
	list.style.display = 'block';
	list = document.querySelector("#neiros__chat_hello_window");
	list.style.display = 'none';
	return false;

 }, false);
}
)


mass.forEach.call(
 document.querySelectorAll('#neiros__chat_btn'), function(el) { el.addEventListener('click', function() {
 	addIframe_new('chat');
 }, false);
}
)

mass.forEach.call(
 document.querySelectorAll('#neiros__phone_btn'), function(el) { el.addEventListener('click', function() {
addIframe_new('phone');
 }, false);
}
)

mass.forEach.call(
 document.querySelectorAll('#neiros__lid_btn'), function(el) { el.addEventListener('click', function() {
addIframe_new('lidi');
 }, false);
}
)

mass.forEach.call(
 document.querySelectorAll('#neiros__geo_btn'), function(el) { el.addEventListener('click', function() {
addIframe_new('geo');
 }, false);
}
)

mass.forEach.call(
 document.querySelectorAll('#neiros__socialpng_btn'), function(el) { el.addEventListener('click', function() {
addIframe_new('social');
 }, false);
}
)


mass.forEach.call(
 document.querySelectorAll('.neiros__botoom_btn span'), function(el) { el.addEventListener('click', function() {
     div = document.querySelector(".neiros__start_btn");
 	classes = div.classList; 
  	classes.remove("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'block';	
	div = document.querySelector("#neiros__btn_block");
	classes = div.classList; 
  	classes.remove("visabled");
	
 }, false);
}
)



/*Закрыть приветствующее окно*/
mass.forEach.call( document.querySelectorAll('.neiros__closet__hello_window'), function(el) { el.addEventListener('click', function() {
	list = document.querySelector("#neiros__chat_hello_window");
	list.style.display = 'none';
	return false;

 }, false);
})



document.addEventListener('click', function(e) {
   if ( matches.call( e.target, '.neiros__start_btn_show') ) {
	   
	 window.setTimeout(funct,1000)  
	 function funct(){
   	var elem = document.querySelectorAll(".neiros__btn_round");
   	for (var i = 0; i < elem.length; i++) {
      elem[i].classList.remove("visionthis");
		}

    div = document.querySelector(".neiros__start_btn");
 	classes = div.classList; 
  	classes.remove("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'block';	
	}
	return false;
   }
}, false);






document.addEventListener('click', function(e) {
   if ( matches.call( e.target, '.neiros__closet-icon-modal, .neiros__closet-icon-modal img') ) {
	div = document.querySelector(".neiros__start_btn");
    classes = div.classList; 
  	classes.remove("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'block';
	list = document.querySelector("#neiros__chat_before_iframe");
	list.style.display = 'none';
	return false;
   }
}, false);

/*
if(window_wight <= 450){
	divise = 'mobile'
	}
else{
	divise = 'desctop'
	}	
list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="chat.html?'+divise+'"  ></iframe>';*/
	 }	
document.addEventListener("DOMContentLoaded", ready);	 
</script>

</body>
</html>