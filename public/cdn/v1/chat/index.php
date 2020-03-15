<!doctype html>
<html>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<head>
<meta charset="utf-8">
<title>Чат</title>
<link href="css/style_frontend.css" rel="stylesheet" type="text/css">
</head>

<body>

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

/*Открыть чат*/
mass.forEach.call(
 document.querySelectorAll('.neiros__start_btn, .neiros__open__chart'), function(el) { el.addEventListener('click', function() {
 	div = document.querySelector(".neiros__start_btn");
 	classes = div.classList; 
  	classes.add("neiros__start_btn_show");
	list = document.querySelector(".neiros__start_btn img");
	list.style.display = 'none';
	list = document.querySelector("#neiros__chat_before_iframe");
	list.style.display = 'block';
	list = document.querySelector("#neiros__chat_hello_window");
	list.style.display = 'none';
	return false;

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
   if ( matches.call( e.target, '.neiros__start_btn_show, .neiros__closet-icon-modal, .neiros__closet-icon-modal img') ) {
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

var  window_wight = window.screen.availWidth;
if(window_wight <= 450){
	divise = 'mobile'
	}
else{
	divise = 'desctop'
	}	
list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="chat.html?'+divise+'"  ></iframe>';
	 }	
document.addEventListener("DOMContentLoaded", ready);	 
</script>

</body>
</html>