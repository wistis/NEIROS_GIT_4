
    var e = document.createElement("div");
/*   list = document.querySelector("#neiros__chat_hello_window");
        list.style.display = 'none';*/

     e.innerHTML = '<link href="https://cloud.neiros.ru/cdn/v1/chat/css/style_frontend.css" rel="stylesheet" type="text/css"><div id="neiros__chat_start" class="neiros__start_btn neiros__fadeIn" style="z-index: 9999">\n' +
         '<img src="https://cloud.neiros.ru/cdn/v1/chat/images/agent.png" alt="">\n' +
         '</div>\n' +
         '<div id="neiros__chat_hello_window" class="neiros__fadeIn" style="z-index: 9999;display: none">\n' +
         '<img class="neiros__closet__hello_window" src="images/icons/closet-icon-modal.PNG" alt="">\n' +
         '    <div class="neiros__operator__name">'+CBU_GLOBAL.config.widget.tip_name_12+'</div>\n' +
         '    <div class="neiros__operator__dol">'+CBU_GLOBAL.config.widget.tip_who_12+'</div>\n' +
         '    <div class="neiros__operator__text">'+CBU_GLOBAL.config.widget.tip_mess_12+'</div>\n' +
         '    <div class="neiros__open__chart">ответить</div>\t\n' +
         '</div>\n' +
         '<div id="neiros__chat_before_iframe" class="neiros__fadeIn" style="display:none;z-index: 9999" >\n' +
         '\n' +
         '\n' +
         '</div>', document.body.appendChild(e);

 
if(CBU_GLOBAL.config.widget.tip_timer_12>0){  console.log(time());
    if (get_cookie("olev_time_track_show") == null) {
        xx=parseInt(olev_time_track)+parseInt(CBU_GLOBAL.config.widget.tip_timer_12);
        console.log(xx);
        console.log(time());
if(xx<time()){

    list = document.querySelector("#neiros__chat_hello_window");
    list.style.display = 'block';
    setCookie("olev_time_track_show", '123', {
        expires: 900
    });
}


    }

}
    list = document.querySelector("#neiros__chat_hello_window");
    list.style.display = 'block';


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
    list.innerHTML = '<div class="neiros__closet-icon-modal"><img  src="https://cloud.neiros.ru/cdn/v1/chat/images/icons/closet-icon-modal.PNG" alt=""></div><iframe id="neiros__chat_iframe" src="https://cloud.neiros.ru/chat/'+divise+'/'+sbjs.get.first_add.hash+'/'+CBU_GLOBAL.config.widget.key+'"  ></iframe>';
}
    ready();
//document.addEventListener("DOMContentLoaded", );
