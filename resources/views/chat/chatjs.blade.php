<?php
$url_logo='https://cloud.neiros.ru/cdn/v1/chatv2/images/agent.png';

if(strlen($widget->logo)>2){

    $url_logo='https://cloud.neiros.ru/user_upload/'.$widget->my_company_id.'/'.$widget->logo;
}

function num2word($num, $words)
{
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1: {
            return($words[0]);
        }
        case 2: case 3: case 4: {
        return($words[1]);
    }
        default: {
            return($words[2]);
        }
    }
}


 ?>



var e = document.createElement("div");
e.className = "neiros_all_container";
e.innerHTML=`<link href="https://cloud.neiros.ru/cdn/v1/chatv2/css/style_frontend.css" rel="stylesheet" type="text/css">

<div id="neiros__messenger_block">
<div class="neiros__messenger_block_vis" style="visibility:hidden;">
    @if(strlen($widget_soc['social_ok_url'])>3)<a class="neiros__widget-link" href="{{$widget_soc['social_ok_url']}}" target="_blank"  onclick="socialclick(6)" >
    <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/messenger/odnoklassniki.svg">
    <span class="tooltiptext button-tooltiptext">Однокласники</span>
    </a> @endif
    @if(strlen($widget_soc['social_fb_url'])>3) <a class="neiros__widget-link" href="{{$widget_soc['social_fb_url']}}" target="_blank"  onclick="socialclick(7)" >
    <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/messenger/icon_facebook.svg">
    <span class="tooltiptext button-tooltiptext">Facebook</span>
    </a>@endif
        @if(strlen($widget_soc['social_tele_url'])>3) <a class="neiros__widget-link" href="{{$widget_soc['social_tele_url']}}" target="_blank"  onclick="socialclick(8)" ><img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/messenger/icon_tg.svg">
    <span class="tooltiptext button-tooltiptext">Telegram</span>
    </a>@endif
        @if(strlen($widget_soc['social_viber_url'])>3)<a class="neiros__widget-link" href="{{$widget_soc['social_viber_url']}}" onclick="socialclick(5)" target="_blank">
    <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/messenger/icon_viber.svg">
    <span class="tooltiptext button-tooltiptext">Viber</span>
    </a>@endif
        @if(strlen($widget_soc['social_vk_url'])>3) <a class="neiros__widget-link" href="{{$widget_soc['social_vk_url']}}" target="_blank"  onclick="socialclick(4)" ><img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/messenger/icon_vk.svg">
    <span class="tooltiptext button-tooltiptext">ВКонтакте</span>
    </a>@endif
   {{-- <a class="neiros__widget-link" href=""><img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/messenger/icon_whatsapp.svg">
    <span class="tooltiptext button-tooltiptext">WhatsApp</span>
    </a>--}}
</div>

</div>
<div id="neiros__messenger_start" class="neiros__start_btn_messenger neiros__fadeIn rotate-reverse-btn" style="z-index: 999; display:none;">

</div>
<div id="neiros__btn_block" >
    <div class="neiros__out_block neiros__slideUp" >
        <div class="neiros__text_block">Перезвоним за {{$widget->callback_timer}} {{num2word($widget->callback_timer, array('секунду', 'секунды', 'секунд'))}}!</div>

        @if($widget->active_chat==1)<div id="neiros__chat_btn" class="neiros__btn_round neiros__fadeIn">
            <div class="neiros__toltip neiros__fadeIn">Написать в чат</div>
            <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/svg/chat_white.svg" alt="">
        </div>@endif

        @if($widget->active_callback==1) <div id="neiros__phone_btn" class="neiros__btn_round neiros__fadeIn">
            <div class="neiros__toltip neiros__fadeIn" >Обратный звонок</div>
            <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/svg/telephone_white.svg" alt="">
        </div>@endif

        @if($widget->active_formback==1)<div id="neiros__lid_btn" class="neiros__btn_round neiros__fadeIn">
            <div class="neiros__toltip neiros__fadeIn" >Оставить заявку</div>
            <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/svg/note_white.svg" alt="">
        </div>@endif

        @if($widget->active_map==1)<div id="neiros__geo_btn" class="neiros__btn_round neiros__fadeIn">
            <div class="neiros__toltip neiros__fadeIn" >Наши<br>
                адреса</div>
            <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/svg/placeholder_white.svg" alt="">
        </div>@endif

        @if($widget->active_social==1)<div id="neiros__socialpng_btn" class="neiros__btn_round neiros__fadeIn">
            <div class="neiros__toltip neiros__fadeIn" >Ответим в соц сетях</div>
            <img src="https://cloud.neiros.ru/cdn/v1/chatv2/images/svg/share_white.svg" alt="">
        </div>@endif
        <div class="neiros__botoom_border"></div>
        <div class="neiros__botoom_btn"><span>Отмена</span></div>
    </div>
</div>

<div id="neiros__chat_start" style="z-index: 9999" class="neiros__start_btn neiros__start_btn_rotate neiros__fadeIn">
    <img src="{{$url_logo}}" alt="" style="border-radius: 50%;">
</div>
<div id="neiros__chat_hello_window" style="z-index: 9999; display:none" class="neiros__fadeIn">
    <img class="neiros__closet__hello_window" src="https://cloud.neiros.ru/cdn/v1/chatv2/images/icons/closet-icon-modal.PNG" alt="">
    <div class="neiros__operator__name"> `+CBU_GLOBAL.config.widget.tip_name_12+`  {{--@if($widget->operator_name=='') Консультант@else{{$widget->operator_name}}@endif--}}</div>
    <div class="neiros__operator__dol">  `+CBU_GLOBAL.config.widget.tip_who_12+` </div>
    <div class="neiros__operator__text">
          `+CBU_GLOBAL.config.widget.tip_mess_12+`    {{--@if($widget->first_message=='') Здравствуйте! Чем могу Вам помочь?@else{{$widget->first_message}}@endif--}}
    </div>
    <div class="neiros__open__chart">ответить</div>
</div>

<?php /*?><div id="neiros__chat_start" class="neiros__start_btn neiros__fadeIn" style="z-index: 999; display:none">
    <img src="https://cloud.neiros.ru/cdn/v1/callback/images/icons/icon-phone.png" alt="">
</div>  <?php */?>

<div id="neiros__callback_start" class="neiros__start_btn_callback " style="z-index: 999; display:none;	width: 68px;
	max-width: 68px !important;max-height: 68px !important;height:68px;border-radius:50%;background: #00B9EE; border: 4px solid #f9feff;right: 65px;bottom: 60px;">
    <img class="no-hover" src="https://cloud.neiros.ru/cdn/v1/callback/images/icons/icon-phone.png" style="width: 30px;margin-left: 15px;margin-top: 15px;" alt="">
    <img class="hover" src="https://cloud.neiros.ru/cdn/v1/callback/images/icons/icon-phone-hover.png" style="width: 30px;margin-left: 18px;margin-top: 18px; display:none" alt="">
</div>

<div id="neiros__chat_before_iframe" class="" style="display:none;">
</div>
<div id="neiros__callback_before_iframe" class="" style="display:none;">
</div>
`, document.body.appendChild(e);

