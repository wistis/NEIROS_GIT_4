var e = document.createElement("div");
e.className = "neiros_all_container";
e.innerHTML=`<link href="https://cloud.neiros.ru/cdn/v1/catch_lead/css/style_popup.css" rel="stylesheet" type="text/css">
<div id="neiros_pop-ups" class="neiros_pop-ups">

</div>


<div id="neiros__lead_catcher_before_iframe" class="" style="display:none;"></div>
<div id=a></div>`, document.body.appendChild(e);


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


neiros_time=getCookie('timer');
if (!neiros_time)
neiros_time=0;

function inspekt_user_time(){

neiros_time++;
createCookie('timer',neiros_time,365);
setTimeout("inspekt_user_time()", 1000);
}


var  window_wight = window.screen.availWidth;

function addIframe_leed_new(neiros_time,position,neiros_href_click){

var  window_wight = window.screen.availWidth;
if(window_wight <= 450){
divise = 'mobile';
}
else{
divise = 'desctop';
}


type_new = '';
content_new = '';
list = document.querySelector("#neiros__lead_catcher_before_iframe");
list.innerHTML = `
<div class="" style="width: 100%;height: 100%;">
    <div class="neiros__closet-icon-modal`+type_new+`">`+content_new+`</div>
    <iframe id="neiros__lead_catcher" src="https://cloud.neiros.ru/api/route_widget/catch_lead/`+divise+`/`+neiros_visit+`/`+CBU_GLOBAL.config.widget.key+`/?promo=`+sbjs.get.promo.code+`&time=`+neiros_time+`&neiros_url_vst=`+neiros_url_vst+`&neiros_href_click=`+neiros_href_click+`"></iframe>
    <div class="neiros__copiright_new2">Виджет заряжен Neiros</div>
</div>`
mass = [];
mass.forEach.call( document.querySelectorAll('.neiros__closet-icon-modal'), function(el) { el.addEventListener('click', function() {
document.querySelector("#neiros__lead_catcher_before_iframe").style.display = 'none';
return false;

}, false);
})


/*    list = document.querySelector("#neiros__chat_hello_window");
list.style.display = 'none';    */
}

function ready() {


inspekt_user_time()

}
document.addEventListener("DOMContentLoaded", ready);


// проверяем, есть ли у нас cookie, с которой мы не показываем окно и если нет, запускаем показ mouseleave
/*    addIframe_leed_new(neiros_time,position)*/
var alertwin = getCookie("alertwin");


if (alertwin != "no") {
addIframe_leed_new(13,'test','0')

}

var  window_wight = window.screen.availWidth;
 if(window_wight > 660){ 
  mass2 = [];
        mass2.forEach.call(document.querySelectorAll("a[href]"), function(el) {
          atribute = el.getAttribute('href');
          
        
	 	 if( atribute.indexOf('tel:') > -1){
    /*     atribute = atribute.replace("tel:","#tel");*/
	  el.removeAttribute("href", atribute);
		el.classList.add('neiros-click-lead')
     el.style.cursor = "pointer";
       
         }
    		
            });
      mass = [];
        mass.forEach.call( document.querySelectorAll('.neiros-click-lead'), function(el) { el.addEventListener('click', function() {
        

  var  window_wight = window.screen.availWidth;      
       
if(window_wight > 660){

	
      atribute = el.getAttribute('href');
    		
      	if(document.querySelector("#neiros__lead_catcher_before_iframe").getAttribute('class').indexOf('click-neiros') > -1){
     
         document.querySelector("#neiros__lead_catcher_before_iframe").classList.add('center');
		  document.querySelector("#neiros__lead_catcher_before_iframe").style.display = 'block';
         }
         
         else{
         
    
         document.querySelector("#neiros__lead_catcher_before_iframe").innerHTML = '';
         document.querySelector("#neiros__lead_catcher_before_iframe").classList.add('center');
          document.querySelector("#neiros__lead_catcher_before_iframe").classList.add('click-neiros');
		  document.querySelector("#neiros__lead_catcher_before_iframe").style.display = 'block';
		  addIframe_leed_new(13,'test','1')
         
         }
		
		  
	  }
            return false;

        }, false);
        })	
		

}		

document.addEventListener("mouseout", function(e){

var alertwin = getCookie("alertwin");


if (alertwin != "no") {
window_wight = window.screen.availWidth
window_wight = e.clientX*100/window_wight
if(window_wight >=0 && window_wight <=33){
position = 'left';
}
if(window_wight >33 && window_wight <=66){
position = 'center';
}
if(window_wight >66 && window_wight <=100){
position = 'right';
}

if (e.clientY < 0) {


document.querySelector("#neiros__lead_catcher_before_iframe").removeAttribute("class");
document.querySelector("#neiros__lead_catcher_before_iframe").classList.add(position);
document.querySelector("#neiros__lead_catcher_before_iframe").style.display = 'block';
var date = new Date;
date.setDate(date.getDate() + 1);

{{--document.cookie = "alertwin=no; path=/; expires=" + date.toUTCString();--}}
 if(CBU_GLOBAL.config.widget.tip_19_show==1){
document.cookie = "alertwin=no; path=/; expires=" + date.toUTCString();}
}    }
});
