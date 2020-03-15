


    <script>


        function clickchattema(id) {
            tema=$(id).data('tema');

            $.ajax({
                type: "POST",
                url: '/chat/clickchattema',
                data: '&tema='+tema,
                success: function (html1) {
                    result=JSON.parse(html1);
                    console.log(result);
                    $('.chat-list').html(result['messages'])
                    $('#name_client').html(result['usermess']['name'])
                    $('.btn-sendmess').show();
                    $('.enter-message').show();
                    $('#statusmark'+tema).hide();
                    $('#tektema').val(tema);
                    $('#temahash').val(result['hash']);
                    $('#temahashmd5').val(result['hashmd5']);
                    var divmm = $(".chat-list");
                    divmm.scrollTop(divmm.prop('scrollHeight'));
                }
            })

            z();
        }




    </script>

    <script>hash=$('#temahash').val();
        var socket ;
        var wsStatus=0;
        function wsfConnect()
        {
            socket=new WebSocket('wss://cloud.neiros.ru/wss2/{{$user->my_company_id}}');


            socket.onopen  = function(){console.log('open');wsStatus=1;};
            socket.onerror = function(error){console.log('error');};

        };
        wsfConnect();
        /**/
        socket.onclose = function(){console.log('close');wsStatus=0;wsfConnect();};


        /*Блок уведомления о том что оператор пишет*/
        $( ".enter-message").focus(function() {
            temahashmd5=  $('#temahashmd5').val();

            if(temahashmd5.length>2) {
                datas = {
                    message: 1,
                    hash: temahashmd5,
                    site: '',
                    admin: 1,
                    my_company_id: '{{md5($user->my_company_id)}}',
                    tip_message:0,
                    typ: 12
                }
                socket.send(JSON.stringify(datas))
            }


        });

        if ($(".enter-message").is(":focus")) {

        } else {
            if(wsStatus==1) {      z() ;}
        }

        function z() {
            temahashmd5 = $('#temahashmd5').val();
            ;
            if (temahashmd5.length > 2) {
                datas = {
                    message: 0,
                    hash: temahashmd5,
                    site: '',
                    admin: 1,
                    my_company_id: '{{md5($user->my_company_id)}}',
                    tip_message: 0,
                    typ: 12
                }
                socket.send(JSON.stringify(datas));
            }

        }



        socket.onmessage = messageReceived;


        function messageReceived(e) {


            datas=JSON.parse(e.data);

            var now = new Date();
            //  time = now.getHours() + ':' + now.getMinutes();
            /*    $('#neiros__talk_chat_box .neiros__talk_chat .neiros__talk_day').append('<div class="neiros__talk_text_operator_block"><div class="neiros__talk_text_operator"><div class="neiros__talk_time_comment">' + time + '</div>' + datas.message + '</div></div>');

                list = document.querySelector("#neiros__talk_chat_box .neiros__talk_chat");
                list.scrollTop = list.scrollHeight;*/




            userk=datas.hash;
            tip=datas.typ;
            if(tip==12){
                tema=$('#temahash').val();
            }else{
                tema=$('#tektema').val();
            }



            if(userk!=tema){

                console.log('not ==tema');
                if($("span").is('#statusmark'+datas.hash)){

                    $('#statusmark'+datas.hash).show();


                }else{
                    $.ajax({
                        type: "POST",
                        url: '/chat/get_tek_tema',
                        data: "&tema="+datas.hash,
                        success: function (html1) {
                            $('.temaclass').append(html1);

                        }
                    })
                }



            }else{
                tema=$('#tektema').val();
                $.ajax({
                    type: "POST",
                    url: '/chat/get_tek_mess',
                    data: '&message='+datas.hiddenmes+"&tema="+tema,
                    success: function (html1) {
                        result=JSON.parse(html1);




                        var div = $(".chat-list");
                        div.scrollTop(div.prop('scrollHeight'+1000));

                        $(result['messages']).appendTo($(".chat-list"));
                        $('.enter-message').val('');

                    }
                })
            }
            //   socket.emit('my other event', { my: 'data' });

        }






        function sendmess() {
            message=$('.enter-message').val();
            tema=  $('#tektema').val();
            temahashmd5=  $('#temahashmd5').val();
            $.ajax({
                type: "POST",
                url: '/chat/sendmess',
                data: '&tema='+tema+"&message="+message,
                success: function (html1) {
                    result=JSON.parse(html1);




                    var div = $(".chat-list");
                    div.scrollTop(div.prop('scrollHeight'));

                    $(result['messages']).appendTo($(".chat-list"));
                    $('.enter-message').val('');


                    datas = {
                        message: message,
                        hash: temahashmd5,
                        site: '',
                        admin: 1,
                        my_company_id:'{{md5($user->my_company_id)}}',
                        tip_message:1,
                        typ:12
                    }
                    socket.send(JSON.stringify(datas))






                }
            })
            z();
        }

    </script>