active_chat = 0;
active_callback = 0;
active_formback = 0;
active_map = 0;
active_social = 0;
active__widget = 0;

 @if($widget->active_chat==1)
 active_chat = 1;
 active__widget = active__widget+1;
 @endif
 @if($widget->active_callback==1)
 active_callback = 1;
  active__widget = active__widget+1;
 @endif 
 @if($widget->active_formback==1)
 active_formback = 1;
  active__widget = active__widget+1;
 @endif 
 @if($widget->active_map==1)
  active_map = 1;
   active__widget = active__widget+1;
  @endif
 @if($widget->active_social==1)
 active_social = 1
  active__widget = active__widget+1;
 @endif
 
function socialclick(ids){



var body = 'url=' + encodeURIComponent(JSON.stringify(window.location.href))+'&social='+ids+"&widget=2"+
"&neiros_visit="+neiros_visit+"&site="+CBU_GLOBAL.config.widget.key;
var xhr = new XMLHttpRequest();
xhr.open("POST", 'https://cloud.neiros.ru/api/v1/widget/form/socialclick' , true);

xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.send(body);

}
function hasclass(elem, classname) {    


return elem.classList.contains(classname);}

var  window_wight = window.screen.availWidth;
if(window_wight <= 450){
document.querySelector("#neiros__callback_start").classList.add('neiros__mobile_phone');	
}

