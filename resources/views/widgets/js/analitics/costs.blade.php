<script>    // Daterange picker
    // ------------------------------



function deletecanal(id) {
    datatosend = {
        id:id,

        _token: $('[name=_token]').val(),


    };
    $.ajax({
        type: "POST",
        url: '/ajax/deletecanal',
        data: datatosend,
        success: function (html1) {
            $('#cost'+id).remove();
        }



    });
}
</script>