<script>
    function open_email(id) {
        datatosend = {
            id: id,

            _token: $('[name=_token]').val(),


        }


        $.ajax({
            type: "POST",
            url: '/projects/get_email_modal',
            data: datatosend,
            success: function (html1) {
                res = JSON.parse(html1);
                $('#e_subject').html(res['subject']);
                $('#e_from').html(res['from']);
                $('#e_to').html(res['to']);
                $('#e_message').html(res['message']);

                $('#myModalEmail').modal('show');

            }
        })
    }
</script>