function hiddenPreloader(obj){
var  window_wight = window.screen.availWidth;
if(window_wight >= 450){
document.querySelector("#neiros__chat_iframe").classList.add("active");
document.querySelector(".neiros__preloader_container").style.display = 'none';
}
}

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
var e = document.createElement("div");
 widget_callback = 0;
 widget_chat = 0;
 widget_messenger = 0;
time_change=0;
if(CBU_GLOBAL.config.widget.tip_1==1) {


if(CBU_GLOBAL.config.widget.tip_1_osn==1) {

var widget_name = 'callback';

}

}

if((CBU_GLOBAL.config.widget.tip_12==1)||(CBU_GLOBAL.config.widget.tip_1_osn==1)) {


if((CBU_GLOBAL.config.widget.tip_12==1)&&(CBU_GLOBAL.config.widget.tip_1_osn==1)) { 
   time_change = 5
  widget_callback =1;
  widget_chat = 1;
  widget_messenger = 0;
 }


if(CBU_GLOBAL.config.widget.tip_12==1){   
 var widget_name = 'widget';




 
 }
if(CBU_GLOBAL.config.widget.tip_12==0){
  time_change = 0;
widget_callback =1;
widget_chat = 0;
if(CBU_GLOBAL.config.widget.tip_1_social_on==1){
  time_change = 5;
widget_messenger = 1;
}
}
}



var neiros_new_time = 0;
time_widget = 20;
time_callback = CBU_GLOBAL.config.widget.tip_1_timer;

//var widget_name = 'callback'; //название виджета который будет показываться первый
//var widget_name = 'widget'; //название виджета который будет показываться первый
//var time_change = 5; //впемя через которое будет меняться виджет
/*Если time_change = 0 то береться название виджета callback или widget и он тогда показываеться без чередования */


var  window_wight = window.screen.availWidth;
function addIframe_calback(type,stat){

        var  window_wight = window.screen.availWidth;
        
        if(window_wight <= 450){
            divise = 'mobile';
            
        }
        else{
            divise = 'desctop';
        }
        type_new = '';
        content_new = '';
        if(divise === 'mobile' && (type === 'phone')){
                document.querySelector("#neiros__callback_before_iframe").classList.add("mobile");
                document.querySelector("#neiros__callback_before_iframe").classList.remove("neiros__slideUp");
                type_new = 'mobile neiros__slideUp'
                content_new = '';
         


        }
        else{
            document.querySelector("#neiros__callback_before_iframe").classList.remove("mobile");
        }


        list = document.querySelector("#neiros__callback_before_iframe");
        list.innerHTML = '<div class="neiros__closet-icon-modal '+type_new+'">'+content_new+'</div><iframe id="neiros__chat_iframe" class="active"  src="https://cloud.neiros.ru/xcallback/'+divise+'/'+neiros_visit+'/'+CBU_GLOBAL.config.widget.key+'/?promo='+sbjs.get.promo.code+'&type='+type+'&'+divise+'"  ></iframe><div class="neiros__copiright_new2">Виджет заряжен Neuron</div>'


        var elem = document.querySelectorAll(".neiros__btn_round");
        for (var i = 0; i < elem.length; i++) {
            elem[i].classList.remove("visionthis");
        }

        div = document.querySelector("#neiros__btn_block");
        classes = div.classList;
        classes.remove("visabled");
		if(stat === '0'){
        list = document.querySelector("#neiros__callback_before_iframe");
        list.style.display = 'block';}
 
        
        
        /*	list = document.querySelector("#neiros__chat_hello_window");
            list.style.display = 'none';	*/
    }
    

