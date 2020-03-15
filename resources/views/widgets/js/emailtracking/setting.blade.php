<script>
    function test_email(){
        datatosend = {

            email: $('#email').val(),
            server1: $('#server').val(),
            login: $('#login').val(),
            password: $('#password').val(),

            _token: $('[name=_token]').val(),



        }

console.log(datatosend);

        $.ajax({
            type: "POST",
            url: '/widgetd/imap_test',
            data: datatosend,
            success: function (html1) {
                if(html1==1){
                     
                    mynotif('Успешно','Соединение установлено','success')
                }else{
                    mynotif('Ошибка','Что-то пошло не так','error')
                }


            }
        })


        return false;



    }
</script>