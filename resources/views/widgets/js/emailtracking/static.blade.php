<script>
    function addcanalems() {
        canal=$('#canal').val();




        datatosend = {
            canal:canal,

            _token: $('[name=_token]').val(),


        };
        $.ajax({
            type: "POST",
            url: '/ajax/addcanalems',
            data: datatosend,
            success: function (html1) {
                $('#table_costs').append(html1);
            }



        });


    }
    function deletecanalems(id) {
        datatosend = {
            id:id,

            _token: $('[name=_token]').val(),


        };
        $.ajax({
            type: "POST",
            url: '/ajax/deletecanalems',
            data: datatosend,
            success: function (html1) {
                $('#cost'+id).remove();
            }



        });
    }


</script>