if(widget_name === 'widget' && time_change === 0){} 
else{
addIframe_calback('phone', '1');

}
if(widget_chat === 0){
	
	document.querySelector("#neiros__chat_start").style.display = 'none';
	}

function changes_widget(time_change){
	if(CBU_GLOBAL.config.widget.tip_12_write_chat === 0){
		document.querySelector("#neiros__messenger_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		}
	else{
   if(time_change === 0){
   if(widget_name === 'widget'){
	   document.querySelector("#neiros__messenger_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		}
	if(widget_name === 'callback'){
		document.querySelector("#neiros__messenger_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'block';
		}
	if(widget_name === 'messenger'){
		document.querySelector("#neiros__chat_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__messenger_start").style.display = 'block';
		}	
   } 
  else{ 
  
  if(widget_callback == 1 && widget_messenger == 1){
	  
	  if (!(neiros_new_time % time_change)) {
	if(widget_name === 'messenger'){
        if(!document.querySelector("#neiros__callback_start").classList.contains('neiros__start_btn_show')) {
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__messenger_start").style.display = 'block';
		widget_name = 'callback';
    	}
		}
	else{
    if(!document.querySelector("#neiros__messenger_start").classList.contains('rotate-btn')) {
		document.querySelector("#neiros__messenger_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'block';
		widget_name = 'messenger'
        }
		}
		}
	  
	  }
	  else{
	if(!getCookie('neiros__hello_window')){	
  	   start_time_widget = time_widget + 1;
	   end_time_widget = time_widget - 5;		
	if(neiros_new_time <= start_time_widget && neiros_new_time >= end_time_widget){
		
		if(!document.querySelector("#neiros__callback_start").classList.contains('neiros__start_btn_show')) {
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		widget_name = 'callback';
    
		}
		}
		
		else{
if (!(neiros_new_time % time_change)) {
	if(document.querySelector("#neiros__chat_hello_window").style.display === 'block'){
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		}
		else{


	if(widget_name === 'widget'){
        if(!document.querySelector("#neiros__callback_start").classList.contains('neiros__start_btn_show')) {
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		widget_name = 'callback';
    	}
		}
	else{
    if(!document.querySelector("#neiros__chat_start").classList.contains('neiros__start_btn_show')) {
		document.querySelector("#neiros__chat_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'block';
		widget_name = 'widget'
        }
		}
			
		}
		}
	}	
}

else{
	if (!(neiros_new_time % time_change)) {
	if(document.querySelector("#neiros__chat_hello_window").style.display === 'block'){
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		}
		else{


	if(widget_name === 'widget'){
        if(!document.querySelector("#neiros__callback_start").classList.contains('neiros__start_btn_show')) {
		document.querySelector("#neiros__callback_start").style.display = 'none';
		document.querySelector("#neiros__chat_start").style.display = 'block';
		widget_name = 'callback';
    	}
		}
	else{
    if(!document.querySelector("#neiros__chat_start").classList.contains('neiros__start_btn_show')) {
		document.querySelector("#neiros__chat_start").style.display = 'none';
		document.querySelector("#neiros__callback_start").style.display = 'block';
		widget_name = 'widget'
        }
		}
			
		}
		}
	
	}

		  }
  
  

       
    neiros_new_time++;
    setTimeout("changes_widget(time_change)", 1000); }  }
}

changes_widget(time_change);


neiros_time=0;

	
function inspekt_user_time(time_widget){
	
	
if(!getCookie('neiros__callback_show')){	


if(time_change == 0){
if(widget_name === 'callback'){
  if(neiros_time == time_callback){
  if(!document.querySelector("#neiros__callback_start").classList.contains('neiros__start_btn_show')) {
   document.querySelector(".neiros__start_btn_callback").classList.add("neiros__start_btn_show");
  document.querySelector(".neiros__start_btn_callback img").style.display = 'none';
  document.querySelector("#neiros__callback_before_iframe").style.display = 'block';
 createCookie('neiros__callback_show',1,1);
}
}
}
}
}	




if(!getCookie('neiros__hello_window')){	

if(time_change > 0){
if(CBU_GLOBAL.config.widget.tip_12_write_chat === 0){
	  if(neiros_time == time_widget){
  if(!document.querySelector("#neiros__chat_start").classList.contains('neiros__start_btn_show')) {
document.querySelector("#neiros__chat_hello_window").style.display = 'block';
 createCookie('neiros__hello_window',1,1);
}
}
	}else{
	if(widget_name === 'callback'){
    
  if(neiros_time == time_widget){
  if(!document.querySelector("#neiros__chat_start").classList.contains('neiros__start_btn_show')) {
  if(widget_callback == 1 && widget_messenger == 1){
}
else{
document.querySelector("#neiros__chat_hello_window").style.display = 'block';
 createCookie('neiros__hello_window',1,1);
 }
}
}


}
	}	

}
else{
if(widget_name === 'widget'){
  if(neiros_time == time_widget){
  if(!document.querySelector("#neiros__chat_start").classList.contains('neiros__start_btn_show')) {
document.querySelector("#neiros__chat_hello_window").style.display = 'block';
 createCookie('neiros__hello_window',1,1);
}
}
}
}
}
    neiros_time++;
    setTimeout("inspekt_user_time(time_widget)", 1000);
}
inspekt_user_time(time_widget)

/*messenger*/
mass = [];
mass.forEach.call( document.querySelectorAll('#neiros__messenger_start'), function(el) { el.addEventListener('click', function() { 
if(el.classList.contains('rotate-reverse-btn')){
	document.querySelector("#neiros__messenger_start").classList.remove('rotate-reverse-btn');
	document.querySelector("#neiros__messenger_start").classList.add('rotate-btn');
    document.querySelector(".neiros__messenger_block_vis").style.visibility = 'visible';
    
	document.querySelector("#neiros__messenger_block").classList.add('active');
	}
else{
	document.querySelector("#neiros__messenger_start").classList.remove('rotate-btn');
document.querySelector("#neiros__messenger_start").classList.add('rotate-reverse-btn');	
document.querySelector(".neiros__messenger_block_vis").style.visibility = 'hidden';
document.querySelector("#neiros__messenger_block").classList.remove('active');
	}	

 }, false);
})	

mass.forEach.call( document.querySelectorAll('.neiros__widget-link'), function(el) { el.addEventListener('mouseover', function() {
this.querySelector(".tooltiptext").classList.add("visablethis");

}, false);
})

mass.forEach.call( document.querySelectorAll('.neiros__widget-link'), function(el) { el.addEventListener('mouseout', function() {
this.querySelector(".tooltiptext").classList.remove("visablethis");

}, false);
})
/*messenger*/

function addIframe(){
var  window_wight = window.screen.availWidth;
if(window_wight <= 450){
divise = 'mobile';
neiros_class = '';
iframe_active = 'class="active"'
}
else{
divise = 'desctop';
neiros_class = '<div class="neiros__preloader_container neiros__scale-up-br"><div class="neiros__preloader"></div></div>';
iframe_active = ''
}
list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div><iframe onload="hiddenPreloader(this)"  '+iframe_active+' id="neiros__chat_iframe" src="https://cloud.neiros.ru/chat/'+divise+'/'+neiros_visit+'/'+CBU_GLOBAL.config.widget.key+'/?promo='+sbjs.get.promo.code+'&neirosphone='+DINAMICPHONE+'"  ></iframe>'+neiros_class+'<div class="neiros__copiright_new2">Виджет заряжен Neiros</div>'

}
function addIframe_new(type){
list = document.querySelector("#neiros__chat_before_iframe");
list.style.display = 'block';

list = document.querySelector("#neiros__chat_hello_window");
list.style.display = 'none';
var  window_wight = window.screen.availWidth;
if(window_wight <= 450){
divise = 'mobile';
neiros_class = '';
iframe_active = 'class="active"'
}
else{
divise = 'desctop';
neiros_class = '<div class="neiros__preloader_container neiros__scale-up-br"><div class="neiros__preloader"></div></div>';
iframe_active = ''
}
type_new = '';
content_new = '';
if(divise === 'mobile' && (type === 'phone' || type === 'lidi' || type === 'social')){
if(type === 'social'){
document.querySelector("#neiros__chat_before_iframe").classList.add("mobile");
document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__slideUp");
type_new = 'mobile2 '
content_new = '';
}
else{
document.querySelector("#neiros__chat_before_iframe").classList.add("mobile");
document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__slideUp");
type_new = 'mobile '
content_new = '';
}


}
else{
document.querySelector("#neiros__chat_before_iframe").classList.remove("mobile");
}

list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal '+type_new+'">'+content_new+'</div><iframe onload="hiddenPreloader(this)"  '+iframe_active+' id="neiros__chat_iframe" src="https://cloud.neiros.ru/chat/'+divise+'/'+neiros_visit+'/'+CBU_GLOBAL.config.widget.key+'/?promo='+sbjs.get.promo.code+'&type='+type+'&neirosphone='+DINAMICPHONE+'"  ></iframe>'+neiros_class+'<div class="neiros__copiright_new2">Виджет заряжен Neiros</div>'


var elem = document.querySelectorAll(".neiros__btn_round");
for (var i = 0; i < elem.length; i++) {
elem[i].classList.remove("visionthis");
}

div = document.querySelector("#neiros__btn_block");
classes = div.classList;
classes.remove("visabled");





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

}
else{


document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__fadeIn");








}








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
document.querySelector(".neiros__start_btn").classList.remove("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'block';
document.querySelector("#neiros__btn_block").classList.remove("visabled");

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

document.querySelector(".neiros__start_btn").classList.remove("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'block';
}
return false;
}
}, false);


document.addEventListener('click', function(e) {
if ( matches.call( e.target, '.neiros__closet-icon-modal, .neiros__closet-icon-modal img') ) {
	
document.querySelector(".neiros__start_btn").classList.remove("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'block';
 document.querySelector("#neiros__chat_before_iframe").style.display = 'none';
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
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="https://cloud.neiros.ru/chat/'+divise+'/'+neiros_visit+'/'+CBU_GLOBAL.config.widget.key+'/?promo='+sbjs.get.promo.code+'&neirosphone='+DINAMICPHONE+'"  ></iframe>';*/
}
document.addEventListener("DOMContentLoaded", ready);



{{--if(CBU_GLOBAL.config.widget.tip_timer_12>0){
if (get_cookie("olev_time_track_show") == null) {
xx=parseInt(olev_time_track)+parseInt(CBU_GLOBAL.config.widget.tip_timer_12);
console.log(xx);
console.log(time());
if(xx<time()){

list = document.querySelector("#neiros__chat_hello_window");alert(list);
list.style.display = 'block';
setCookie("olev_time_track_show", '123', {
expires: 900
});
}


}

}--}}

{{--скрипт появления--}}


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
list.innerHTML = '<div class="neiros__closet-icon-modal"></div><iframe id="neiros__chat_iframe" src="https://cloud.neiros.ru/chat/'+divise+'/'+neiros_visit+'/'+CBU_GLOBAL.config.widget.key+'/?promo='+sbjs.get.promo.code+'&neirosphone='+DINAMICPHONE+'"  ></iframe>'

}



function addIframe_new(type){

var  window_wight = window.screen.availWidth;
if(window_wight <= 450){
divise = 'mobile';
neiros_class = ''
iframe_active = 'class="active"'

}
else{
divise = 'desctop';
neiros_class = '<div class="neiros__preloader_container neiros__scale-up-br"><div class="neiros__preloader"></div></div>';
iframe_active = ''

}

document.querySelector("#neiros__chat_start").style.display = 'none';

type_new = '';
content_new = '';
if(divise === 'mobile' && (type === 'phone' || type === 'lidi' || type === 'social')){
if(type === 'social'){
document.querySelector("#neiros__chat_before_iframe").classList.add("mobile");
document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__slideUp");
type_new = 'mobile2 '
content_new = '';
}
else{
document.querySelector("#neiros__chat_before_iframe").classList.add("mobile");
document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__slideUp");
type_new = 'mobile '
content_new = '';
}


}
else{
document.querySelector("#neiros__chat_before_iframe").classList.remove("mobile");
}



list = document.querySelector("#neiros__chat_before_iframe");
list.innerHTML = '<div class="neiros__closet-icon-modal '+type_new+'">'+content_new+'</div><iframe onload="hiddenPreloader(this)" '+iframe_active+' id="neiros__chat_iframe"  src="https://cloud.neiros.ru/chat/'+divise+'/'+neiros_visit+'/'+CBU_GLOBAL.config.widget.key+'?type='+type+'&promo='+sbjs.get.promo.code+'&'+divise+'=1&neirosphone='+DINAMICPHONE+'"  ></iframe>'+neiros_class+'<div class="neiros__copiright_new2">Виджет заряжен Neiros</div>'




var elem = document.querySelectorAll(".neiros__btn_round");
for (var i = 0; i < elem.length; i++) {
elem[i].classList.remove("visionthis");
}

div = document.querySelector("#neiros__btn_block");
classes = div.classList;
classes.remove("visabled");
if(divise === 'mobile'){
	document.querySelector("html").classList.add("neiros-site-full-block");
	}

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


/*Callback*/




       
/*Callback*/
 if(window_wight >= 450){
            /*вывод услуг*/
            mass.forEach.call( document.querySelectorAll('#neiros__callback_start, #neiros__callback_start img'), function(el) {
                el.addEventListener('click', function() {
                
      document.querySelector(".neiros__start_btn_callback").classList.add("neiros__start_btn_show");
     document.querySelector(".neiros__start_btn_callback img").style.display = 'none';

        var  window_wight = window.screen.availWidth;
        if(window_wight <= 450){
         document.querySelector("html").classList.add("neiros-site-full-block");
        }

 		document.querySelector("#neiros__callback_before_iframe").style.display = 'block';

                }, false);
            })

        }
        else{

            document.querySelector("#neiros__callback_before_iframe").classList.remove("neiros__fadeIn");
           /* document.querySelector("#neiros__callback_before_iframe").classList.add("neiros__slideUp");*/




            mass.forEach.call( document.querySelectorAll('#neiros__callback_start, #neiros__callback_start img'), function(el) { el.addEventListener('click', function() {
		 document.querySelector(".neiros__start_btn_callback").classList.add("neiros__start_btn_show");
     document.querySelector(".neiros__start_btn_callback img").style.display = 'none';
		 var  window_wight = window.screen.availWidth;
        if(window_wight <= 450){
         document.querySelector("html").classList.add("neiros-site-full-block");
        }
		document.querySelector("#neiros__callback_before_iframe").style.display = 'block';
            }, false);
            })


        }







        document.addEventListener('click', function(e) {
            if ( matches.call( e.target, '.neiros__start_btn_callback_show') ) {

             document.querySelector(".neiros__start_btn_callback").classList.remove("neiros__start_btn_show");
            document.querySelector(".neiros__start_btn_callback img").style.display = 'block';
             document.querySelector("#neiros__callback_before_iframe").style.display = 'none';

                return false;
            }


        }, false);


        document.addEventListener('click', function(e) {
            if ( matches.call( e.target, '#neiros__callback_before_iframe .neiros__closet-icon-modal, #neiros__callback_before_iframe .neiros__closet-icon-modal img') ) {
               document.querySelector(".neiros__start_btn_callback").classList.remove("neiros__start_btn_show");
           		 document.querySelector(".neiros__start_btn_callback img").style.display = 'block';
                document.querySelector("#neiros__callback_before_iframe").style.display = 'none';
                document.querySelector("html").classList.remove("neiros-site-full-block");
                return false;
            }
        }, false);




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

/*active_chat = 0;
active_callback = 0;
active_formback = 0;
active_map = 0;
active_social = 0;*/

if(active__widget > 1){
var elem = document.querySelectorAll(".neiros__btn_round");
for (var i = 0; i < elem.length; i++) {
elem[i].classList.add("visionthis");
}
document.querySelector("#neiros__chat_hello_window").style.display = 'none';
document.querySelector(".neiros__start_btn").classList.add("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'none';
}
else{

document.querySelector("#neiros__chat_start").classList.add("neiros__chat_btn_one");
document.querySelector("#neiros__chat_start img").classList.add("neiros__chat_btn_one");
}


}, false);
})
}
else{

document.querySelector("#neiros__chat_before_iframe").classList.remove("neiros__fadeIn");





mass.forEach.call( document.querySelectorAll('#neiros__chat_start'), function(el) { el.addEventListener('click', function() {


if(active__widget > 1){
var elem = document.querySelectorAll(".neiros__btn_round");
for (var i = 0; i < elem.length; i++) {
elem[i].classList.remove("neiros__fadeIn");
}
document.querySelector("#neiros__btn_block").classList.add("visabled");
document.querySelector("#neiros__chat_hello_window").style.display = 'none';
document.querySelector(".neiros__start_btn").add("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'none';
}

else{

document.querySelector("#neiros__chat_hello_window").style.display = 'none'; 
document.querySelector(".neiros__start_btn").classList.add("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'none';
addIframe_new('chat');  
}



}, false);
})


}








/*Открыть чат*/
mass.forEach.call(
document.querySelectorAll('.neiros__open__chart'), function(el) {

el.addEventListener('click', function() {
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
document.addEventListener('click', function (e) {    
if (hasclass(e.target, 'neiros__chat_btn_one')) { 
document.querySelector("#neiros__chat_hello_window").style.display = 'none'; 
document.querySelector(".neiros__start_btn").classList.add("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'none';
addIframe_new('chat');  

} }, false);



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
document.querySelector(".neiros__start_btn").classList.remove("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'block';
document.querySelector("#neiros__btn_block").classList.remove("visabled");

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
	
document.querySelector(".neiros__start_btn").classList.remove("neiros__start_btn_show");
document.querySelector(".neiros__start_btn img").style.display = 'block';
document.querySelector("#neiros__chat_before_iframe").style.display = 'none';
document.querySelector("html").classList.remove("neiros-site-full-block");
return false;
}
}, false);

document.addEventListener('click', function(e) {
if ( matches.call( e.target, '#neiros__chat_before_iframe .neiros__closet-icon-modal, #neiros__chat_before_iframe  .neiros__closet-icon-modal img') ) {
document.querySelector(".neiros__start_btn").style.display = 'block';	

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
list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="https://cloud.neiros.ru/cdn/v1/chatv2/images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="chat.php?'+divise+'=1"  ></iframe>';*/
}
document.addEventListener("DOMContentLoaded", ready);
ready();