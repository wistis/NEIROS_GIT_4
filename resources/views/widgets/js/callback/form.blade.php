<script>    // Daterange picker
            // ------------------------------



    function addcoastcanal() {
        cost_canal=$('#cost_canal').val();
        canal_summ=$('#canal_summ').val();
        cost_start_date = $('#cost_start_date').val();
        cost_end_date = $('#cost_end_date').val();



        datatosend = {
            cost_canal:cost_canal,
            canal_summ:canal_summ,
            cost_start_date:cost_start_date,
            cost_end_date:cost_end_date,
            _token: $('[name=_token]').val(),


        };
        $.ajax({
            type: "POST",
            url: '/ajax/addcanal',
            data: datatosend,
            success: function (html1) {
                $('#table_costs').append(html1);
            }



        });


    }
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