<script>    // Daterange picker
            // ------------------------------


    function addfast() {
        name=$('#name').val();




        datatosend = {
            name:name,

            _token: $('[name=_token]').val(),


        };
        $.ajax({
            type: "POST",
            url: '/ajax/addfast',
            data: datatosend,
            success: function (html1) {
                $('#table_costs').append(html1);
            }



        });


    }
    function deletefast(id) {
        datatosend = {
            id:id,

            _token: $('[name=_token]').val(),


        };
        $.ajax({
            type: "POST",
            url: '/ajax/deletefast',
            data: datatosend,
            success: function (html1) {
                $('#cost'+id).remove();
            }



        });
    }
</script>