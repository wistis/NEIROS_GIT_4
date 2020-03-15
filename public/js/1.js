function changes_widget(time_change){
    if(CBU_GLOBAL.config.widget.tip_12_write_chat === 0){
        document.querySelector("#neiros__callback_start").style.display = 'none';
        document.querySelector("#neiros__chat_start").style.display = 'block';
    }
    else{
        if(time_change === 0){
            if(widget_name === 'widget'){
                document.querySelector("#neiros__callback_start").style.display = 'none';
                document.querySelector("#neiros__chat_start").style.display = 'block';
            }
            else{
                document.querySelector("#neiros__chat_start").style.display = 'none';
                document.querySelector("#neiros__callback_start").style.display = 'block';
            }
        }
        else{

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


            neiros_new_time++;
            setTimeout("changes_widget(time_change)", 1000); }  }
}