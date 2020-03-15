<script>function add_phone() {
        myform=$('#caltrackinbyphone').serialize();

        $('#myModalBox').modal('hide');



        mynotif('Успешно','Запрос на покупку номеров отправлен','info');

        $.ajax({
            type: "POST",
            url: '/widget/addphone',
            data: myform,
            success: function (html1) {
                if (html1['status'] == 0) {

                    mynotif('Ошибка',html1['message'],'error')
                } else {



                    mynotif('Успешно','Вы успешно купили ' + html1['message'] + ' номеров','info');
                    window.location.reload();

                }


            }
        })
    }
    function delete_number(number, ids) {

        mynotif('Успешно','Изменения приняты успешно','info');



        $('#ids' + ids).hide();
        datatosend = {
            number: number,
            ids: ids,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/widget/deletephone',
            data: datatosend,
            success: function (html1) {


            }
        })
    }
    function delete_from_routing() {
        my_numberscheckbox = [];
        $('.my_numberscheckbox:checked').each(function () {
            my_numberscheckbox.push($(this).val());
            $('#phoneroutname'+$(this).val()).html('');
        });

         mynotif('Успешно','Изменения приняты успешно','info');
        datatosend = {

            numbers: my_numberscheckbox,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/delete_from_routing',
            data: datatosend,
            success: function (html1) {


            }
        })


    }

</script>