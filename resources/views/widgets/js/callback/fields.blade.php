<script>

    $('body').on('change','.selectfield',function () {
        id_field=$(this).data('id');
        value_field=$(this).val();

        $.ajax({
            type: "POST",
            url: '/ajax/set_form_fields',
            data: {

                id_field:id_field,
                value_field:value_field,

            },
            success: function (html1) {

                mynotif('Успешно','Данные успешно сохранены','info');
            }
        })

    })
</script>