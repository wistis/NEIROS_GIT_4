<script>
    function add_test() {


        $('#add_test_modal').modal('show');
    }

    $('body').on('click','.clead_delete_ab',function () {
        id=$(this).data('id');
        formdata={
            id:id,
            form_action:'clead_delete_ab'


        };
        $('#costm'+id).remove();
        $.ajax({
            type: "POST",
            url: '/widget/safe',
            data: formdata,
            success: function (html1) {


            }
        })

    });

    $('body').on('click','.clead_edit_ab',function () {
        id=$(this).data('id');
        $('#add_test_modal').modal('show');
        formdata={
            id:id,
            form_action:'clead_edit_ab'


        };

        $.ajax({
            type: "POST",
            url: '/widget/safe',
            data: formdata,
            success: function (html1) {



                    $('#lead_ad_test').html(html1 );

            }
        })

    });


    $('.w_safebutton_adad').click(function () {

        formdata=$('#lead_ad_test').serialize();

my_id=$('#ab_id').val();

            $.ajax({
                type: "POST",
                url: '/widget/safe',
                data: formdata,
                success: function (html1) {

                    if (html1['status'] >0) {
                        $('#add_test_modal').modal('hide');
                        mynotif('Успешно', 'Данные успешно сохранены', 'info');

                        if(my_id>0){

                            $('#costm'+my_id).remove();
                        }
                        $('.table_costs').append(html1['data']);


                    } else {


                            mynotif('Ошибка', 'Что-то пошло не та', 'error')

                    }
                }
            })


    })
</script>