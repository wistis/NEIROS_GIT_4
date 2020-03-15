<script>
    $('.edit_widget').click(function () {
        widget_id = $('#widget_id').val();
        widget_promokod_id = $('#widget_promokod_id').val();
        if($('#status').prop('checked')) {
            status=1;
        } else {
            status=0;
        }
        datatosend = {
            widget_id: widget_id,
            widget_promokod_id: widget_promokod_id,
            status:status,
            color: $('#color').val(),
            background: $('#background').val(),
            position_y: $('#position_y').val(),
            position_x: $('#position_x').val(),

            _token: $('[name=_token]').val(),



        }



        $.ajax({
            type: "POST",
            url: '/widget/safe',
            data: datatosend,
            success: function (html1) {

                $.jGrowl('Изменения успешно сохранены', {
                    header: 'Успешно!',
                    theme: 'bg-success'
                });

            }
        })


        return false;
    });



</script>