<script>
    function get_dialog(id) {
        datatosend = {

            id:    id ,


            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/get_dialog',
            data: datatosend,
            success: function (html1) {

                $('#openmodal').modal('show');
                $('#get_dialog_html').html(html1);

            }
        });



    }
    function get_inputcall( ) {
        datatosend = {


            widget_id:$('#wid_id').val(),

            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/get_inputcall_back',
            data: datatosend,
            success: function (html1) {

                res=JSON.parse(html1);
                $('#winputcall').html(res['dat']);
                $('#pagin').html(res['pagin']);


            }
        });



    }

    get_inputcall( )


    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        $('#load a').css('color', '#dfecf6');
        var url = $(this).html();

        $.ajax({
            type: "POST",
            url: '/ajax/get_inputcall?page='+url,
            data: datatosend,
            success: function (html1) {

                res=JSON.parse(html1);
                $('#winputcall').html(res['dat']);
                $('#pagin').html(res['pagin']);


            }
        });
    });






</script>