 
<script>
    
    function open_myModalBox_add_rout() {
        $('#myModalBox_add_rout').modal('show');
        $('#ar_id').val(0);

        load_free_numbers();
        $('#ar_id').val(0);


        $('#ar_name').val('');

        var radios = $('.ar_reditrect');
        radios.prop('checked', false);;

        radios.filter('[value=0]').prop('checked', true);

        $('#ar_phone_redirect0').val('');
        $('#ar_phone_redirect1').val('');
        $('#ar_phone_redirect2').val('');


        var tip_calltrack = $('.ar_tip_calltrack');
        tip_calltrack.prop('checked', false);;
        tip_calltrack.filter('[value=0]').prop('checked', true);
        load_free_numbers();

    }

    function delete_routing(ids) {
        new PNotify({
            title: 'успешно ',
            text: 'Изменения успешно сохранены',
            icon: 'icon-success'
        });

        $('#idsr' + ids).hide();
        datatosend = {



            ids: ids,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/delete_routiing_calltrack',
            data: datatosend,
            success: function (html1) {


            }
        })
    }
    function edit_routing(id) {
        datatosend = {



            ids: id,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/edit_routing_get',
            data: datatosend,
            success: function (html1) {

                $('#myModalBox_add_rout').modal('show');
                $('#ar_id').val(id);
                res=JSON.parse(html1);

                $('#utm_campaign').val(res['utm_campaign']);
                $('#utm_content').val(res['utm_content']);
                $('#utm_medium').val(res['utm_medium']);
                $('#utm_source').val(res['utm_source']);
                $('#utm_term').val(res['utm_term']);



                $('#ar_name').val(res['name']);

                var radios = $('.ar_reditrect');
                radios.prop('checked', false);;

                radios.filter('[value='+res['tip_redirect']+']').prop('checked', true);

                $('#ar_phone_redirect' + res['tip_redirect']).val(res['number_to']);


                var tip_calltrack = $('.ar_tip_calltrack');
                tip_calltrack.prop('checked', false);;
                tip_calltrack.filter('[value='+res['tip_calltrack']+']').prop('checked', true);

                if(res['tip_calltrack']==2){
                    $('.mymetki').show();
                }


                load_free_numbers();

            }
        })
    }

  
</script>